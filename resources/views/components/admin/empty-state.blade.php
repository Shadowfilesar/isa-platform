@props([
    'title',
    'message',
])

<div class="admin-empty-state">
    <div class="admin-empty-state__icon">⊘</div>
    <h3 class="admin-empty-state__title">{{ $title }}</h3>
    <p class="admin-empty-state__message">{{ $message }}</p>

    @if(trim($slot) !== '')
        <div class="admin-empty-state__actions">
            {{ $slot }}
        </div>
    @endif
</div>