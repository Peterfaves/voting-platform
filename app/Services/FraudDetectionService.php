<?php

namespace App\Services;

use App\Models\Vote;
use Illuminate\Support\Facades\Cache;

class FraudDetectionService
{
    /**
     * Check if voting attempt is suspicious
     * 
     * @param array $data - Voter data (phone, email, vote_count)
     * @param string|null $ipAddress - Voter's IP address
     * @return array - List of fraud flags detected
     */
    public function isSuspicious(array $data, ?string $ipAddress = null): array
    {
        $flags = [];

        //  CHECK #1: Too many votes from same phone number
        $phoneVoteCount = Vote::where('voter_phone', $data['voter_phone'])
            ->where('created_at', '>', now()->subHours(24))
            ->count();

        if ($phoneVoteCount > 10) {
            $flags[] = 'too_many_votes_same_phone';
        }

        //  CHECK #2: Rapid voting from same phone (less than 1 minute)
        $recentVoteByPhone = Vote::where('voter_phone', $data['voter_phone'])
            ->where('created_at', '>', now()->subMinutes(1))
            ->exists();

        if ($recentVoteByPhone) {
            $flags[] = 'rapid_voting_same_phone';
        }

        //  CHECK #3: Too many votes from same IP address
        if ($ipAddress) {
            $ipVoteCount = Vote::where('ip_address', $ipAddress)
                ->where('created_at', '>', now()->subHours(24))
                ->count();

            if ($ipVoteCount > 15) {
                $flags[] = 'too_many_votes_same_ip';
            }

            //  CHECK #4: Rapid voting from same IP
            $recentVoteByIp = Vote::where('ip_address', $ipAddress)
                ->where('created_at', '>', now()->subMinutes(1))
                ->exists();

            if ($recentVoteByIp) {
                $flags[] = 'rapid_voting_same_ip';
            }

            //  CHECK #5: Multiple phone numbers from same IP (Account farming)
            $distinctPhones = Vote::where('ip_address', $ipAddress)
                ->where('created_at', '>', now()->subHours(24))
                ->distinct('voter_phone')
                ->count('voter_phone');

            if ($distinctPhones > 5) {
                $flags[] = 'multiple_phones_same_ip';
            }

            //  CHECK #6: Same IP voting for same contestant multiple times
            if (isset($data['contestant_id'])) {
                $sameContestantVotes = Vote::where('ip_address', $ipAddress)
                    ->where('contestant_id', $data['contestant_id'])
                    ->where('created_at', '>', now()->subHours(24))
                    ->count();

                if ($sameContestantVotes > 5) {
                    $flags[] = 'same_ip_same_contestant_repetitive';
                }
            }
        }

        //  CHECK #7: Unusually high vote count
        if (isset($data['vote_count']) && $data['vote_count'] > 100) {
            $flags[] = 'unusually_high_vote_count';
        }

        //  CHECK #8: Suspicious email patterns
        if (isset($data['voter_email']) && $this->isSuspiciousEmail($data['voter_email'])) {
            $flags[] = 'suspicious_email_pattern';
        }

        //  CHECK #9: VPN/Proxy detection (optional - basic check)
        if ($ipAddress && $this->isPotentialVPN($ipAddress)) {
            $flags[] = 'potential_vpn_detected';
        }

        return $flags;
    }

    /**
     * Check if email is suspicious (temporary/disposable email services)
     */
    private function isSuspiciousEmail(?string $email): bool
    {
        if (!$email) {
            return false;
        }

        // List of known temporary/disposable email services
        $suspiciousPatterns = [
            'tempmail',
            'throwaway', 
            'guerrillamail',
            '10minutemail',
            'mailinator',
            'fakeemail',
            'disposable',
            'yopmail',
            'trashmail',
            'maildrop',
            'getnada',
            'temp-mail',
            'minuteinbox',
            'sharklasers',
            'guerrillamail'
        ];

        $emailLower = strtolower($email);

        foreach ($suspiciousPatterns as $pattern) {
            if (str_contains($emailLower, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Basic VPN/Proxy detection
     * Note: This is a simple check. For production, consider using services like:
     * - IPHub
     * - IP2Proxy
     * - MaxMind GeoIP2
     */
    private function isPotentialVPN(?string $ipAddress): bool
    {
        if (!$ipAddress) {
            return false;
        }

        // Don't flag localhost/private IPs
        if (in_array($ipAddress, ['127.0.0.1', '::1']) || 
            str_starts_with($ipAddress, '192.168.') ||
            str_starts_with($ipAddress, '10.')) {
            return false;
        }

        // Check if IP is in cache (to avoid repeated checks)
        $cacheKey = "vpn_check_{$ipAddress}";
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // For now, just return false
        // In production, integrate with a VPN detection API
        $isVPN = false;

        // Cache result for 24 hours
        Cache::put($cacheKey, $isVPN, now()->addHours(24));

        return $isVPN;
    }

    /**
     * Determine if the vote should be blocked
     */
    public function shouldBlock(array $flags): bool
    {
        // Critical flags that warrant immediate blocking
        $criticalFlags = [
            'rapid_voting_same_phone',
            'rapid_voting_same_ip',
            'too_many_votes_same_phone',
            'too_many_votes_same_ip',
            'multiple_phones_same_ip',
        ];
        
        // Block if ANY critical flag is present
        return !empty(array_intersect($flags, $criticalFlags));
    }

    /**
     * Get a human-readable description of fraud flags
     */
    public function describeFraudFlags(array $flags): string
    {
        $descriptions = [
            'too_many_votes_same_phone' => '📱 Too many votes from this phone number today',
            'rapid_voting_same_phone' => '⚡ Voting too quickly from this phone',
            'too_many_votes_same_ip' => '🌐 Too many votes from this internet connection',
            'rapid_voting_same_ip' => '⚡ Voting too quickly from this internet connection',
            'multiple_phones_same_ip' => '🔄 Multiple phone numbers used from same location',
            'same_ip_same_contestant_repetitive' => '🎯 Repetitive voting for same contestant from this location',
            'unusually_high_vote_count' => '💰 Trying to purchase an unusual amount of votes',
            'suspicious_email_pattern' => '📧 Using a temporary/disposable email address',
            'potential_vpn_detected' => '🔒 Potential VPN/Proxy usage detected',
        ];

        $messages = [];
        foreach ($flags as $flag) {
            if (isset($descriptions[$flag])) {
                $messages[] = $descriptions[$flag];
            }
        }

        return implode(', ', $messages);
    }

    /**
     * Get fraud risk level based on flags
     * 
     * @return string - 'low', 'medium', 'high', 'critical'
     */
    public function getRiskLevel(array $flags): string
    {
        if (empty($flags)) {
            return 'low';
        }

        $criticalFlags = [
            'rapid_voting_same_phone',
            'rapid_voting_same_ip',
            'too_many_votes_same_phone',
            'too_many_votes_same_ip',
            'multiple_phones_same_ip',
        ];

        $highRiskFlags = [
            'same_ip_same_contestant_repetitive',
            'unusually_high_vote_count',
        ];

        // Critical if any critical flag
        if (!empty(array_intersect($flags, $criticalFlags))) {
            return 'critical';
        }

        // High if any high risk flag
        if (!empty(array_intersect($flags, $highRiskFlags))) {
            return 'high';
        }

        // Medium if 2+ flags
        if (count($flags) >= 2) {
            return 'medium';
        }

        return 'low';
    }

    /**
     * Log fraud attempt for analysis
     */
    public function logFraudAttempt(array $data, array $flags, ?string $ipAddress = null): void
    {
        if (empty($flags)) {
            return;
        }

        \Log::channel('fraud')->warning('Fraud detection triggered', [
            'flags' => $flags,
            'risk_level' => $this->getRiskLevel($flags),
            'description' => $this->describeFraudFlags($flags),
            'voter_phone' => $data['voter_phone'] ?? null,
            'voter_email' => $data['voter_email'] ?? null,
            'vote_count' => $data['vote_count'] ?? null,
            'ip_address' => $ipAddress,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}