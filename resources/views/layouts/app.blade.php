<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">

        <!-- ナビゲーション -->
        @include('layouts.navigation')

        <!-- ページヘッダー -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

    
<!-- フラッシュメッセージ -->
@if(session('status') || session('success') || session('error'))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-2" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-2" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif

        <!-- メインコンテンツ -->
        <main class="flex-1 max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 w-full">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
