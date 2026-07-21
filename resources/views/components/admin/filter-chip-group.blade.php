@props([
    'title',
    'items' => collect(),
    'empty' => 'No items available.',
])

<div class="admin-chip-group">
    <div class="admin-chip-group__title">{{ $title }}</div>

    <div class="admin-chip-group__items">
        @forelse($items as $item)
            <span class="admin-chip">
                {{ $item }}
            </span>
        @empty
            <span class="admin-chip-group__empty">
                {{ $empty }}
            </span>
        @endforelse
    </div>
</div>