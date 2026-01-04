<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin LelangKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --accent: #fbbf24;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #0f0f23;
            --dark-light: #1a1a2e;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --white: #fff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--dark);
            color: var(--white);
            min-height: 100vh;
            display: flex;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .sidebar {
            width: 260px;
            background: var(--dark-light);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            height: 100vh;
            position: fixed;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo i {
            color: var(--primary);
        }

        .sidebar-logo span {
            color: var(--accent);
        }

        .sidebar-menu {
            list-style: none;
            flex: 1;
        }

        .sidebar-item {
            margin-bottom: 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            color: var(--gray-400);
            transition: all 0.3s;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(99, 102, 241, 0.2);
            color: var(--white);
        }

        .sidebar-link i {
            width: 20px;
        }

        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 2rem;
            min-height: 100vh;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
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
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }

        .card {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            overflow: hidden;
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .stat-label {
            color: var(--gray-400);
            font-size: 0.875rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .table th {
            background: rgba(255, 255, 255, 0.05);
            font-weight: 600;
        }

        .table tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .badge {
            display: inline-flex;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
        }

        .badge-success {
            background: var(--success);
            color: white;
        }

        .badge-warning {
            background: var(--warning);
            color: white;
        }

        .badge-danger {
            background: var(--danger);
            color: white;
        }

        .badge-primary {
            background: var(--primary);
            color: white;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-400);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            color: var(--white);
            background-color: rgba(0, 0, 0, 0.2);
            font-family: inherit;
        }

        .form-control::placeholder {
            color: var(--gray-500);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background-color: var(--dark-light);
        }

        select.form-control option {
            background-color: var(--dark-light);
            color: var(--white);
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-logo"><i class="fas fa-gavel"></i> <span>Admin</span></div>
        <ul class="sidebar-menu">
            <li class="sidebar-item"><a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i
                        class="fas fa-home"></i> Dashboard</a></li>
            <li class="sidebar-item"><a href="{{ route('admin.items.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}"><i
                        class="fas fa-box"></i> Item Lelang</a></li>
            <li class="sidebar-item"><a href="{{ route('admin.categories.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i
                        class="fas fa-tags"></i> Kategori</a></li>
            <li class="sidebar-item"><a href="{{ route('admin.users.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i
                        class="fas fa-users"></i> Pengguna</a></li>
            <li class="sidebar-item"><a href="{{ route('admin.reports') }}"
                    class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}"><i
                        class="fas fa-chart-bar"></i> Laporan</a></li>
        </ul>
        <div style="padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ route('home') }}" class="sidebar-link"><i class="fas fa-arrow-left"></i> Kembali ke Site</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf<button type="submit" class="sidebar-link"
                        style="width:100%;background:none;border:none;cursor:pointer;"><i
                            class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </aside>
    <main class="main-content">
        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
        @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>@endif
        @yield('content')
    </main>
    @yield('scripts')
</body>

</html>