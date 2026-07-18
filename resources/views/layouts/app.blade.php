<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ISA Dashboard')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    @stack('styles')
</head>

<body class="@yield('body_class')">

    <div class="app-shell">

        @include('dashboard.partials.sidebar')

        <div class="app-main">

            @include('dashboard.partials.header')

            @include('dashboard.partials.breadcrumb')

            <main class="app-content">

                @yield('content')

            </main>

        </div>

    </div>

    @stack('scripts')

</body>

</html>