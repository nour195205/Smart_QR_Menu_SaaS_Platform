<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MenuFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        
        <style>
            .guest-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                width: 100%;
                padding: 20px;
                background-color: var(--bg-main);
            }
            .guest-card {
                width: 100%;
                max-width: 450px;
                background: var(--bg-surface);
                border: 1px solid var(--border);
                border-radius: 12px;
                padding: 32px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            }
            .guest-logo {
                margin-bottom: 24px;
                text-align: center;
                color: var(--accent-primary);
                font-size: 2.5rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                text-decoration: none;
            }
            .guest-logo:hover {
                color: var(--accent-hover);
            }
        </style>
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="dashboard-body">
        <div class="guest-container">
            <a href="/" class="guest-logo">
                <i data-lucide="qr-code" style="width: 40px; height: 40px;"></i> MenuFlow
            </a>
            
            <div class="guest-card">
                {{ $slot }}
            </div>
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
