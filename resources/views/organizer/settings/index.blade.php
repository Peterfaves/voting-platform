@extends('layouts.organizer')

@section('title', 'Settings')

@section('content')
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

<!-- Tabs -->
<div style="border-bottom: 2px solid var(--border-light); margin-bottom: 32px;">
    <div style="display: flex; gap: 32px;">
        <button onclick="showTab('profile')" id="profile-tab" class="settings-tab active-tab">
            Profile Information
        </button>
        <button onclick="showTab('bank')" id="bank-tab" class="settings-tab">
            Bank Details
        </button>
        <button onclick="showTab('password')" id="password-tab" class="settings-tab">
            Change Password
        </button>
    </div>
</div>

<!-- Profile Information Tab -->
<div id="profile-content" class="tab-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 4px;">Profile</h2>
        </div>
        <button onclick="toggleEdit('profile')" id="profile-edit-btn" class="quick-action-btn">
            <i class="fas fa-edit"></i> Edit Profile
        </button>
    </div>

    <div class="section-card" style="max-width: 800px;">
        <!-- Profile Avatar -->
        <div style="margin-bottom: 32px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-dark) 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        </div>

        <!-- Important Notice -->
        <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 16px 20px; border-radius: 8px; margin-bottom: 32px;">
            <div style="display: flex; align-items: start; gap: 12px;">
                <i class="fas fa-exclamation-triangle" style="color: #D97706; font-size: 20px; margin-top: 2px;"></i>
                <div>
                    <h4 style="font-weight: 700; color: #92400E; margin-bottom: 8px;">Important: Name Verification Required</h4>
                    <p style="color: #92400E; font-size: 14px; line-height: 1.6;">
                        Your organizer name must exactly match the name on your bank account. Any mismatch will result in rejected withdrawals and delayed payments. Please ensure accuracy before saving.
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('organizer.settings.profile') }}" id="profile-form">
            @csrf
            @method('PUT')
            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Full Name -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Full Name
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           readonly
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: var(--sidebar-bg);">
                    @error('name')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organizer Name -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Organizer Name
                    </label>
                    <input type="text" 
                           name="organizer_name" 
                           value="{{ old('organizer_name', $user->organizer_name) }}"
                           placeholder="Enter organizer name"
                           readonly
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: var(--sidebar-bg);">
                    <p style="color: var(--text-light); font-size: 13px; margin-top: 6px;">
                        <i class="fas fa-exclamation-triangle" style="color: #F59E0B;"></i> Must match your bank name accurately
                    </p>
                    @error('organizer_name')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Email Address
                    </label>
                    <input type="email" 
                           value="{{ $user->email }}"
                           readonly
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: var(--sidebar-bg);">
                </div>

                <!-- Phone Number -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Phone Number
                    </label>
                    <input type="tel" 
                           name="phone" 
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="Enter phone number"
                           readonly
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: var(--sidebar-bg);">
                    @error('phone')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Save Button (hidden by default) -->
                <div id="profile-save-btn" style="display: none;">
                    <button type="submit" class="create-event-btn" style="width: 100%;">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bank Details Tab -->
<div id="bank-content" class="tab-content" style="display: none;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 4px;">Bank Details</h2>
            <p style="color: var(--text-light);">Update your bank information for withdrawals</p>
        </div>
        <button onclick="toggleEdit('bank')" id="bank-edit-btn" class="quick-action-btn">
            <i class="fas fa-edit"></i> Edit Bank Details
        </button>
    </div>

    <div class="section-card" style="max-width: 800px;">
        <form method="POST" action="{{ route('organizer.settings.bank') }}" id="bank-form">
            @csrf
            @method('PUT')
            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Bank Name -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Bank Name <span style="color: #EF4444;">*</span>
                    </label>
                    <select name="bank_name" 
                            required
                            disabled
                            style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: var(--sidebar-bg);">
                        <option value="">Select your bank</option>
                        <option value="Access Bank" {{ old('bank_name', $user->bank_name) === 'Access Bank' ? 'selected' : '' }}>Access Bank</option>
                        <option value="GTBank" {{ old('bank_name', $user->bank_name) === 'GTBank' ? 'selected' : '' }}>GTBank</option>
                        <option value="First Bank" {{ old('bank_name', $user->bank_name) === 'First Bank' ? 'selected' : '' }}>First Bank</option>
                        <option value="UBA" {{ old('bank_name', $user->bank_name) === 'UBA' ? 'selected' : '' }}>UBA</option>
                        <option value="Zenith Bank" {{ old('bank_name', $user->bank_name) === 'Zenith Bank' ? 'selected' : '' }}>Zenith Bank</option>
                        <option value="Polaris Bank" {{ old('bank_name', $user->bank_name) === 'Polaris Bank' ? 'selected' : '' }}>Polaris Bank</option>
                        <option value="Stanbic IBTC" {{ old('bank_name', $user->bank_name) === 'Stanbic IBTC' ? 'selected' : '' }}>Stanbic IBTC</option>
                        <option value="Sterling Bank" {{ old('bank_name', $user->bank_name) === 'Sterling Bank' ? 'selected' : '' }}>Sterling Bank</option>
                        <option value="Union Bank" {{ old('bank_name', $user->bank_name) === 'Union Bank' ? 'selected' : '' }}>Union Bank</option>
                        <option value="Wema Bank" {{ old('bank_name', $user->bank_name) === 'Wema Bank' ? 'selected' : '' }}>Wema Bank</option>
                        <option value="Kuda Bank" {{ old('bank_name', $user->bank_name) === 'Kuda Bank' ? 'selected' : '' }}>Kuda Bank</option>
                        <option value="Opay" {{ old('bank_name', $user->bank_name) === 'Opay' ? 'selected' : '' }}>Opay</option>
                        <option value="Palmpay" {{ old('bank_name', $user->bank_name) === 'Palmpay' ? 'selected' : '' }}>Palmpay</option>
                    </select>
                    @error('bank_name')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Number -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Account Number <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="text" 
                           name="account_number" 
                           value="{{ old('account_number', $user->account_number) }}"
                           placeholder="0123456789"
                           required
                           readonly
                           maxlength="10"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: var(--sidebar-bg);">
                    @error('account_number')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Name -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Account Name <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="text" 
                           name="account_name" 
                           value="{{ old('account_name', $user->account_name) }}"
                           placeholder="Account holder name"
                           required
                           readonly
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: var(--sidebar-bg);">
                    <p style="color: var(--text-light); font-size: 13px; margin-top: 6px;">
                        Must match your bank account exactly
                    </p>
                    @error('account_name')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Save Button (hidden by default) -->
                <div id="bank-save-btn" style="display: none;">
                    <button type="submit" class="create-event-btn" style="width: 100%;">
                        <i class="fas fa-save"></i>
                        Save Bank Details
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Change Password Tab -->
<div id="password-content" class="tab-content" style="display: none;">
    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 4px;">Change Password</h2>
        <p style="color: var(--text-light);">Update your password to keep your account secure</p>
    </div>

    <div class="section-card" style="max-width: 800px;">
        <form method="POST" action="{{ route('organizer.settings.password') }}">
            @csrf
            @method('PUT')
            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Current Password -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Current Password <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="password" 
                           name="current_password" 
                           required
                           placeholder="Enter current password"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                    @error('current_password')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        New Password <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           required
                           placeholder="Enter new password"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                    <p style="color: var(--text-light); font-size: 13px; margin-top: 6px;">
                        Minimum 8 characters
                    </p>
                    @error('password')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Confirm New Password <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           required
                           placeholder="Confirm new password"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                </div>

                <!-- Save Button -->
                <div>
                    <button type="submit" class="create-event-btn" style="width: 100%;">
                        <i class="fas fa-key"></i>
                        Update Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.settings-tab {
    padding: 16px 0;
    border: none;
    background: transparent;
    color: var(--text-medium);
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.settings-tab:hover {
    color: var(--primary-gold);
}

.settings-tab.active-tab {
    color: var(--primary-gold);
    border-bottom-color: var(--primary-gold);
}
</style>
@endpush

@push('scripts')
<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.settings-tab').forEach(btn => {
        btn.classList.remove('active-tab');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-content').style.display = 'block';
    document.getElementById(tabName + '-tab').classList.add('active-tab');
}

function toggleEdit(formName) {
    const form = document.getElementById(formName + '-form');
    const inputs = form.querySelectorAll('input, select');
    const saveBtn = document.getElementById(formName + '-save-btn');
    const editBtn = document.getElementById(formName + '-edit-btn');
    
    inputs.forEach(input => {
        if (input.name === 'name' || input.type === 'email') return; // Keep these readonly
        input.readOnly = !input.readOnly;
        input.disabled = !input.disabled;
        input.style.background = input.readOnly ? 'var(--sidebar-bg)' : 'white';
    });
    
    saveBtn.style.display = saveBtn.style.display === 'none' ? 'block' : 'none';
    editBtn.innerHTML = saveBtn.style.display === 'none' ? '<i class="fas fa-edit"></i> Edit ' + (formName === 'profile' ? 'Profile' : 'Bank Details') : '<i class="fas fa-times"></i> Cancel';
}
</script>
@endpush