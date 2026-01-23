@extends('layouts.organizer')

@section('title', 'Add Category')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.events.show', $event) }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to {{ $event->name }}
    </a>
</div>

<div class="section-card" style="max-width: 600px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Add Category</h1>
    <p style="color: var(--text-light); margin-bottom: 32px;">Add a new voting category to {{ $event->name }}</p>

    <form method="POST" action="{{ route('organizer.categories.store', $event) }}">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Category Name -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Category Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name') }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                       placeholder="e.g., Best Male Artist"
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
                @error('name')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Description
                </label>
                <textarea name="description" rows="3"
                          style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; resize: vertical;"
                          placeholder="Brief description of this category"
                          onfocus="this.style.borderColor='var(--primary-gold)'" 
                          onblur="this.style.borderColor='var(--border-light)'">{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Display Order -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Display Order
                </label>
                <input type="number" name="order" min="0" value="{{ old('order', 0) }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
                <p style="color: var(--text-light); font-size: 13px; margin-top: 6px;">Lower numbers appear first</p>
                @error('order')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border-light);">
                <a href="{{ route('organizer.events.show', $event) }}" class="quick-action-btn" style="background: transparent;">
                    Cancel
                </a>
                <button type="submit" class="create-event-btn">
                    <i class="fas fa-plus"></i>
                    Add Category
                </button>
            </div>
        </div>
    </form>
</div>
@endsection