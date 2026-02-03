@extends('admin.layouts.admin')

@section('title', 'Platform Settings')

@section('breadcrumb')
<span>Settings</span>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Platform Settings</h1>
    <p class="page-subtitle">Configure platform-wide settings, fees, and policies</p>
</div>

<div class="grid-2">
    <!-- Left Column -->
    <div>
        <!-- Fee Settings -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-percentage"></i>
                    Fee & Commission Settings
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                            Platform Fee (%)
                        </label>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 12px;">
                            Percentage charged on all withdrawals. This is deducted from organizer payouts.
                        </p>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="number" name="platform_fee" value="{{ $settings['platform_fee'] ?? 10 }}" min="0" max="50" step="0.5"
                                   style="width: 120px; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 16px; font-weight: 600;">
                            <span style="font-size: 16px; font-weight: 600; color: var(--text-medium);">%</span>
                        </div>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                            Minimum Withdrawal Amount (₦)
                        </label>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 12px;">
                            The minimum amount organizers can withdraw at once.
                        </p>
                        <input type="number" name="min_withdrawal" value="{{ $settings['min_withdrawal'] ?? 1000 }}" min="0" step="100"
                               style="width: 200px; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 16px; font-weight: 600;">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                            Maximum Withdrawal Amount (₦)
                        </label>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 12px;">
                            The maximum amount for a single withdrawal request.
                        </p>
                        <input type="number" name="max_withdrawal" value="{{ $settings['max_withdrawal'] ?? 1000000 }}" min="0" step="1000"
                               style="width: 200px; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 16px; font-weight: 600;">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Fee Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- Withdrawal Policy -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt"></i>
                    Withdrawal Schedule
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 12px;">
                            Allowed Withdrawal Days
                        </label>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 16px;">
                            Select the days when organizers can request withdrawals.
                        </p>
                        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <label style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; border: 1px solid var(--border-color); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                    <input type="checkbox" name="withdrawal_days[]" value="{{ strtolower($day) }}"
                                           {{ in_array(strtolower($day), $settings['withdrawal_days'] ?? ['monday', 'wednesday', 'friday']) ? 'checked' : '' }}
                                           style="width: 18px; height: 18px; accent-color: var(--admin-accent);">
                                    <span style="font-size: 14px; font-weight: 500;">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                            Processing Time (Days)
                        </label>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 12px;">
                            Expected time to process withdrawal requests.
                        </p>
                        <input type="number" name="processing_days" value="{{ $settings['processing_days'] ?? 3 }}" min="1" max="14"
                               style="width: 120px; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 16px; font-weight: 600;">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Schedule
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div>
        <!-- Voting Settings -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-vote-yea"></i>
                    Voting Settings
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                            Default Vote Price (₦)
                        </label>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 12px;">
                            Suggested vote price for new events.
                        </p>
                        <input type="number" name="default_vote_price" value="{{ $settings['default_vote_price'] ?? 100 }}" min="0" step="50"
                               style="width: 150px; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 16px; font-weight: 600;">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                            Minimum Vote Price (₦)
                        </label>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 12px;">
                            The minimum vote price organizers can set.
                        </p>
                        <input type="number" name="min_vote_price" value="{{ $settings['min_vote_price'] ?? 50 }}" min="0" step="10"
                               style="width: 150px; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 16px; font-weight: 600;">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                            Maximum Votes Per Transaction
                        </label>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 12px;">
                            Maximum number of votes a user can cast in one transaction.
                        </p>
                        <input type="number" name="max_votes_per_transaction" value="{{ $settings['max_votes_per_transaction'] ?? 1000 }}" min="1"
                               style="width: 150px; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 16px; font-weight: 600;">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Voting Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment Gateway Settings -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-credit-card"></i>
                    Payment Gateway
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                            Active Payment Gateway
                        </label>
                        <select name="payment_gateway" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                            <option value="paystack" {{ ($settings['payment_gateway'] ?? 'paystack') === 'paystack' ? 'selected' : '' }}>Paystack</option>
                            <option value="flutterwave" {{ ($settings['payment_gateway'] ?? '') === 'flutterwave' ? 'selected' : '' }}>Flutterwave</option>
                        </select>
                    </div>

                    <div style="padding: 16px; background: var(--main-bg); border-radius: 10px; margin-bottom: 24px;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                            <div style="width: 40px; height: 40px; background: #00C3F7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <span style="color: white; font-weight: 700; font-size: 12px;">PS</span>
                            </div>
                            <div>
                                <h4 style="font-weight: 600; font-size: 14px;">Paystack</h4>
                                <p style="font-size: 12px; color: var(--text-light);">Connected & Active</p>
                            </div>
                            <span class="badge badge-success" style="margin-left: auto;">Active</span>
                        </div>
                        <p style="font-size: 13px; color: var(--text-medium);">
                            API keys are configured in your environment file (.env) for security.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Gateway Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bell"></i>
                    Admin Notifications
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                            <div>
                                <span style="font-weight: 600; display: block; margin-bottom: 4px;">New Withdrawal Requests</span>
                                <span style="font-size: 13px; color: var(--text-light);">Get notified when organizers request withdrawals</span>
                            </div>
                            <input type="checkbox" name="notify_withdrawals" value="1" {{ ($settings['notify_withdrawals'] ?? true) ? 'checked' : '' }}
                                   style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                        </label>

                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                            <div>
                                <span style="font-weight: 600; display: block; margin-bottom: 4px;">New User Registrations</span>
                                <span style="font-size: 13px; color: var(--text-light);">Get notified when new organizers register</span>
                            </div>
                            <input type="checkbox" name="notify_registrations" value="1" {{ ($settings['notify_registrations'] ?? false) ? 'checked' : '' }}
                                   style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                        </label>

                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                            <div>
                                <span style="font-weight: 600; display: block; margin-bottom: 4px;">High-Value Transactions</span>
                                <span style="font-size: 13px; color: var(--text-light);">Get notified for transactions above ₦50,000</span>
                            </div>
                            <input type="checkbox" name="notify_high_value" value="1" {{ ($settings['notify_high_value'] ?? true) ? 'checked' : '' }}
                                   style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                        </label>

                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0;">
                            <div>
                                <span style="font-weight: 600; display: block; margin-bottom: 4px;">Suspicious Activity Alerts</span>
                                <span style="font-size: 13px; color: var(--text-light);">Get notified about suspicious voting patterns</span>
                            </div>
                            <input type="checkbox" name="notify_suspicious" value="1" {{ ($settings['notify_suspicious'] ?? true) ? 'checked' : '' }}
                                   style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top: 24px;">
                        <i class="fas fa-save"></i>
                        Save Notification Settings
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Danger Zone -->
<div class="card mt-6" style="border-color: var(--danger);">
    <div class="card-header" style="background: var(--danger-bg);">
        <h3 class="card-title" style="color: var(--danger);">
            <i class="fas fa-exclamation-triangle"></i>
            Danger Zone
        </h3>
    </div>
    <div class="card-body">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid var(--border-color);">
            <div>
                <h4 style="font-weight: 600; margin-bottom: 4px;">Clear All Cache</h4>
                <p style="font-size: 13px; color: var(--text-light);">Clear application cache, config cache, and view cache.</p>
            </div>
            <form method="POST" action="{{ route('admin.settings.clear-cache') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Clear Cache</button>
            </form>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0;">
            <div>
                <h4 style="font-weight: 600; margin-bottom: 4px;">Maintenance Mode</h4>
                <p style="font-size: 13px; color: var(--text-light);">Put the application in maintenance mode. Only admins can access.</p>
            </div>
            <form method="POST" action="{{ route('admin.settings.maintenance') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Enable Maintenance</button>
            </form>
        </div>
    </div>
</div>
@endsection
