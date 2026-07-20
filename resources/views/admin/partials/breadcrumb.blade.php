{{-- resources/views/admin/partials/breadcrumb.blade.php --}}
@php
    $crumbs = $breadcrumbs ?? [];
@endphp

<nav class="mb-8 text-sm text-slate-500">

    @if(count($crumbs) === 0)

        <span class="text-amber-400">Dashboard</span>

    @else

        <a href="{{ route('admin.dashboard') }}" class="hover:text-white">Dashboard</a>

        @foreach($crumbs as $index => $crumb)

            <span class="mx-2">/</span>

            @if(!empty($crumb['route']) && $index < count($crumbs) - 1)

                <a href="{{ route($crumb['route'], $crumb['params'] ?? []) }}" class="hover:text-white">
                    {{ $crumb['label'] }}
                </a>

            @else

                <span class="text-amber-400">{{ $crumb['label'] }}</span>

            @endif

        @endforeach

    @endif

</nav>