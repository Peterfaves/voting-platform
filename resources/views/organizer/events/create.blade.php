@extends('layouts.organizer')

@section('title', 'Create Event')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.events.index') }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Events
    </a>
</div>

<div class="section-card" style="max-width: 800px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Create New Event</h1>
    <p style="color: var(--text-light); margin-bottom: 32px;">Set up your voting event details</p>

    <form method="POST" action="{{ route('organizer.events.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Event Name -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Event Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name') }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; transition: border-color 0.2s;"
                       placeholder="e.g., Nigerian Music Awards 2025"
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
                @error('name')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Description <span style="color: #EF4444;">*</span>
                </label>
                <textarea name="description" rows="4" required
                          style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; resize: vertical;"
                          placeholder="Describe your event..."
                          onfocus="this.style.borderColor='var(--primary-gold)'" 
                          onblur="this.style.borderColor='var(--border-light)'">{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Banner Image -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Banner Image
                </label>
                <div style="border: 2px dashed var(--border-light); border-radius: 12px; padding: 32px; text-align: center; cursor: pointer; transition: border-color 0.2s;" 
                     onclick="document.getElementById('banner_input').click()"
                     onmouseover="this.style.borderColor='var(--primary-gold)'"
                     onmouseout="this.style.borderColor='var(--border-light)'">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: var(--primary-gold); margin-bottom: 12px;"></i>
                    <p style="color: var(--text-medium); margin-bottom: 4px;">Click to upload or drag and drop</p>
                    <p style="color: var(--text-light); font-size: 13px;">Recommended: 1200x400px (Max: 2MB)</p>
                </div>
                <input type="file" name="banner_image" id="banner_input" accept="image/*" style="display: none;">
                @error('banner_image')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Vote Price -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Vote Price (₦) <span style="color: #EF4444;">*</span>
                </label>
                <input type="number" name="vote_price" step="0.01" min="0" required value="{{ old('vote_price', 100) }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
                <p style="color: var(--text-light); font-size: 13px; margin-top: 6px;">Price per single vote</p>
                @error('vote_price')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dates -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Start Date <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="date" name="start_date" required value="{{ old('start_date', date('Y-m-d')) }}"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                    @error('start_date')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        End Date <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="date" name="end_date" required value="{{ old('end_date') }}"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                    @error('end_date')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border-light);">
                <a href="{{ route('organizer.events.index') }}" class="quick-action-btn" style="background: transparent;">
                    Cancel
                </a>
                <button type="submit" class="create-event-btn">
                    <i class="fas fa-plus"></i>
                    Create Event
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Preview uploaded image
    document.getElementById('banner_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const container = this.previousElementSibling;
            container.innerHTML = `
                <img src="${URL.createObjectURL(file)}" style="max-height: 150px; border-radius: 8px; margin-bottom: 12px;">
                <p style="color: var(--text-medium);">${file.name}</p>
            `;
        }
    });
</script>
@endpush