@extends('admin.layouts.admin')

@section('title', 'Withdrawal Management')

@section('breadcrumb')
<span>Withdrawals</span>
@endsection

@section('content')
<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
    <div class="page-header" style="margin-bottom: 0;">
        <h1 class="page-title">Withdrawal Management</h1>
        <p class="page-subtitle">Review and process organizer withdrawal requests</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <button class="btn btn-secondary">
            <i class="fas fa-download"></i>
            Export Report
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon warning">
                <i class="fas fa-clock"></i>
            </div>
            @if(($stats['pending_count'] ?? 0) > 0)
                <span class="badge badge-danger">Needs Review</span>
            @endif
        </div>
        <div class="stat-value">{{ $stats['pending_count'] ?? 0 }}</div>
        <div class="stat-label">Pending Requests</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon danger">
                <i class="fas fa-naira-sign"></i>
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['pending_amount'] ?? 0) }}</div>
        <div class="stat-label">Pending Amount</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['approved_this_month'] ?? 0) }}</div>
        <div class="stat-label">Approved This Month</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['total_withdrawn'] ?? 0) }}</div>
        <div class="stat-label">Total All-Time Payouts</div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Search Organizer</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." 
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
            </div>
            <div style="min-width: 150px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div style="min-width: 150px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Date Range</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
                Filter
            </button>
        </form>
    </div>
</div>

<!-- Withdrawals Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-hand-holding-usd"></i>
            All Withdrawal Requests
        </h3>
        <div style="display: flex; gap: 8px;">
            <a href="?status=pending" class="btn {{ request('status') === 'pending' ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                Pending ({{ $stats['pending_count'] ?? 0 }})
            </a>
            <a href="?status=" class="btn {{ !request('status') ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                All
            </a>
        </div>
    </div>
    <div class="card-body no-padding">
        @if($withdrawals->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Organizer</th>
                        <th>Amount</th>
                        <th>Platform Fee</th>
                        <th>Net Payout</th>
                        <th>Bank Details</th>
                        <th>Status</th>
                        <th>Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $withdrawal)
                        <tr>
                            <td>
                                <span class="font-mono" style="font-size: 12px; color: var(--text-light);">#WD{{ str_pad($withdrawal->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar" style="width: 36px; height: 36px; font-size: 12px;">
                                        {{ strtoupper(substr($withdrawal->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <h4>{{ $withdrawal->user->name ?? 'Unknown' }}</h4>
                                        <p>{{ $withdrawal->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td><strong>₦{{ number_format($withdrawal->amount) }}</strong></td>
                            <td style="color: var(--danger);">-₦{{ number_format($withdrawal->platform_fee ?? $withdrawal->amount * 0.1) }}</td>
                            <td style="color: var(--success);"><strong>₦{{ number_format($withdrawal->net_amount ?? $withdrawal->amount * 0.9) }}</strong></td>
                            <td>
                                <div style="font-size: 13px;">
                                    <div><strong>{{ $withdrawal->user->bank_name ?? 'Not set' }}</strong></div>
                                    <div style="color: var(--text-light);">{{ $withdrawal->user->account_number ?? 'N/A' }}</div>
                                    <div style="color: var(--text-light); font-size: 11px;">{{ $withdrawal->user->account_name ?? '' }}</div>
                                </div>
                            </td>
                            <td>
                                @if($withdrawal->status === 'pending')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        Pending
                                    </span>
                                @elseif($withdrawal->status === 'approved')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                        Approved
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i>
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $withdrawal->created_at->format('M d, Y') }}</div>
                                <div style="font-size: 11px; color: var(--text-light);">{{ $withdrawal->created_at->format('h:i A') }}</div>
                            </td>
                            <td>
                                @if($withdrawal->status === 'pending')
                                    <div style="display: flex; gap: 6px;">
                                        <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this withdrawal of ₦{{ number_format($withdrawal->amount) }}?')">
                                                <i class="fas fa-check"></i>
                                                Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="openRejectModal({{ $withdrawal->id }})">
                                            <i class="fas fa-times"></i>
                                            Reject
                                        </button>
                                    </div>
                                @else
                                    <a href="{{ route('admin.withdrawals.show', $withdrawal) }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Withdrawal Requests</h3>
                <p>There are no withdrawal requests matching your filters.</p>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($withdrawals->hasPages())
    <div style="margin-top: 24px; display: flex; justify-content: center;">
        {{ $withdrawals->links() }}
    </div>
@endif

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; padding: 32px; max-width: 500px; width: 90%; margin: 20px;">
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Reject Withdrawal</h3>
        <p style="color: var(--text-medium); margin-bottom: 24px;">Please provide a reason for rejecting this withdrawal request.</p>
        
        <form method="POST" id="rejectForm">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Reason for Rejection</label>
                <textarea name="rejection_reason" required rows="4" 
                          style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; resize: vertical;"
                          placeholder="Enter the reason for rejection..."></textarea>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="btn btn-danger">Reject Withdrawal</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(id) {
        document.getElementById('rejectModal').style.display = 'flex';
        document.getElementById('rejectForm').action = '/admin/withdrawals/' + id + '/reject';
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }
    
    // Close modal on outside click
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });
</script>
@endpush
@endsection
