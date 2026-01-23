@extends('layouts.organizer')

@section('title', 'Edit Contestant')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.events.show', $contestant->category->event) }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to {{ $contestant->category->event->name }}
    </a>
</div>

<div class="section-card" style="max-width: 600px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 4px;">Edit Contestant</h1>
    <p style="color: var(--text-light); margin-bottom: 32px;">
        Category: <span style="color: var(--primary-gold); font-weight: 600;">{{ $contestant->category->name }}</span>
    </p>

    <form method="POST" action="{{ route('organizer.contestants.update', $contestant) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Contestant Name -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Contestant Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name', $contestant->name) }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
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
                          onfocus="this.style.borderColor='var(--primary-gold)'" 
                          onblur="this.style.borderColor='var(--border-light)'">{{ old('bio', $contestant->bio) }}</textarea>
                @error('bio')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Photo
                </label>
                @if($contestant->photo)
                    <div style="margin-bottom: 12px; display: flex; align-items: center; gap: 16px;">
                        <img src="{{ asset('storage/' . $contestant->photo) }}" 
                             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                        <span style="color: var(--text-light); font-size: 14px;">Current photo</span>
                    </div>
                @endif
                <div id="photo-preview" style="border: 2px dashed var(--border-light); border-radius: 12px; padding: 24px; text-align: center; cursor: pointer;" 
                     onclick="document.getElementById('photo_input').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 24px; color: var(--primary-gold); margin-bottom: 8px;"></i>
                    <p style="color: var(--text-medium); font-size: 14px;">Click to upload new photo</p>
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
                <input type="url" name="video_url" value="{{ old('video_url', $contestant->video_url) }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                       placeholder="https://youtube.com/watch?v=..."
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
                @error('video_url')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Status <span style="color: #EF4444;">*</span>
                </label>
                <select name="status" required
                        style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: white;"
                        onfocus="this.style.borderColor='var(--primary-gold)'" 
                        onblur="this.style.borderColor='var(--border-light)'">
                    <option value="active" {{ old('status', $contestant->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="evicted" {{ old('status', $contestant->status) === 'evicted' ? 'selected' : '' }}>Evicted</option>
                </select>
                @error('status')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stats Display -->
            <div style="background: var(--sidebar-bg); border-radius: 12px; padding: 20px;">
                <h3 style="font-size: 14px; font-weight: 600; color: var(--text-light); margin-bottom: 16px; text-transform: uppercase;">Current Statistics</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 4px;">Total Votes</p>
                        <p style="font-size: 28px; font-weight: 800; color: var(--primary-gold);">{{ number_format($contestant->total_votes) }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 4px;">Rank in Category</p>
                        <p style="font-size: 28px; font-weight: 800; color: var(--text-dark);">#{{ $contestant->rank_in_category }}</p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border-light);">
                <a href="{{ route('organizer.events.show', $contestant->category->event) }}" class="quick-action-btn" style="background: transparent;">
                    Cancel
                </a>
                <button type="submit" class="create-event-btn">
                    <i class="fas fa-save"></i>
                    Update Contestant
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Danger Zone -->
<div class="section-card" style="max-width: 600px; margin-top: 24px; border: 2px solid #FEE2E2;">
    <h3 style="font-size: 18px; font-weight: 700; color: #991B1B; margin-bottom: 12px;">
        <i class="fas fa-exclamation-triangle"></i> Danger Zone
    </h3>
    <p style="color: var(--text-medium); margin-bottom: 16px;">
        Deleting this contestant will also delete all their votes. This action cannot be undone.
    </p>
    <form method="POST" action="{{ route('organizer.contestants.destroy', $contestant) }}" 
          onsubmit="return confirm('Are you sure you want to delete this contestant? All votes will be lost!')">
        @csrf
        @method('DELETE')
        <button type="submit" style="padding: 12px 24px; background: #EF4444; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-trash"></i> Delete Contestant
        </button>
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
                <img src="${URL.createObjectURL(file)}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 8px;">
                <p style="color: var(--text-medium); font-size: 14px;">${file.name}</p>
            `;
        }
    });
</script>
@endpush