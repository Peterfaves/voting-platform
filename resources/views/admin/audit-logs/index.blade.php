@extends('admin.layouts.admin')

@section('title', 'Audit Logs')

@section('breadcrumb')
<span>Audit Logs</span>
@endsection

@section('content')
<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
    <div class="page-header" style="margin-bottom: 0;">
        <h1 class="page-title">Audit Logs</h1>
        <p class="page-subtitle">Track all admin actions and system changes</p>
    </div>
    <a href="{{ route('admin.audit-logs.export', request()->query()) }}" class="btn btn-secondary">
        <i class="fas fa-download"></i>
        Export CSV
    </a>
</div>

<!-- Stats -->
<div class="stats-grid mb-6" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-list"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_logs'] ?? 0) }}</div>
        <div class="stat-label">Total Logs</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['today_logs'] ?? 0) }}</div>
        <div class="stat-label">Logs Today</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['unique_admins'] ?? 0 }}</div>
        <div class="stat-label">Active Admins</div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search description, user, IP..." 
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
            </div>
            <div style="min-width: 150px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Admin</label>
                <select name="user" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Admins</option>
                    @foreach($admins ?? [] as $admin)
                        <option value="{{ $admin->id }}" {{ request('user') == $admin->id ? 'selected' : '' }}>
                            {{ $admin->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="min-width: 140px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Action</label>
                <select name="action" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Actions</option>
                    @foreach($actions ?? [] as $action)
                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $action)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="min-width: 140px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">From</label>
                <input type="date" name="from" value="{{ request('from') }}" 
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
            </div>
            <div style="min-width: 140px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">To</label>
                <input type="date" name="to" value="{{ request('to') }}" 
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
                Filter
            </button>
            <a href="{{ route('admin.audit-logs') }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Reset
            </a>
        </form>
    </div>
</div>

<!-- Audit Logs Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history"></i>
            Activity Log
        </h3>
        <span style="font-size: 14px; color: var(--text-light);">
            {{ $logs->total() ?? 0 }} entries
        </span>
    </div>
    <div class="card-body no-padding">
        @if($logs->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>
                                <div>{{ $log->created_at->format('M d, Y') }}</div>
                                <div style="font-size: 11px; color: var(--text-light);">{{ $log->created_at->format('h:i:s A') }}</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar" style="width: 32px; height: 32px; font-size: 12px;">
                                        {{ strtoupper(substr($log->user_name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <h4>{{ $log->user_name ?? 'System' }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $log->action_color }}">
                                    <i class="fas {{ $log->action_icon }}" style="font-size: 10px;"></i>
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td style="max-width: 300px;">
                                <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </p>
                                @if($log->model_type)
                                    <span style="font-size: 11px; color: var(--text-light);">
                                        {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="font-mono" style="font-size: 12px; color: var(--text-light);">
                                    {{ $log->ip_address ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-history"></i>
                <h3>No Logs Found</h3>
                <p>No audit logs match your current filters.</p>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($logs->hasPages())
    <div style="margin-top: 24px; display: flex; justify-content: center;">
        {{ $logs->links() }}
    </div>
@endif
@endsection
