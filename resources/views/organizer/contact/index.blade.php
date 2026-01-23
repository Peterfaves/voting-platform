@extends('layouts.organizer')

@section('title', 'Contact Us')

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

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 32px;">
    <!-- Contact Form -->
    <div>
        <div style="margin-bottom: 32px;">
            <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 8px;">Contact Us</h1>
            <p style="color: var(--text-light);">We're happy to help, just tell us what's going on, and someone from our team will get back to you shortly.</p>
        </div>

        <div class="section-card">
            <form method="POST" action="{{ route('organizer.contact.send') }}">
                @csrf
                
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    <!-- Name -->
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                            Name
                        </label>
                        <input type="text" 
                               name="name" 
                               required
                               value="{{ old('name', auth()->user()->name) }}"
                               placeholder="Enter your name"
                               style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                               onfocus="this.style.borderColor='var(--primary-gold)'" 
                               onblur="this.style.borderColor='var(--border-light)'">
                        @error('name')
                            <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               required
                               value="{{ old('email', auth()->user()->email) }}"
                               placeholder="Enter your email"
                               style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                               onfocus="this.style.borderColor='var(--primary-gold)'" 
                               onblur="this.style.borderColor='var(--border-light)'">
                        @error('email')
                            <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                            Message
                        </label>
                        <textarea name="message" 
                                  rows="6" 
                                  required
                                  placeholder="Type in your message"
                                  style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; resize: vertical;"
                                  onfocus="this.style.borderColor='var(--primary-gold)'" 
                                  onblur="this.style.borderColor='var(--border-light)'">{{ old('message') }}</textarea>
                        @error('message')
                            <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="create-event-btn" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contact Information -->
    <div>
        <div style="margin-bottom: 32px;">
            <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Other Ways To Reach Us</h2>
        </div>

        <!-- Phone -->
        <div class="section-card" style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: var(--sidebar-bg); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-phone-alt" style="font-size: 24px; color: var(--primary-gold);"></i>
                </div>
                <div>
                    <div style="font-size: 13px; color: var(--text-light); margin-bottom: 4px;">Phone</div>
                    <a href="tel:+2347074193263" style="font-size: 18px; font-weight: 700; color: var(--text-dark); text-decoration: none;">
                        +2347074193263
                    </a>
                </div>
            </div>
        </div>

        <!-- Email -->
        <div class="section-card" style="margin-bottom: 32px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: var(--sidebar-bg); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-envelope" style="font-size: 24px; color: var(--primary-gold);"></i>
                </div>
                <div>
                    <div style="font-size: 13px; color: var(--text-light); margin-bottom: 4px;">Email</div>
                    <a href="mailto:support@votenaija.ng" style="font-size: 18px; font-weight: 700; color: var(--text-dark); text-decoration: none;">
                        support@votenaija.ng
                    </a>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div>
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">Follow Us</h3>
            <div style="display: flex; gap: 12px;">
                <a href="https://instagram.com" target="_blank" 
                   style="width: 48px; height: 48px; background: linear-gradient(135deg, #F56040, #E1306C, #C13584); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <i class="fab fa-instagram" style="font-size: 24px; color: white;"></i>
                </a>
                
                <a href="https://linkedin.com" target="_blank" 
                   style="width: 48px; height: 48px; background: #0A66C2; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <i class="fab fa-linkedin-in" style="font-size: 24px; color: white;"></i>
                </a>
                
                <a href="https://twitter.com" target="_blank" 
                   style="width: 48px; height: 48px; background: #000000; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <i class="fab fa-x-twitter" style="font-size: 24px; color: white;"></i>
                </a>
                
                <a href="https://facebook.com" target="_blank" 
                   style="width: 48px; height: 48px; background: #1877F2; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <i class="fab fa-facebook-f" style="font-size: 24px; color: white;"></i>
                </a>
                
                <a href="https://tiktok.com" target="_blank" 
                   style="width: 48px; height: 48px; background: #000000; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                   <i class="fab fa-tiktok" style="font-size: 24px; color: white;"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
