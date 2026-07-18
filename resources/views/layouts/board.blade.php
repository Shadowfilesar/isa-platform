<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Investigation Board')</title>
    @vite(['resources/css/app.css', 'resources/css/board.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="investigation-mode">
    <div class="app-shell app-shell--investigation">
        <main class="app-content app-content--investigation">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>