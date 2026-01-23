@extends('layouts.organizer')

@section('title', 'Edit Category')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.events.show', $category->event) }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to {{ $category->event->name }}
    </a>
</div>

<div class="section-card" style="max-width: 600px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Edit Category</h1>
    <p style="color: var(--text-light); margin-bottom: 32px;">Update category details</p>

    <form method="POST" action="{{ route('organizer.categories.update', $category) }}">
        @csrf
        @method('PUT')
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Category Name -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Category Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name', $category->name) }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
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
                          onfocus="this.style.borderColor='var(--primary-gold)'" 
                          onblur="this.style.borderColor='var(--border-light)'">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Display Order -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Display Order
                </label>
                <input type="number" name="order" min="0" value="{{ old('order', $category->order) }}"
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
                <a href="{{ route('organizer.events.show', $category->event) }}" class="quick-action-btn" style="background: transparent;">
                    Cancel
                </a>
                <button type="submit" class="create-event-btn">
                    <i class="fas fa-save"></i>
                    Update Category
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
        Deleting this category will also delete all contestants and their votes. This action cannot be undone.
    </p>
    <form method="POST" action="{{ route('organizer.categories.destroy', $category) }}" 
          onsubmit="return confirm('Are you sure you want to delete this category? This will delete all contestants and votes!')">
        @csrf
        @method('DELETE')
        <button type="submit" style="padding: 12px 24px; background: #EF4444; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-trash"></i> Delete Category
        </button>
    </form>
</div>
@endsection