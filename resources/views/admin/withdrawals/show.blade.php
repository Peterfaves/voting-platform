@extends('admin.layouts.admin')

@section('title', 'Review Withdrawal #' . $withdrawal->id)

@section('breadcrumb')
<a href="{{ route('admin.withdrawals.index') }}">Withdrawals</a>
<i class="fas fa-chevron-right"></i>
<span>Review #{{ $withdrawal->id }}</span>
@endsection

@section('content')
<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
    <div class="page-header" style="margin-bottom: 0;">
        <h1 class="page-title">Withdrawal Request #WD{{ str_pad($withdrawal->id, 5, '0', STR_PAD_LEFT) }}</h1>
        <p class="page-subtitle">Submitted {{ $withdrawal->created_at->format('F d, Y \a\t h:i A') }}</p>
    </div>
    <div>
        @if($withdrawal->status === 'pending')
            <span class="badge badge-warning" style="font-size: 14px; padding: 8px 16px;">
                <i class="fas fa-clock"></i> Pending Review
            </span>
        @elseif($withdrawal->status === 'approved')
            <span class="badge badge-success" style="font-size: 14px; padding: 8px 16px;">
                <i class="fas fa-check"></i> Approved
            </span>
        @elseif($withdrawal->status === 'rejected')
            <span class="badge badge-danger" style="font-size: 14px; padding: 8px 16px;">
                <i class="fas fa-times"></i> Rejected
            </span>
        @elseif($withdrawal->status === 'completed')
            <span class="badge badge-success" style="font-size: 14px; padding: 8px 16px;">
                <i class="fas fa-check-double"></i> Completed
            </span>
        @endif
    </div>
</div>

<div class="grid-2">
    <!-- Left Column - Withdrawal Details -->
    <div>
        <!-- Amount Breakdown -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calculator"></i>
                    Amount Breakdown
                </h3>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-medium);">Requested Amount</span>
                    <span style="font-size: 20px; font-weight: 700;">₦{{ number_format($withdrawal->amount, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-medium);">Platform Fee ({{ \App\Models\Setting::getPlatformFee() }}%)</span>
                    <span style="font-size: 18px; font-weight: 600; color: var(--danger);">-₦{{ number_format($withdrawal->platform_fee, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 16px 0; background: var(--success-bg); margin: 16px -24px -24px; padding: 20px 24px; border-radius: 0 0 16px 16px;">
                    <span style="font-weight: 600; color: var(--success);">Net Payout</span>
                    <span style="font-size: 24px; font-weight: 700; color: var(--success);">₦{{ number_format($withdrawal->net_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Bank Details -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-university"></i>
                    Bank Details
                </h3>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light); width: 40%;">Bank Name</td>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600;">{{ $withdrawal->bank_name ?? $withdrawal->user->bank_name ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Account Number</td>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600; font-family: monospace; font-size: 16px;">{{ $withdrawal->account_number ?? $withdrawal->user->account_number ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; color: var(--text-light);">Account Name</td>
                        <td style="padding: 12px 0; font-weight: 600;">{{ $withdrawal->account_name ?? $withdrawal->user->account_name ?? 'Not set' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Organizer Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    Organizer Information
                </h3>
                <a href="{{ route('admin.users.show', $withdrawal->user) }}" class="btn btn-secondary btn-sm">View Profile</a>
            </div>
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <div class="user-avatar" style="width: 56px; height: 56px; font-size: 20px;">
                        {{ strtoupper(substr($withdrawal->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h4 style="font-weight: 600; font-size: 16px;">{{ $withdrawal->user->name ?? 'Unknown' }}</h4>
                        <p style="color: var(--text-light);">{{ $withdrawal->user->email ?? '' }}</p>
                    </div>
                </div>
                <div class="grid-2" style="gap: 16px;">
                    <div style="padding: 16px; background: var(--main-bg); border-radius: 10px;">
                        <p style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Total Earnings</p>
                        <p style="font-size: 18px; font-weight: 700;">₦{{ number_format($userEarnings ?? 0) }}</p>
                    </div>
                    <div style="padding: 16px; background: var(--main-bg); border-radius: 10px;">
                        <p style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Available Balance</p>
                        <p style="font-size: 18px; font-weight: 700; color: var(--success);">₦{{ number_format($availableBalance ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Actions -->
    <div>
        @if($withdrawal->status === 'pending')
            <!-- Approve/Reject Actions -->
            <div class="card mb-6">
                <div class="card-header" style="background: var(--success-bg);">
                    <h3 class="card-title" style="color: var(--success);">
                        <i class="fas fa-check-circle"></i>
                        Approve Withdrawal
                    </h3>
                </div>
                <div class="card-body">
                    <p style="color: var(--text-medium); margin-bottom: 20px;">
                        Approving this withdrawal will authorize the transfer of <strong>₦{{ number_format($withdrawal->net_amount, 2) }}</strong> to the organizer's bank account.
                    </p>
                    <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}">
                        @csrf
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Admin Notes (Optional)</label>
                            <textarea name="notes" rows="3" placeholder="Any notes for this approval..."
                                      style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" style="width: 100%;" onclick="return confirm('Approve this withdrawal of ₦{{ number_format($withdrawal->net_amount, 2) }}?')">
                            <i class="fas fa-check"></i>
                            Approve Withdrawal
                        </button>
                    </form>
                </div>
            </div>

            <div class="card" style="border-color: var(--danger);">
                <div class="card-header" style="background: var(--danger-bg);">
                    <h3 class="card-title" style="color: var(--danger);">
                        <i class="fas fa-times-circle"></i>
                        Reject Withdrawal
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}">
                        @csrf
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Reason for Rejection <span style="color: var(--danger);">*</span></label>
                            <textarea name="rejection_reason" rows="3" required placeholder="Explain why this withdrawal is being rejected..."
                                      style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger" style="width: 100%;">
                            <i class="fas fa-times"></i>
                            Reject Withdrawal
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Status Info -->
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Processing Information
                    </h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Status</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                                <span class="badge badge-{{ $withdrawal->status === 'approved' || $withdrawal->status === 'completed' ? 'success' : 'danger' }}">
                                    {{ ucfirst($withdrawal->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Processed By</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600;">{{ $withdrawal->processor->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Processed At</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600;">{{ $withdrawal->processed_at ? $withdrawal->processed_at->format('M d, Y h:i A') : 'N/A' }}</td>
                        </tr>
                        @if($withdrawal->transaction_reference)
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Transaction Ref</td>
                                <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600; font-family: monospace;">{{ $withdrawal->transaction_reference }}</td>
                            </tr>
                        @endif
                        @if($withdrawal->rejection_reason)
                            <tr>
                                <td style="padding: 12px 0; color: var(--text-light);">Rejection Reason</td>
                                <td style="padding: 12px 0; color: var(--danger);">{{ $withdrawal->rejection_reason }}</td>
                            </tr>
                        @endif
                        @if($withdrawal->admin_notes)
                            <tr>
                                <td style="padding: 12px 0; color: var(--text-light);">Admin Notes</td>
                                <td style="padding: 12px 0;">{{ $withdrawal->admin_notes }}</td>
                            </tr>
                        @endif
                    </table>

                    @if($withdrawal->status === 'approved')
                        <form method="POST" action="{{ route('admin.withdrawals.complete', $withdrawal) }}" style="margin-top: 20px;">
                            @csrf
                            <div style="margin-bottom: 16px;">
                                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Transaction Reference</label>
                                <input type="text" name="transaction_reference" placeholder="Bank transfer reference..."
                                       style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
                            </div>
                            <button type="submit" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-check-double"></i>
                                Mark as Completed
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif

        <!-- User Withdrawal History -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    Previous Withdrawals
                </h3>
            </div>
            <div class="card-body no-padding">
                @if($userHistory->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userHistory as $history)
                                <tr>
                                    <td><strong>₦{{ number_format($history->amount) }}</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $history->status === 'approved' || $history->status === 'completed' ? 'success' : ($history->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($history->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $history->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state" style="padding: 32px;">
                        <i class="fas fa-history"></i>
                        <p>No previous withdrawals</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
