@extends('admin.layouts.admin')

@section('title', 'Reports & Monitoring')

@section('breadcrumb')
<span>Reports</span>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Reports & Monitoring</h1>
    <p class="page-subtitle">Monitor suspicious activity and platform health</p>
</div>

<!-- Alert Stats -->
<div class="stats-grid mb-6" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card" style="background: linear-gradient(135deg, var(--warning) 0%, #D97706 100%);">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: rgba(255,255,255,0.2);">
                <i class="fas fa-exclamation-triangle" style="color: white;"></i>
            </div>
        </div>
        <div class="stat-value" style="color: white;">{{ $stats['suspicious_count'] ?? 0 }}</div>
        <div class="stat-label" style="color: rgba(255,255,255,0.8);">Suspicious Activities</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['high_value_count'] ?? 0 }}</div>
        <div class="stat-label">High-Value Transactions</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon danger">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['failed_patterns_count'] ?? 0 }}</div>
        <div class="stat-label">Failed Payment Patterns</div>
    </div>
</div>

<!-- Suspicious Activity -->
<div class="card mb-6">
    <div class="card-header" style="background: var(--warning-bg);">
        <h3 class="card-title" style="color: var(--warning);">
            <i class="fas fa-exclamation-triangle"></i>
            Suspicious Activity Detected
        </h3>
        <span class="badge badge-warning">{{ count($suspiciousActivity ?? []) }} alerts</span>
    </div>
    <div class="card-body no-padding">
        @if(count($suspiciousActivity ?? []) > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Severity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suspiciousActivity as $activity)
                        <tr>
                            <td>
                                <span class="badge badge-{{ $activity['type'] === 'rapid_voting' ? 'warning' : 'info' }}">
                                    {{ ucfirst(str_replace('_', ' ', $activity['type'])) }}
                                </span>
                            </td>
                            <td style="max-width: 400px;">{{ $activity['description'] }}</td>
                            <td>
                                @if($activity['severity'] === 'high')
                                    <span class="badge badge-danger">High</span>
                                @elseif($activity['severity'] === 'medium')
                                    <span class="badge badge-warning">Medium</span>
                                @else
                                    <span class="badge badge-secondary">Low</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button class="btn btn-secondary btn-sm" title="Investigate">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-secondary btn-sm" title="Dismiss">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-check-circle" style="color: var(--success);"></i>
                <h3>All Clear!</h3>
                <p>No suspicious activity detected.</p>
            </div>
        @endif
    </div>
</div>

<div class="grid-2">
    <!-- High-Value Transactions -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-gem"></i>
                High-Value Transactions
            </h3>
            <span style="font-size: 12px; color: var(--text-light);">₦50,000+</span>
        </div>
        <div class="card-body no-padding">
            @if(count($highValueTransactions ?? []) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Voter</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($highValueTransactions as $transaction)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <h4>{{ $transaction->voter_name ?? 'Anonymous' }}</h4>
                                        <p style="font-size: 11px;">{{ $transaction->voter_email ?? '' }}</p>
                                    </div>
                                </td>
                                <td><strong style="color: var(--success);">₦{{ number_format($transaction->amount_paid) }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state" style="padding: 32px;">
                    <i class="fas fa-gem"></i>
                    <p>No high-value transactions in the last 7 days</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Failed Payment Patterns -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-exclamation-circle"></i>
                Failed Payment Patterns
            </h3>
            <span style="font-size: 12px; color: var(--text-light);">5+ failures</span>
        </div>
        <div class="card-body no-padding">
            @if(count($failedPatterns ?? []) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Failed Attempts</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($failedPatterns as $pattern)
                            <tr>
                                <td>
                                    <span style="font-family: monospace; font-size: 13px;">{{ $pattern->voter_email }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-danger">{{ $pattern->failed_count }} failures</span>
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm" title="Investigate">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state" style="padding: 32px;">
                    <i class="fas fa-check-circle" style="color: var(--success);"></i>
                    <p>No suspicious payment patterns detected</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mt-6">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tools"></i>
            Monitoring Tools
        </h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 16px;">
                <i class="fas fa-exchange-alt"></i>
                View All Transactions
            </a>
            <a href="{{ route('admin.users.index', ['sort' => 'latest']) }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 16px;">
                <i class="fas fa-user-plus"></i>
                New Registrations
            </a>
            <a href="{{ route('admin.audit-logs') }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 16px;">
                <i class="fas fa-history"></i>
                Audit Logs
            </a>
            <a href="{{ route('admin.events.index', ['status' => 'active']) }}" class="btn btn-secondary" style="justify-content: flex-start; padding: 16px;">
                <i class="fas fa-broadcast-tower"></i>
                Live Events
            </a>
        </div>
    </div>
</div>
@endsection
