@extends('layouts.organizer')

@section('title', 'Withdrawals')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">Withdrawal Request</h1>
        <p style="color: var(--text-light);">Request a payout of your available earnings. You can track the status of your requests below</p>
    </div>
</div>

@if(session('success'))
    <div style="background: #DCFCE7; border: 2px solid #22C55E; color: #166534; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #FEE2E2; border: 2px solid #EF4444; color: #991B1B; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px;">
    <!-- Left Column -->
    <div>
        <!-- Withdrawal Policy -->
        <div style="background: #FEF3C7; border: 2px solid #F59E0B; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <i class="fas fa-exclamation-triangle" style="color: #D97706; font-size: 24px;"></i>
                <h3 style="font-size: 18px; font-weight: 700; color: #92400E;">Withdrawals Policy</h3>
            </div>
            <p style="color: #92400E; line-height: 1.6;">
                Withdrawals are only allowed on <strong>Mondays, Wednesdays</strong>, and <strong>Fridays</strong>.
            </p>
        </div>

        <!-- Available Balance Card -->
        <div class="section-card" style="margin-bottom: 24px;">
            <h3 style="font-size: 16px; font-weight: 600; color: var(--text-light); margin-bottom: 12px;">Available for withdrawal</h3>
            <div style="font-size: 48px; font-weight: 800; color: var(--text-dark); margin-bottom: 16px;">
                ₦{{ number_format($availableBalance, 2) }}
            </div>
            <div style="display: flex; align-items: center; gap: 8px; padding: 12px; background: var(--sidebar-bg); border-radius: 8px;">
                <i class="fas fa-info-circle" style="color: var(--text-light);"></i>
                <p style="color: var(--text-medium); font-size: 14px; font-style: italic;">
                    A 10% platform fee will be applied upon withdrawal
                </p>
            </div>
        </div>

        <!-- Bank Details Warning -->
        @if(!auth()->user()->bank_name || !auth()->user()->account_number)
            <div style="background: #FEE2E2; border: 2px solid #EF4444; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <i class="fas fa-exclamation-circle" style="color: #DC2626; font-size: 24px;"></i>
                    <h3 style="font-size: 16px; font-weight: 700; color: #991B1B;">Bank Details Required</h3>
                </div>
                <p style="color: #991B1B; margin-bottom: 16px;">
                    It looks like your bank details aren't set up yet. Before you can request a withdrawal, please update your Bank details in your account settings.
                </p>
                <a href="{{ route('organizer.settings') }}" 
                   style="display: inline-block; padding: 10px 20px; background: #EF4444; color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Go to settings
                </a>
            </div>
        @else
            <!-- Withdrawal Form -->
            <div class="section-card">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Request Withdrawal</h3>
                
                <form method="POST" action="{{ route('organizer.withdrawals.store') }}">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                            Amount (₦) <span style="color: #EF4444;">*</span>
                        </label>
                        <input type="number" 
                               name="amount" 
                               required 
                               min="1000"
                               max="{{ $availableBalance }}"
                               step="0.01"
                               value="{{ old('amount') }}"
                               placeholder="Enter amount to withdraw"
                               style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                               onfocus="this.style.borderColor='var(--primary-gold)'" 
                               onblur="this.style.borderColor='var(--border-light)'">
                        <p style="color: var(--text-light); font-size: 13px; margin-top: 6px;">Minimum withdrawal: ₦1,000</p>
                        @error('amount')
                            <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="create-event-btn"
                            style="width: 100%;"
                            {{ !$isWithdrawalDay || $availableBalance < 1000 ? 'disabled' : '' }}>
                        <i class="fas fa-paper-plane"></i>
                        Request Withdrawal
                    </button>

                    @if(!$isWithdrawalDay)
                        <p style="color: #DC2626; font-size: 13px; margin-top: 12px; text-align: center;">
                            Withdrawals are only allowed on Mondays, Wednesdays, and Fridays.
                        </p>
                    @endif
                </form>
            </div>
        @endif
    </div>

    <!-- Right Column - Transaction History -->
    <div>
        <div class="section-card">
            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Transaction History</h3>
            
            @if($withdrawals->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($withdrawals as $withdrawal)
                        <div style="padding: 16px; border: 2px solid var(--border-light); border-radius: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-weight: 700; font-size: 18px; color: var(--text-dark);">
                                    ₦{{ number_format($withdrawal->amount, 2) }}
                                </span>
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600;
                                    {{ $withdrawal->status === 'completed' ? 'background: #DCFCE7; color: #166534;' : 
                                       ($withdrawal->status === 'processing' ? 'background: #FEF3C7; color: #92400E;' : 
                                       ($withdrawal->status === 'failed' ? 'background: #FEE2E2; color: #991B1B;' : 
                                       'background: #E0E7FF; color: #3730A3;')) }}">
                                    {{ ucfirst($withdrawal->status) }}
                                </span>
                            </div>
                            <p style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">
                                {{ $withdrawal->reference }}
                            </p>
                            <p style="font-size: 12px; color: var(--text-light);">
                                {{ $withdrawal->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 20px;">
                    {{ $withdrawals->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 32px; color: var(--text-light);">
                    <i class="fas fa-inbox" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
                    <p>No Recent Transactions.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection