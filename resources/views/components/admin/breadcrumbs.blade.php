@props([
    'items' => [],
])

<nav aria-label="Breadcrumb" class="admin-breadcrumbs">
    @foreach($items as $item)
        @php
            $isLast = $loop->last;
            $label = $item['label'] ?? '';
            $href = $item['href'] ?? null;
        @endphp

        <div class="admin-breadcrumbs__item">
            @if($href && ! $isLast)
                <a href="{{ $href }}" class="admin-breadcrumbs__link">
                    {{ $label }}
                </a>
            @else
                <span class="admin-breadcrumbs__current">
                    {{ $label }}
                </span>
            @endif

            @unless($isLast)
                <span class="admin-breadcrumbs__separator">/</span>
            @endunless
        </div>
    @endforeach
</nav>