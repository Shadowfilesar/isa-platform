<div class="{{ $containerClass }}">
    @foreach($navSections as $navSection)
        @php
            $isOverview = $navSection === 'Overview';
            $navUrl = $isOverview
                ? route('cases.show', $case)
                : route('cases.show', [$case, 'section' => $navSection]);
            $isActive = $section === $navSection;
        @endphp

        <a href="{{ $navUrl }}"
           class="{{ $isActive ? $activeClass : $inactiveClass }} {{ $linkClass }}">
            {{ $navSection }}
        </a>
    @endforeach
</div>