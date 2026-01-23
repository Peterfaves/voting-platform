<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VoteAfrika') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Styles -->
    <style>
        :root {
            --primary-gold: #C5A94D;
            --primary-gold-dark: #A89040;
            --primary-gold-light: #D4BC6A;
            --sidebar-bg: #F7F6E7;
            --sidebar-hover: #EFEDDA;
            --sidebar-active: #E8E5CC;
            --main-bg: #FAFAF5;
            --card-bg: #FFFFFF;
            --text-dark: #1A1A1A;
            --text-medium: #4A4A4A;
            --text-light: #7A7A7A;
            --border-light: #E5E5E5;
            --success: #22C55E;
            --danger: #EF4444;
            --warning: #F59E0B;
            --info: #3B82F6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--main-bg);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Layout */
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-light);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 2px;
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .logo-text {
            font-family: 'Space Grotesk', 'Plus Jakarta Sans', sans-serif;
            font-size: 22px;
            font-weight: 600;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .logo-text .logo-v {
            color: var(--primary-gold);
            font-style: ;
            font-family: 'Space Grotesk',
        }

        .sidebar-nav {
            padding: 16px 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 12px;
            color: var(--text-medium);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: var(--text-dark);
        }

        .nav-item.active {
            background: var(--sidebar-active);
            color: var(--primary-gold);
            font-weight: 600;
        }

        .nav-item i {
            width: 22px;
            font-size: 18px;
            text-align: center;
        }

        .nav-divider {
            height: 1px;
            background: rgba(0,0,0,0.08);
            margin: 16px 12px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
        }

        /* Top Header */
        .top-header {
            background: var(--card-bg);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .welcome-text {
            font-size: 18px;
            color: var(--text-medium);
        }

        .welcome-text strong {
            color: var(--text-dark);
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid var(--border-light);
            background: var(--card-bg);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-medium);
            font-size: 18px;
            transition: all 0.2s ease;
            position: relative;
        }

        .notification-btn:hover {
            border-color: var(--primary-gold);
            color: var(--primary-gold);
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .user-dropdown:hover {
            background: var(--sidebar-bg);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E91E63, #9C27B0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 15px;
        }

        /* Page Content */
        .page-content {
            padding: 32px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-dark) 100%);
            border-radius: 20px;
            padding: 28px;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 180px;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 400'%3E%3Cpath fill='rgba(255,255,255,0.1)' d='M200 50c-80 0-150 70-150 150s70 150 150 150 150-70 150-150S280 50 200 50zm0 250c-55 0-100-45-100-100s45-100 100-100 100 45 100 100-45 100-100 100z'/%3E%3C/svg%3E") no-repeat center right;
            background-size: contain;
            opacity: 0.3;
        }

        .stat-value {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .stat-label {
            font-size: 16px;
            font-weight: 500;
            opacity: 0.95;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .stat-details {
            font-size: 13px;
            opacity: 0.85;
            position: relative;
            z-index: 1;
        }

        .stat-details p {
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-details .trend-down {
            color: #FFCDD2;
        }

        .stat-details .trend-up {
            color: #C8E6C9;
        }

        .stat-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        /* Quick Actions */
        .section-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary-gold);
        }

        .quick-actions-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: center;
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 24px;
            border: 2px solid var(--primary-gold);
            border-radius: 12px;
            background: transparent;
            color: var(--text-dark);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .quick-action-btn:hover {
            background: var(--primary-gold);
            color: white;
        }

        .quick-action-btn i {
            font-size: 16px;
        }

        /* Two Column Layout */
        .two-col-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 24px;
        }

        /* Transactions Table */
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-title i {
            font-size: 20px;
            color: var(--primary-gold);
        }

        .table-title h3 {
            font-size: 18px;
            font-weight: 700;
        }

        .table-title span {
            font-size: 13px;
            color: var(--text-light);
            font-weight: 400;
        }

        .see-all-btn {
            padding: 8px 20px;
            border: 2px solid var(--primary-gold);
            border-radius: 8px;
            background: transparent;
            color: var(--primary-gold);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .see-all-btn:hover {
            background: var(--primary-gold);
            color: white;
        }

        .transactions-table {
            width: 100%;
            border-collapse: collapse;
        }

        .transactions-table th {
            text-align: left;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-light);
        }

        .transactions-table td {
            padding: 16px;
            font-size: 14px;
            color: var(--text-medium);
            border-bottom: 1px solid var(--border-light);
        }

        .transactions-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-success {
            background: #DCFCE7;
            color: #166534;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-failed {
            background: #FEE2E2;
            color: #991B1B;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Calendar */
        .calendar-widget {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .calendar-nav button {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border-light);
            background: var(--card-bg);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .calendar-nav button:hover {
            border-color: var(--primary-gold);
            color: var(--primary-gold);
        }

        .calendar-month {
            font-size: 18px;
            font-weight: 700;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .calendar-day-header {
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-light);
            padding: 8px;
        }

        .calendar-day {
            text-align: center;
            padding: 10px 8px;
            font-size: 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .calendar-day:hover {
            background: var(--sidebar-bg);
        }

        .calendar-day.other-month {
            color: var(--text-light);
            opacity: 0.5;
        }

        .calendar-day.today {
            background: var(--primary-gold);
            color: white;
            font-weight: 700;
        }

        .calendar-day.has-event {
            position: relative;
        }

        .calendar-day.has-event::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: var(--primary-gold);
            border-radius: 50%;
        }

        /* Top Contestants */
        .top-contestants {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            margin-top: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }

        .contestant-placeholder {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
            font-size: 15px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Welcome CTA */
        .welcome-cta {
            text-align: center;
            padding: 60px 40px;
            background: var(--card-bg);
            border-radius: 20px;
            margin-top: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }

        .welcome-cta h2 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 12px;
            color: var(--text-dark);
        }

        .welcome-cta p {
            font-size: 16px;
            color: var(--text-light);
            margin-bottom: 28px;
        }

        .create-event-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            background: var(--primary-gold);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .create-event-btn:hover {
            background: var(--primary-gold-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(197, 169, 77, 0.3);
        }

        /* Mobile Responsive */
        .mobile-menu-btn {
            display: none;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid var(--border-light);
            background: var(--card-bg);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .two-col-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-content {
                padding: 20px;
            }

            .quick-actions-grid {
                flex-direction: column;
            }

            .quick-action-btn {
                justify-content: center;
            }

            .top-header {
                padding: 12px 16px;
            }

            .welcome-text {
                font-size: 14px;
            }

            .logo-icon {
                width: 32px;
                height: 32px;
            }

            .logo-text {
                font-size: 22px;
            }
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--sidebar-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gold-light);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-gold);
        }
    </style>

</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('organizer.dashboard') }}" class="logo">
                    <!-- Logo Icon -->
                    <img src="{{ asset('images/voteafrika-logo.png') }}" alt="VoteAfrika" class="logo-icon">
                    <!-- Logo Text -->
                    <span class="logo-text"><span class="logo-v">VoteAfrika</span></span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('organizer.dashboard') }}" class="nav-item {{ request()->routeIs('organizer.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('organizer.events.index') }}" class="nav-item {{ request()->routeIs('organizer.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Events</span>
                </a>
                
                <a href="{{ route('organizer.events.manage') }}" class="nav-item {{ request()->routeIs('organizer.events.manage') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span>Manage Events</span>
                </a>
                
                <a href="{{ route('organizer.reports') }}" class="nav-item {{ request()->routeIs('organizer.reports') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </a>
                
                <a href="{{ route('organizer.withdrawals') }}" class="nav-item {{ request()->routeIs('organizer.withdrawals') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Withdrawals</span>
                </a>
                
                <a href="{{ route('organizer.tickets.index') }}" class="nav-item {{ request()->routeIs('organizer.tickets.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Tickets</span>
                </a>
                
                <a href="{{ route('organizer.transactions') }}" class="nav-item {{ request()->routeIs('organizer.transactions') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transactions</span>
                </a>
                
                <a href="{{ route('organizer.settings') }}" class="nav-item {{ request()->routeIs('organizer.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>

                <div class="nav-divider"></div>

                <a href="{{ route('organizer.contact') }}" class="nav-item {{ request()->routeIs('organizer.contact') ? 'active' : '' }}">
                    <i class="fas fa-phone-alt"></i>
                    <span>Contact</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="nav-item" style="border: none; background: none; width: 100%;">
                    @csrf
                    <button type="submit" class="nav-item" style="border: none; background: none; width: 100%; cursor: pointer; padding: 0; display: flex; align-items: center; gap: 14px;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="welcome-text">Welcome Back, <strong>{{ Auth::user()->name }}.</strong></span>
                </div>

                <div class="header-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span class="notification-badge"></span>
                        @endif
                    </button>

                    <div class="user-dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}.</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !menuBtn.contains(event.target) && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            }
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>