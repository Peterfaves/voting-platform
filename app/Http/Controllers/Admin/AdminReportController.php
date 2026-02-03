<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    /**
     * Display a listing of reports and flagged content.
     */
    public function index(Request $request)
    {
        // If you have a Report model, use it here
        // For now, we'll show suspicious activity based on patterns

        // Detect suspicious voting patterns
        $suspiciousActivity = $this->detectSuspiciousActivity();

        // Get recent high-value transactions
        $highValueTransactions = DB::table('votes')
            ->where('payment_status', 'success')
            ->where('amount_paid', '>=', 50000) // ₦50,000+
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        // Get failed transaction patterns (potential fraud)
        $failedPatterns = DB::table('votes')
            ->select('voter_email', DB::raw('COUNT(*) as failed_count'))
            ->where('payment_status', 'failed')
            ->groupBy('voter_email')
            ->having('failed_count', '>=', 5)
            ->orderByDesc('failed_count')
            ->take(20)
            ->get();

        // Stats
        $stats = [
            'suspicious_count' => count($suspiciousActivity),
            'high_value_count' => count($highValueTransactions),
            'failed_patterns_count' => count($failedPatterns),
        ];

        return view('admin.reports.index', compact(
            'suspiciousActivity',
            'highValueTransactions',
            'failedPatterns',
            'stats'
        ));
    }

    /**
     * Detect suspicious voting patterns.
     */
    protected function detectSuspiciousActivity(): array
    {
        $suspicious = [];

        // Pattern 1: Same email voting multiple times in short period
        $rapidVoting = DB::table('votes')
            ->select('voter_email', 'contestant_id', DB::raw('COUNT(*) as vote_count'), DB::raw('MIN(created_at) as first_vote'), DB::raw('MAX(created_at) as last_vote'))
            ->where('payment_status', 'success')
            ->where('created_at', '>=', now()->subHours(24))
            ->groupBy('voter_email', 'contestant_id')
            ->having('vote_count', '>=', 10)
            ->get();

        foreach ($rapidVoting as $activity) {
            $suspicious[] = [
                'type' => 'rapid_voting',
                'description' => "Email {$activity->voter_email} cast {$activity->vote_count} votes for contestant #{$activity->contestant_id} in 24 hours",
                'severity' => $activity->vote_count > 50 ? 'high' : 'medium',
                'data' => $activity,
            ];
        }

        // Pattern 2: Single IP with multiple different emails
        // (Would need IP tracking in votes table)

        // Pattern 3: Unusual vote amounts
        $unusualAmounts = DB::table('votes')
            ->where('payment_status', 'success')
            ->where('amount_paid', '>=', 100000) // ₦100,000+ single transaction
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        foreach ($unusualAmounts as $vote) {
            $suspicious[] = [
                'type' => 'high_value',
                'description' => "Unusually high transaction of ₦" . number_format($vote->amount_paid) . " by {$vote->voter_email}",
                'severity' => 'medium',
                'data' => $vote,
            ];
        }

        return $suspicious;
    }

    /**
     * Resolve a report.
     */
    public function resolve(Request $request, $reportId)
    {
        // Implement based on your Report model
        $request->validate([
            'action' => 'required|in:suspend_user,suspend_event,dismiss,warn',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Log the action
        AuditLog::log(
            auth()->user(),
            'resolve_report',
            null,
            "Resolved report #{$reportId} with action: {$request->action}"
        );

        return back()->with('success', 'Report resolved successfully.');
    }

    /**
     * Dismiss a report.
     */
    public function dismiss(Request $request, $reportId)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        AuditLog::log(
            auth()->user(),
            'dismiss_report',
            null,
            "Dismissed report #{$reportId}. Reason: {$request->reason}"
        );

        return back()->with('success', 'Report dismissed.');
    }
}
