@props([
    'items' => [],
])

<div class="admin-meta-list">
    @foreach($items as $item)
        @if(filled($item['value'] ?? null))
            <div class="admin-meta-list__item">
                <span class="admin-meta-list__label">{{ $item['label'] }}:</span>
                <span class="admin-meta-list__value">{{ $item['value'] }}</span>
            </div>
        @endif
    @endforeach
</div>