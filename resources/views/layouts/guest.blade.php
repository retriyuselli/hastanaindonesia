<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @if(file_exists(public_path('build/manifest.json')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif

        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
            .guest-body {
                margin: 0;
                color: #111827;
                background: #ffffff;
            }
            .guest-page {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 24px 16px;
                background: #ffffff;
            }
            .guest-logo-wrap {
                margin-bottom: 18px;
            }
            .guest-logo-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
            }
            .guest-logo {
                height: 72px;
                width: auto;
                max-width: min(520px, 92vw);
                display: block;
            }
            .guest-card {
                width: 100%;
                max-width: 460px;
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                box-shadow: 0 12px 24px rgba(17, 24, 39, 0.12);
                padding: 26px 24px;
            }
            .guest-card > * + * {
                margin-top: 14px;
            }
            .guest-card :is(p, div, label, span, a) {
                font-size: 14px;
                line-height: 1.5;
            }
            .guest-card form > * + * {
                margin-top: 14px;
            }
            .guest-card label {
                display: block;
                margin-bottom: 6px;
                color: #374151;
                font-weight: 600;
            }
            .guest-card input[type="email"],
            .guest-card input[type="password"],
            .guest-card input[type="text"] {
                width: 100%;
                box-sizing: border-box;
                display: block;
                padding: 12px 14px;
                border: 1px solid #d1d5db;
                border-radius: 12px;
                background: #ffffff;
                color: #111827;
            }
            .guest-card input:focus {
                outline: none;
                border-color: #dc2626;
                box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.22);
            }
            .guest-title {
                margin: 0;
                font-size: 22px;
                line-height: 1.2;
                font-weight: 800;
                color: #111827;
                text-align: center;
            }
            .guest-subtitle {
                margin: 8px 0 0 0;
                color: #6b7280;
                text-align: center;
                font-size: 13px;
                line-height: 1.5;
            }
            .guest-btn {
                width: 100%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 12px 16px;
                border-radius: 9999px;
                border: 1px solid transparent;
                cursor: pointer;
                font-weight: 700;
                background: #dc2626;
                color: #ffffff;
            }
            .guest-btn:hover {
                background: #b91c1c;
            }
            .guest-btn:focus {
                outline: none;
                box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.22);
            }
            .guest-divider {
                margin: 14px 0 0 0;
                border-top: 1px solid #e5e7eb;
            }
            .guest-footer {
                margin: 12px 0 0 0;
                text-align: center;
                color: #6b7280;
                font-size: 13px;
                line-height: 1.5;
            }
            .guest-link {
                color: #dc2626;
                text-decoration: none;
                font-weight: 700;
            }
            .guest-link:hover {
                text-decoration: underline;
            }
            .guest-card ul {
                margin: 10px 0 0 0;
                padding-left: 18px;
            }
            .guest-card li {
                margin: 4px 0;
            }
            @media (max-width: 480px) {
                .guest-card {
                    padding: 18px 16px;
                    border-radius: 14px;
                }
                .guest-logo {
                    height: 56px;
                }
            }
        </style>

    </head>
    <body class="guest-body">
        <div class="guest-page">
            <div class="guest-logo-wrap">
                <a href="/" class="guest-logo-link">
                    <img src="{{ asset('images/hastana_logo.png') }}" alt="HASTANA Indonesia" class="guest-logo">
                </a>
            </div>

            <div class="guest-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
