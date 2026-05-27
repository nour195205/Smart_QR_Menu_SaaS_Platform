<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart QR Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <i data-lucide="qr-code"></i> Smart QR
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard.index') }}" class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i> Overview
            </a>
            <a href="{{ route('dashboard.restaurant.edit') }}" class="nav-item {{ request()->routeIs('dashboard.restaurant.*') ? 'active' : '' }}">
                <i data-lucide="store"></i> Restaurant Settings
            </a>
            <a href="{{ route('dashboard.menu.index') }}" class="nav-item {{ request()->routeIs('dashboard.menu.*', 'dashboard.categories.*', 'dashboard.items.*') ? 'active' : '' }}">
                <i data-lucide="utensils"></i> Menu Builder
            </a>
            <a href="{{ route('dashboard.pdf.index') }}" class="nav-item {{ request()->routeIs('dashboard.pdf.*') ? 'active' : '' }}">
                <i data-lucide="file-text"></i> PDF Menus
            </a>
            <a href="{{ route('dashboard.theme.edit') }}" class="nav-item {{ request()->routeIs('dashboard.theme.*') ? 'active' : '' }}">
                <i data-lucide="palette"></i> Theme & Brand
            </a>
            <a href="{{ route('dashboard.qr.edit') }}" class="nav-item {{ request()->routeIs('dashboard.qr.*') ? 'active' : '' }}">
                <i data-lucide="scan-line"></i> QR Customizer
            </a>
        </nav>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-secondary" style="width: 100%">
                    <i data-lucide="log-out"></i> Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <div>
                <span style="font-weight: 500; color: var(--text-secondary);">Logged in as:</span>
                <strong style="margin-left: 8px;">{{ auth()->user()->name }}</strong>
            </div>
            <a href="https://{{ $restaurant->slug }}.yourdomain.com" target="_blank" class="btn btn-secondary">
                <i data-lucide="external-link"></i> View Live Menu
            </a>
        </header>

        <!-- Publish Banner -->
        @if($restaurant->has_unpublished_changes)
            <div class="publish-banner">
                <div>
                    <p>You have unpublished changes! <span style="font-weight: 400;">Publish them to update your live menu.</span></p>
                </div>
                <form method="POST" action="{{ route('dashboard.publish.publish') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" onclick="this.innerHTML='<i data-lucide=\'loader-2\' class=\'spin\'></i> Publishing...'; this.style.opacity='0.8';">
                        <i data-lucide="upload-cloud"></i> Publish Changes
                    </button>
                </form>
            </div>
        @endif

        <div class="page-container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-success" style="background: rgba(59, 130, 246, 0.1); color: #3B82F6; border-color: rgba(59, 130, 246, 0.2);">{{ session('info') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
