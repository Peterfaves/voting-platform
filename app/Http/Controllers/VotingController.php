<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Services\PaystackService;

class VotingController extends Controller
{
    protected $paystack;

    public function __construct(PaystackService $paystack)
    {
        $this->paystack = $paystack;
    }

    public function show(Contestant $contestant)
    {
        $contestant->load('category.event');
        $event = $contestant->category->event;
        $category = $contestant->category;
        
        // Check if voting is active
        if ($event->status !== 'active') {
            return redirect()->route('home')->with('error', 'Voting is not currently active for this event.');
        }
        
        if ($contestant->status !== 'active') {
            return redirect()->route('home')->with('error', 'This contestant is not available for voting.');
        }

        $paystackPublicKey = $this->paystack->getPublicKey();
        
        return view('voting.show', compact('contestant', 'event', 'category', 'paystackPublicKey'));
    }

    public function initiate(Request $request, Contestant $contestant)
    {
        $validated = $request->validate([
            'voter_name' => 'required|string|max:255',
            'voter_email' => 'required|email',
            'voter_phone' => 'nullable|string|max:20',
            'number_of_votes' => 'required|integer|min:1|max:1000',
        ]);

        $contestant->load('category.event');
        $event = $contestant->category->event;

        // Check if voting is active
        if ($event->status !== 'active') {
            return back()->with('error', 'Voting is not active for this event.');
        }

        $amount = $event->vote_price * $validated['number_of_votes'];
        $reference = 'VOTE-' . strtoupper(Str::random(12));

        try {
            $vote = Vote::create([
                'contestant_id' => $contestant->id,
                'user_id' => auth()->id(),
                'voter_name' => $validated['voter_name'],
                'voter_email' => $validated['voter_email'],
                'voter_phone' => $validated['voter_phone'] ?? null,
                'number_of_votes' => $validated['number_of_votes'],
                'vote_count' => $validated['number_of_votes'], // For backward compatibility
                'amount_paid' => $amount,
                'payment_reference' => $reference,
                'payment_status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            Log::info('Vote created', [
                'vote_id' => $vote->id, 
                'reference' => $reference,
                'amount' => $amount
            ]);

            // Initialize payment with Paystack
            $metadata = [
                'vote_id' => $vote->id,
                'contestant_name' => $contestant->name,
                'category_name' => $contestant->category->name,
                'event_name' => $event->name,
                'number_of_votes' => $validated['number_of_votes'],
            ];

            $response = $this->paystack->initializeTransaction(
                $vote->voter_email,
                $amount,
                $reference,
                $metadata,
                route('voting.callback')
            );

            Log::info('Paystack initialization response', ['response' => $response]);

            if (isset($response['status']) && $response['status']) {
                return redirect($response['data']['authorization_url']);
            }

            $errorMsg = $response['message'] ?? 'Payment initialization failed';
            Log::error('Paystack initialization failed', ['response' => $response]);

            return back()->with('error', $errorMsg);
            
        } catch (\Exception $e) {
            Log::error('Vote creation/payment failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to process vote: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        
        if (!$reference) {
            return redirect()->route('home')->with('error', 'Invalid payment reference');
        }

        try {
            Log::info('Payment callback received', ['reference' => $reference]);

            // Verify transaction with Paystack
            $response = $this->paystack->verifyTransaction($reference);
            
            Log::info('Paystack verification response', ['response' => $response]);

            if (!isset($response['status']) || !$response['status']) {
                throw new \Exception('Payment verification failed: ' . ($response['message'] ?? 'Unknown error'));
            }

            if ($response['data']['status'] !== 'success') {
                throw new \Exception('Payment was not successful');
            }

            $data = $response['data'];

            $vote = Vote::where('payment_reference', $reference)->first();
            
            if (!$vote) {
                throw new \Exception('Vote not found for reference: ' . $reference);
            }
            
            if ($vote->payment_status === 'success') {
                Log::info('Vote already processed', ['vote_id' => $vote->id]);
                return redirect()->route('voting.success', $vote);
            }

            // Verify amount
            $expectedAmount = $vote->amount_paid * 100; // Convert to kobo
            if ($data['amount'] != $expectedAmount) {
                $vote->update(['payment_status' => 'failed']);
                throw new \Exception('Payment amount mismatch. Expected: ' . $expectedAmount . ', Got: ' . $data['amount']);
            }

            // Update vote and increment contestant votes
            DB::transaction(function () use ($vote, $data) {
                $vote->update([
                    'payment_status' => 'success',
                    'payment_method' => $data['channel'] ?? 'card',
                    'gateway_transaction_id' => $data['id'] ?? null,
                    'gateway_reference' => $data['reference'] ?? null,
                    'verified_at' => now(),
                ]);
                
                // Increment contestant votes
                $vote->contestant->increment('total_votes', $vote->number_of_votes);
                
                Log::info('Vote successfully processed', [
                    'vote_id' => $vote->id,
                    'contestant_id' => $vote->contestant_id,
                    'votes_added' => $vote->number_of_votes,
                ]);
            });

            return redirect()->route('voting.success', $vote);
            
        } catch (\Exception $e) {
            Log::error('Payment callback error', [
                'reference' => $reference,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('home')
                ->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    public function success(Vote $vote)
    {
        if ($vote->payment_status !== 'success') {
            return redirect()->route('home')->with('error', 'Payment not completed.');
        }

        return view('voting.success', compact('vote'));
    }
}