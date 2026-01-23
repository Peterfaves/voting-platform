@extends('layouts.organizer')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <!-- Total Votes Card -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_votes'] ?? 0) }}</div>
            <div class="stat-label">Total Votes</div>
            <div class="stat-details">
                <p>- This week: {{ number_format($stats['votes_this_week'] ?? 0) }}</p>
                <p>
                    - Last week: {{ number_format($stats['votes_last_week'] ?? 0) }}
                    @if(($stats['votes_last_week'] ?? 0) > ($stats['votes_this_week'] ?? 0))
                        <i class="fas fa-arrow-down trend-down"></i>
                    @elseif(($stats['votes_last_week'] ?? 0) < ($stats['votes_this_week'] ?? 0))
                        <i class="fas fa-arrow-up trend-up"></i>
                    @endif
                </p>
            </div>
        </div>

        <!-- Total Earnings Card -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-value">₦{{ number_format($stats['total_earnings'] ?? 0) }}</div>
            <div class="stat-label">Total Earnings</div>
            <div class="stat-details">
                <p>- This week: ₦{{ number_format($stats['earnings_this_week'] ?? 0) }}</p>
                <p>
                    - Last week: ₦{{ number_format($stats['earnings_last_week'] ?? 0) }}
                    @if(($stats['earnings_last_week'] ?? 0) > ($stats['earnings_this_week'] ?? 0))
                        <i class="fas fa-arrow-down trend-down"></i>
                    @elseif(($stats['earnings_last_week'] ?? 0) < ($stats['earnings_this_week'] ?? 0))
                        <i class="fas fa-arrow-up trend-up"></i>
                    @endif
                </p>
            </div>
        </div>

        <!-- Total Events Card -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_events'] ?? 0) }}</div>
            <div class="stat-label">Total Events</div>
            <div class="stat-details">
                <p>- Active: {{ $stats['active_events'] ?? 0 }}</p>
                <p>- Completed: {{ $stats['completed_events'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="section-card">
        <h2 class="section-title">
            Quick Actions <i class="fas fa-bolt"></i>
        </h2>
        <div class="quick-actions-grid">
            <a href="{{ route('organizer.reports') }}" class="quick-action-btn">
                <i class="fas fa-eye"></i>
                View Report
            </a>
            <a href="{{ route('organizer.withdrawals') }}" class="quick-action-btn">
                <i class="fas fa-hand-holding-usd"></i>
                Withdraw Earnings
            </a>
            <a href="{{ route('organizer.events.index') }}" class="quick-action-btn">
                <i class="fas fa-calendar-alt"></i>
                View Events
            </a>
            <a href="{{ route('organizer.contact') }}" class="quick-action-btn">
                <i class="fas fa-wrench"></i>
                Contact Support
            </a>
            <a href="{{ route('organizer.tickets.index') }}" class="quick-action-btn">
                <i class="fas fa-ticket-alt"></i>
                Manage Tickets
            </a>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="two-col-grid">
        <!-- Recent Transactions -->
        <div class="section-card">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-chart-line"></i>
                    <div>
                        <h3>Recent Transactions</h3>
                        <span>Latest 5 Transactions</span>
                    </div>
                </div>
                <a href="{{ route('organizer.transactions') }}" class="see-all-btn">see all</a>
            </div>

            @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Contestant</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->voter_email ?? 'N/A' }}</td>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>₦{{ number_format($transaction->amount_paid ?? 0, 2) }}</td>
                                <td>{{ $transaction->contestant->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $transaction->payment_status ?? 'pending' }}">
                                        {{ ucfirst($transaction->payment_status ?? 'Pending') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No transactions found.</p>
                </div>
            @endif
        </div>

        <!-- Calendar Widget -->
        <div class="calendar-widget">
            <div class="calendar-header">
                <div class="calendar-nav">
                    <button onclick="changeMonth(-1)" type="button">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="calendar-month" id="currentMonth">{{ now()->format('F Y') }}</span>
                    <button onclick="changeMonth(1)" type="button">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div class="calendar-grid" id="calendarGrid">
                <!-- Day Headers -->
                <div class="calendar-day-header">S</div>
                <div class="calendar-day-header">M</div>
                <div class="calendar-day-header">T</div>
                <div class="calendar-day-header">W</div>
                <div class="calendar-day-header">T</div>
                <div class="calendar-day-header">F</div>
                <div class="calendar-day-header">S</div>
            </div>
        </div>
    </div>

    <!-- Top Contestants Section -->
    <div class="top-contestants">
        @if(isset($topContestants) && $topContestants->count() > 0)
            <h3 class="section-title"><i class="fas fa-trophy"></i> Top Contestants</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 16px;">
                @foreach($topContestants as $contestant)
                    <div style="text-align: center; padding: 16px; background: var(--sidebar-bg); border-radius: 12px;">
                        @if($contestant->photo)
                            <img src="{{ asset('storage/' . $contestant->photo) }}" alt="{{ $contestant->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin: 0 auto 12px;">
                        @else
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--primary-gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; color: white; font-size: 24px; font-weight: 700;">
                                {{ strtoupper(substr($contestant->name, 0, 1)) }}
                            </div>
                        @endif
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 4px;">{{ $contestant->name }}</h4>
                        <p style="font-size: 12px; color: var(--text-light);">{{ number_format($contestant->total_votes) }} votes</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="contestant-placeholder">
                YOUR TOP CONTESTANT WOULD APPEAR HERE
            </div>
        @endif
    </div>

    <!-- Welcome CTA (shown when user has no events) -->
    @if(($stats['total_events'] ?? 0) == 0)
        <div class="welcome-cta">
            <h2>Welcome to your dashboard</h2>
            <p>Ready to host your first pageant?</p>
            <a href="{{ route('organizer.events.create') }}" class="create-event-btn">
                <i class="fas fa-plus"></i>
                Create New Event
            </a>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    let currentDate = new Date();
    const today = new Date();
    
    // Event dates from server (if any)
    const eventDates = @json($eventDates ?? []);

    function renderCalendar() {
        const grid = document.getElementById('calendarGrid');
        const monthLabel = document.getElementById('currentMonth');
        
        if (!grid || !monthLabel) return;
        
        // Clear existing days (keep headers)
        const headers = Array.from(grid.querySelectorAll('.calendar-day-header'));
        grid.innerHTML = '';
        headers.forEach(h => grid.appendChild(h));

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Update month label
        monthLabel.textContent = currentDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

        // Get first day of month and total days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        // Previous month days
        for (let i = firstDay - 1; i >= 0; i--) {
            const day = document.createElement('div');
            day.className = 'calendar-day other-month';
            day.textContent = daysInPrevMonth - i;
            grid.appendChild(day);
        }

        // Current month days
        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement('div');
            day.className = 'calendar-day';
            day.textContent = i;

            // Check if today
            if (year === today.getFullYear() && month === today.getMonth() && i === today.getDate()) {
                day.classList.add('today');
            }

            // Check if has event
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            if (eventDates.includes(dateStr)) {
                day.classList.add('has-event');
            }

            grid.appendChild(day);
        }

        // Next month days to fill the grid
        const totalCells = firstDay + daysInMonth;
        const remainingCells = totalCells <= 35 ? 35 - totalCells : 42 - totalCells;
        for (let i = 1; i <= remainingCells; i++) {
            const day = document.createElement('div');
            day.className = 'calendar-day other-month';
            day.textContent = i;
            grid.appendChild(day);
        }
    }

    function changeMonth(delta) {
        currentDate.setMonth(currentDate.getMonth() + delta);
        renderCalendar();
    }

    // Initialize calendar
    document.addEventListener('DOMContentLoaded', renderCalendar);
</script>
@endpush