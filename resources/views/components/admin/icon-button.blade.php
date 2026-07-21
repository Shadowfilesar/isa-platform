@props([
    'label',
    'icon' => '•',
    'variant' => 'neutral',
    'href' => null,
])

@php
    $classes = 'admin-icon-button admin-icon-button--' . $variant;
@endphp

@if($href)
    <a
        href="{{ $href }}"
        title="{{ $label }}"
        aria-label="{{ $label }}"
        {{ $attributes->merge(['class' => $classes]) }}>
        <span class="admin-icon-button__icon">{{ $icon }}</span>
        <span class="admin-icon-button__label">{{ $label }}</span>
    </a>
@else
    <button
        type="{{ $attributes->get('type', 'button') }}"
        title="{{ $label }}"
        aria-label="{{ $label }}"
        {{ $attributes->merge(['class' => $classes]) }}>
        <span class="admin-icon-button__icon">{{ $icon }}</span>
        <span class="admin-icon-button__label">{{ $label }}</span>
    </button>
@endif