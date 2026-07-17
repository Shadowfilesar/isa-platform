<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ISA Dashboard')</title>

    @php
        $workspaceMode = trim((string) $__env->yieldContent('workspace_mode'));
        $isInvestigationWorkspace = $workspaceMode === 'investigation';
    @endphp
    
    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
])

@if($isInvestigationWorkspace)
    @vite('resources/css/board.css')
@endif
</head>
<body class="@yield('body_class')">
    

    @if($isInvestigationWorkspace)
        <div class="app-shell app-shell--investigation">
            <main class="app-content app-content--investigation">
                @yield('content')
            </main>
        </div>
    @else
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
    @endif

    @stack('scripts')
</body>
</html>