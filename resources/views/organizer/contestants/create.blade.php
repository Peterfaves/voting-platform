@extends('layouts.organizer')

@section('title', 'Add Contestant')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.events.show', $category->event) }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to {{ $category->event->name }}
    </a>
</div>

<div class="section-card" style="max-width: 600px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 4px;">Add Contestant</h1>
    <p style="color: var(--text-light); margin-bottom: 32px;">
        Category: <span style="color: var(--primary-gold); font-weight: 600;">{{ $category->name }}</span>
    </p>

    <form method="POST" action="{{ route('organizer.contestants.store', $category) }}" enctype="multipart/form-data">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Contestant Name -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Contestant Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name') }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                       placeholder="Enter contestant name"
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
                @error('name')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Bio
                </label>
                <textarea name="bio" rows="4"
                          style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; resize: vertical;"
                          placeholder="Tell us about this contestant..."
                          onfocus="this.style.borderColor='var(--primary-gold)'" 
                          onblur="this.style.borderColor='var(--border-light)'">{{ old('bio') }}</textarea>
                @error('bio')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Photo
                </label>
                <div id="photo-preview" style="border: 2px dashed var(--border-light); border-radius: 12px; padding: 32px; text-align: center; cursor: pointer;" 
                     onclick="document.getElementById('photo_input').click()">
                    <i class="fas fa-user-circle" style="font-size: 48px; color: var(--primary-gold); margin-bottom: 12px;"></i>
                    <p style="color: var(--text-medium); margin-bottom: 4px;">Click to upload photo</p>
                    <p style="color: var(--text-light); font-size: 13px;">Recommended: 400x400px (Max: 2MB)</p>
                </div>
                <input type="file" name="photo" id="photo_input" accept="image/*" style="display: none;">
                @error('photo')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Video URL -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Video URL (Optional)
                </label>
                <input type="url" name="video_url" value="{{ old('video_url') }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                       placeholder="https://youtube.com/watch?v=..."
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
                @error('video_url')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border-light);">
                <a href="{{ route('organizer.events.show', $category->event) }}" class="quick-action-btn" style="background: transparent;">
                    Cancel
                </a>
                <button type="submit" class="create-event-btn">
                    <i class="fas fa-user-plus"></i>
                    Add Contestant
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('photo_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('photo-preview');
            preview.innerHTML = `
                <img src="${URL.createObjectURL(file)}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 12px;">
                <p style="color: var(--text-medium);">${file.name}</p>
                <p style="color: var(--text-light); font-size: 13px;">Click to change</p>
            `;
        }
    });
</script>
@endpush