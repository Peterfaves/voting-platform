@extends('layouts.organizer')

@section('title', 'Edit Ticket')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.tickets.index') }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Tickets
    </a>
</div>

<div class="section-card" style="max-width: 800px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Edit Ticket</h1>
    <p style="color: var(--text-light); margin-bottom: 32px;">Update ticket details for {{ $ticket->event->name }}</p>

    <form method="POST" action="{{ route('organizer.tickets.update', $ticket) }}">
        @csrf
        @method('PUT')
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Ticket Name -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Ticket Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name', $ticket->name) }}"
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
                          onblur="this.style.borderColor='var(--border-light)'">{{ old('description', $ticket->description) }}</textarea>
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
                    <input type="number" name="price" step="0.01" min="0" required value="{{ old('price', $ticket->price) }}"
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
                    <input type="number" name="quantity" min="{{ $ticket->sold }}" required value="{{ old('quantity', $ticket->quantity) }}"
                           style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                           onfocus="this.style.borderColor='var(--primary-gold)'" 
                           onblur="this.style.borderColor='var(--border-light)'">
                    <p style="color: var(--text-light); font-size: 13px; margin-top: 6px;">
                        Minimum: {{ $ticket->sold }} (already sold)
                    </p>
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
                    <input type="date" name="sale_start" 
                        value="{{ old('sale_start', $ticket->sale_start?->format('Y-m-d')) }}"
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
                    <input type="date" name="sale_end" 
                        value="{{ old('sale_end', $ticket->sale_end?->format('Y-m-d')) }}"
                        style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px;"
                        onfocus="this.style.borderColor='var(--primary-gold)'" 
                        onblur="this.style.borderColor='var(--border-light)'">
                    @error('sale_end')
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
                    <option value="active" {{ old('status', $ticket->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $ticket->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ticket Benefits -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                    Ticket Benefits
                </label>
                <div id="benefits-container">
                    @if($ticket->benefits && count($ticket->benefits) > 0)
                        @foreach($ticket->benefits as $benefit)
                            <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                                <input type="text" name="benefits[]" value="{{ $benefit }}"
                                       style="flex: 1; padding: 12px 16px; border: 2px solid var(--border-light); border-radius: 10px; font-size: 14px;">
                                <button type="button" onclick="this.parentElement.remove()" 
                                        style="padding: 12px 20px; background: #EF4444; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        @endforeach
                    @endif
                    <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                        <input type="text" name="benefits[]" placeholder="Add new benefit"
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
                    <i class="fas fa-save"></i>
                    Update Ticket
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Danger Zone -->
@if($ticket->sold == 0)
<div class="section-card" style="max-width: 800px; margin-top: 24px; border: 2px solid #FEE2E2;">
    <h3 style="font-size: 18px; font-weight: 700; color: #991B1B; margin-bottom: 12px;">
        <i class="fas fa-exclamation-triangle"></i> Danger Zone
    </h3>
    <p style="color: var(--text-medium); margin-bottom: 16px;">
        Deleting this ticket will permanently remove it. This action cannot be undone.
    </p>
    <form method="POST" action="{{ route('organizer.tickets.destroy', $ticket) }}" 
          onsubmit="return confirm('Are you sure you want to delete this ticket?')">
        @csrf
        @method('DELETE')
        <button type="submit" style="padding: 12px 24px; background: #EF4444; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-trash"></i> Delete Ticket
        </button>
    </form>
</div>
@endif
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