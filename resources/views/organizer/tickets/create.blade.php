@extends('layouts.organizer')

@section('title', 'Create Ticket')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.tickets.index') }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Tickets
    </a>
</div>

<div class="section-card" style="max-width: 800px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Create Ticket for {{ $event->name }}</h1>
    <p style="color: var(--text-light); margin-bottom: 32px;">Set up ticket details for your event</p>

    <form method="POST" action="{{ route('organizer.tickets.store', $event) }}">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Ticket Name -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Ticket Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name') }}"
                       style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                       placeholder="e.g., VIP, Regular, Early Bird"
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
                          placeholder="Describe what's included with this ticket"
                          onfocus="this.style.borderColor='var(--primary-gold)'" 
                          onblur="this.style.borderColor='var(--border-light)'">{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price and Quantity -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Price (₦) <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="number" name="price" step="0.01" min="0" required value="{{ old('price', 0) }}"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                    @error('price')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Quantity <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="number" name="quantity" min="1" required value="{{ old('quantity', 100) }}"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                    @error('quantity')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sale Period -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Sale Start Date
                    </label>
                    <input type="date" name="sale_start" value="{{ old('sale_start') }}"
                        style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                        onfocus="this.style.borderColor='var(--primary-gold)'" 
                        onblur="this.style.borderColor='var(--border-light)'">
                    @error('sale_start')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                        Sale End Date
                    </label>
                    <input type="date" name="sale_end" value="{{ old('sale_end') }}"
                        style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                        onfocus="this.style.borderColor='var(--primary-gold)'" 
                        onblur="this.style.borderColor='var(--border-light)'">
                    @error('sale_end')
                        <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ticket Benefits -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Ticket Benefits
                </label>
                <div id="benefits-container">
                    <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                        <input type="text" name="benefits[]" placeholder="e.g., Front row seating"
                               style="flex: 1; padding: 12px 16px; border: 2px solid var(--border-light); border-radius: 10px; font-size: 14px;">
                        <button type="button" onclick="addBenefit()" 
                                style="padding: 12px 20px; background: var(--primary-gold); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border-light);">
                <a href="{{ route('organizer.tickets.index') }}" class="quick-action-btn" style="background: transparent;">
                    Cancel
                </a>
                <button type="submit" class="create-event-btn">
                    <i class="fas fa-plus"></i>
                    Create Ticket
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function addBenefit() {
    const container = document.getElementById('benefits-container');
    const newBenefit = document.createElement('div');
    newBenefit.style.cssText = 'display: flex; gap: 8px; margin-bottom: 8px;';
    newBenefit.innerHTML = `
        <input type="text" name="benefits[]" placeholder="e.g., Meet and greet"
               style="flex: 1; padding: 12px 16px; border: 2px solid var(--border-light); border-radius: 10px; font-size: 14px;">
        <button type="button" onclick="this.parentElement.remove()" 
                style="padding: 12px 20px; background: #EF4444; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(newBenefit);
}
</script>
@endpush