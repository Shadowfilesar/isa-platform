@props([
    'title',
    'subtitle' => null,
])

<div class="admin-toolbar">
    <div class="admin-toolbar__content">
        <h1 class="admin-toolbar__title">{{ $title }}</h1>

        @if($subtitle)
            <p class="admin-toolbar__subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    @if(isset($actions) && trim($actions) !== '')
        <div class="admin-toolbar__actions">
            {{ $actions }}
        </div>
    @endif
</div>