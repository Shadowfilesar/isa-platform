<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ISA Admin')</title>

    @vite([
        'resources/css/app.css',
        'resources/css/admin.css',
        'resources/js/app.js',
    ])

    @stack('styles')
</head>

<body>

<div class="flex min-h-screen">

    <aside class="admin-sidebar">

        <div class="p-7">
            <h1 class="text-3xl font-bold text-amber-400">
                ISA
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Administration Panel
            </p>
        </div>

        <nav class="space-y-2 px-4">

            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.players.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.players.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users w-5"></i>
                Players
            </a>

            <a href="{{ route('admin.cases.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.cases.*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-open w-5"></i>
                Cases
            </a>

            <a href="{{ route('admin.mission-codes.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.mission-codes.*') ? 'active' : '' }}">
                <i class="fa-solid fa-key w-5"></i>
                Mission Codes
            </a>

            <a href="{{ route('admin.messages.create') }}"
               class="admin-nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope w-5"></i>
                Director Messages
            </a>

            <a href="{{ route('admin.notifications.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bell w-5"></i>
                Notifications
            </a>

            <a href="{{ route('admin.activity-logs.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line w-5"></i>
                Activity Logs
            </a>

            <a href="{{ route('admin.reports.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines w-5"></i>
                Reports
            </a>

            <a href="{{ route('admin.settings.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear w-5"></i>
                Settings
            </a>

        </nav>

        <div class="mt-8 border-t border-slate-800 p-4">

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf

                <button type="submit"
                        class="admin-nav-link w-full">

                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    Logout

                </button>
            </form>

        </div>

    </aside>

    <div class="flex flex-1 flex-col">

        <header class="admin-header">

            <div class="flex w-full items-center justify-between px-8">

                <div>
                    <h2 class="text-3xl font-bold text-white">
                        @yield('title')
                    </h2>
                </div>

                <div>
                    <span class="rounded-full bg-slate-800 px-5 py-2 text-sm text-slate-300">
                        Administrator
                    </span>
                </div>

            </div>

        </header>

        <main class="flex-1 p-8">

            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-700 bg-green-900/20 px-6 py-4 text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-xl border border-red-700 bg-red-900/20 px-6 py-4 text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-700 bg-red-900/20 px-6 py-4">
                    <ul class="list-disc space-y-2 pl-6 text-red-300">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>

        <footer class="border-t border-slate-800 px-8 py-5">
            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-500">
                    ISA Administration System
                </span>

                <span class="text-sm text-slate-600">
                    Version 1.0
                </span>
            </div>
        </footer>

    </div>

</div>

@stack('scripts')

</body>
</html>