@props([
    'action',
    'name' => 'search',
    'value' => '',
    'placeholder' => 'Search...',
])

<form method="GET" action="{{ $action }}" class="admin-search">
    <div class="admin-search__input-wrap">
        <span class="admin-search__icon">⌕</span>
        <input
            type="text"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            class="admin-search__input">
    </div>

    <button type="submit" class="admin-search__button">
        Search
    </button>
</form>