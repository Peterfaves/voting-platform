@extends('layouts.organizer')

@section('title', 'Edit Event')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.events.show', $event) }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Event
    </a>
</div>

<div class="section-card" style="max-width: 800px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Edit Event</h1>
    <p style="color: var(--text-light); margin-bottom: 32px;">Update your event details</p>

    <form method="POST" action="{{ route('organizer.events.update', $event) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Event Name -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Event Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name', $event->name) }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; transition: border-color 0.2s;"
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
                          onfocus="this.style.borderColor='var(--primary-gold)'" 
                          onblur="this.style.borderColor='var(--border-light)'">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Banner Image -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Banner Image
                </label>
                @if($event->banner_image)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $event->banner_image) }}" 
                             style="max-height: 150px; border-radius: 12px;">
                        <p style="color: var(--text-light); font-size: 13px; margin-top: 6px;">Current banner</p>
                    </div>
                @endif
                <div style="border: 2px dashed var(--border-light); border-radius: 12px; padding: 24px; text-align: center; cursor: pointer;" 
                     onclick="document.getElementById('banner_input').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 24px; color: var(--primary-gold); margin-bottom: 8px;"></i>
                    <p style="color: var(--text-medium); font-size: 14px;">Click to upload new banner</p>
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
                <input type="number" name="vote_price" step="0.01" min="0" required value="{{ old('vote_price', $event->vote_price) }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
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
                    <input type="date" name="start_date" required value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}"
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
                    <input type="date" name="end_date" required value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                    @error('end_date')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>
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
                    <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ old('status', $event->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border-light);">
                <a href="{{ route('organizer.events.show', $event) }}" class="quick-action-btn" style="background: transparent;">
                    Cancel
                </a>
                <button type="submit" class="create-event-btn">
                    <i class="fas fa-save"></i>
                    Update Event
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Danger Zone -->
<div class="section-card" style="max-width: 800px; margin-top: 24px; border: 2px solid #FEE2E2;">
    <h3 style="font-size: 18px; font-weight: 700; color: #991B1B; margin-bottom: 12px;">
        <i class="fas fa-exclamation-triangle"></i> Danger Zone
    </h3>
    <p style="color: var(--text-medium); margin-bottom: 16px;">
        Deleting this event will also delete all categories, contestants, and votes. This action cannot be undone.
    </p>
    <form method="POST" action="{{ route('organizer.events.destroy', $event) }}" 
          onsubmit="return confirm('Are you sure you want to delete this event? This will delete all data and cannot be undone!')">
        @csrf
        @method('DELETE')
        <button type="submit" style="padding: 12px 24px; background: #EF4444; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-trash"></i> Delete Event
        </button>
    </form>
</div>
@endsection