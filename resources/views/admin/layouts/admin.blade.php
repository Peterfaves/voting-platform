<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VoteAfrika') }} Admin - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            /* Admin-specific colors - darker, more authoritative */
            --admin-primary: #1E293B;
            --admin-primary-light: #334155;
            --admin-secondary: #0F172A;
            --admin-accent: #dab904;
            --admin-accent-dark: #bc893a;
            
            /* Sidebar */
            --sidebar-bg: #0F172A;
            --sidebar-hover: #1E293B;
            --sidebar-active: #334155;
            --sidebar-text: #94A3B8;
            --sidebar-text-active: #FFFFFF;
            
            /* Main area */
            --main-bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --border-color: #E2E8F0;
            
            /* Text */
            --text-dark: #0F172A;
            --text-medium: #475569;
            --text-light: #94A3B8;
            
            /* Status colors */
            --success: #10B981;
            --success-bg: #D1FAE5;
            --warning: #F59E0B;
            --warning-bg: #FEF3C7;
            --danger: #EF4444;
            --danger-bg: #FEE2E2;
            --info: #3B82F6;
            --info-bg: #DBEAFE;
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

        .font-display {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* Layout */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ============================================
           SIDEBAR
           ============================================ */
        .admin-sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--admin-accent) 0%, var(--admin-accent-dark) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo-icon svg {
            width: 24px;
            height: 24px;
            color: #1a1a00;
        }

        .sidebar-logo-text {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: white;
        }

        .sidebar-logo-text span {
            color: var(--admin-accent);
        }

        .admin-badge {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(218, 185, 4, 0.15);
            color: var(--admin-accent);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 4px;
            margin-left: 8px;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 20px 12px;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--sidebar-text);
            padding: 0 16px;
            margin-bottom: 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-active);
        }

        .nav-item.active {
            background: var(--sidebar-active);
            color: var(--sidebar-text-active);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: var(--admin-accent);
            border-radius: 0 3px 3px 0;
        }

        .nav-item i {
            width: 20px;
            font-size: 16px;
            text-align: center;
        }

        .nav-item-badge {
            margin-left: auto;
            padding: 2px 8px;
            background: var(--danger);
            color: white;
            font-size: 11px;
            font-weight: 700;
            border-radius: 10px;
        }

        .nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 16px 12px;
        }

        /* ============================================
           MAIN CONTENT
           ============================================ */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
        }

        /* Top Header */
        .admin-header {
            background: var(--card-bg);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--text-medium);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .breadcrumb a {
            color: var(--text-light);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: var(--admin-accent);
        }

        .breadcrumb span {
            color: var(--text-dark);
            font-weight: 600;
        }

        .breadcrumb i {
            font-size: 10px;
            color: var(--text-light);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-search {
            position: relative;
        }

        .header-search input {
            width: 280px;
            padding: 10px 16px 10px 42px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            background: var(--main-bg);
            transition: all 0.2s ease;
        }

        .header-search input:focus {
            outline: none;
            border-color: var(--admin-accent);
            background: white;
        }

        .header-search i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 14px;
        }

        .header-btn {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-medium);
            font-size: 16px;
            transition: all 0.2s ease;
            position: relative;
        }

        .header-btn:hover {
            border-color: var(--admin-accent);
            color: var(--admin-accent);
        }

        .header-btn .badge {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px 6px 6px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .admin-profile:hover {
            background: var(--main-bg);
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .admin-info {
            text-align: left;
        }

        .admin-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-dark);
        }

        .admin-role {
            font-size: 12px;
            color: var(--text-light);
        }

        /* Page Content */
        .page-content {
            padding: 32px;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 15px;
            color: var(--text-medium);
        }

        /* ============================================
           STATS CARDS
           ============================================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            border-color: var(--admin-accent);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.primary {
            background: rgba(218, 185, 4, 0.1);
            color: var(--admin-accent-dark);
        }

        .stat-icon.success {
            background: var(--success-bg);
            color: var(--success);
        }

        .stat-icon.info {
            background: var(--info-bg);
            color: var(--info);
        }

        .stat-icon.warning {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .stat-icon.danger {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .stat-trend.up {
            background: var(--success-bg);
            color: var(--success);
        }

        .stat-trend.down {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-medium);
            font-weight: 500;
        }

        /* ============================================
           CARDS & TABLES
           ============================================ */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .card-title i {
            color: var(--admin-accent);
        }

        .card-body {
            padding: 24px;
        }

        .card-body.no-padding {
            padding: 0;
        }

        /* Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 14px 20px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: var(--main-bg);
            border-bottom: 1px solid var(--border-color);
        }

        .data-table td {
            padding: 16px 20px;
            font-size: 14px;
            color: var(--text-medium);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: var(--main-bg);
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: var(--success-bg);
            color: var(--success);
        }

        .badge-warning {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .badge-danger {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .badge-info {
            background: var(--info-bg);
            color: var(--info);
        }

        .badge-secondary {
            background: #F1F5F9;
            color: var(--text-medium);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--admin-accent) 0%, var(--admin-accent-dark) 100%);
            color: #1a1a00;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(218, 185, 4, 0.3);
        }

        .btn-secondary {
            background: var(--card-bg);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            border-color: var(--admin-accent);
            color: var(--admin-accent);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            justify-content: center;
        }

        /* User/Avatar */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .user-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .user-info p {
            font-size: 12px;
            color: var(--text-light);
        }

        /* Grid layouts */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--text-medium);
        }

        /* Charts placeholder */
        .chart-container {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--main-bg);
            border-radius: 12px;
            color: var(--text-light);
        }

        /* Mobile Responsive */
        @media (max-width: 1400px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .grid-2, .grid-3 {
                grid-template-columns: 1fr;
            }
            
            .header-search {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-main {
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

            .admin-header {
                padding: 12px 16px;
            }

            .admin-info {
                display: none;
            }

            .data-table {
                display: block;
                overflow-x: auto;
            }
        }

        /* Sidebar Overlay */
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

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--main-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-light);
        }

        /* Additional Utility Classes */
        .text-success { color: var(--success); }
        .text-danger { color: var(--danger); }
        .text-warning { color: var(--warning); }
        .text-muted { color: var(--text-light); }
        .font-mono { font-family: 'SF Mono', 'Monaco', monospace; }
        .mb-0 { margin-bottom: 0; }
        .mb-4 { margin-bottom: 16px; }
        .mb-6 { margin-bottom: 24px; }
        .mt-4 { margin-top: 16px; }
        .mt-6 { margin-top: 24px; }
    </style>

    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <img src="{{ asset('images/voteafrika-logo.png') }}" alt="VoteAfrika" class="sidebar-logo-icon">
                    </div>
                    <span class="sidebar-logo-text">Vote<span>Afrika</span></span>
                    <span class="admin-badge">Admin</span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <!-- Main Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Organizers</span>
                    </a>
                    <a href="{{ route('admin.events.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Events</span>
                    </a>
                </div>

                <!-- Financial Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Financial</div>
                    <a href="{{ route('admin.withdrawals.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Withdrawals</span>
                        @if(isset($pendingWithdrawalsCount) && $pendingWithdrawalsCount > 0)
                            <span class="nav-item-badge">{{ $pendingWithdrawalsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.transactions.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transactions</span>
                    </a>
                    <a href="{{ route('admin.tickets.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Ticket Sales</span>
                    </a>
                </div>

                <!-- System Section -->
                <div class="nav-section">
                    <div class="nav-section-title">System</div>
                    <a href="{{ route('admin.reports.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="fas fa-flag"></i>
                        <span>Reports</span>
                    </a>
                    <a href="{{ route('admin.settings.index') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <a href="{{ route('admin.audit-logs') ?? '#' }}" class="nav-item {{ request()->routeIs('admin.audit-logs') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span>Audit Logs</span>
                    </a>
                </div>

                <div class="nav-divider"></div>

                <!-- Account -->
                <a href="{{ route('landing') }}" class="nav-item" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>View Site</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-item" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <nav class="breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Admin</a>
                        <i class="fas fa-chevron-right"></i>
                        @yield('breadcrumb', '<span>Dashboard</span>')
                    </nav>
                </div>

                <div class="header-right">
                    <div class="header-search">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                    <button class="header-btn">
                        <i class="fas fa-bell"></i>
                        <span class="badge"></span>
                    </button>
                    <div class="admin-profile">
                        <div class="admin-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="admin-info">
                            <div class="admin-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="admin-role">Super Admin</div>
                        </div>
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

        // Close sidebar on outside click (mobile)
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

    @stack('scripts')
</body>
</html>
