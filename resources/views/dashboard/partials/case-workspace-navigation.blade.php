<div class="{{ $containerClass }}">
    @foreach($navSections as $navSection)
        @php
            if ($navSection === 'Board') {
                $navUrl = route('investigation-board.show', $case);
            } elseif ($navSection === 'Overview') {
                $navUrl = route('cases.show', $case);
            } else {
                $navUrl = route('cases.show', [
                    'case' => $case,
                    'section' => $navSection,
                ]);
            }

            $isActive = $section === $navSection;
        @endphp

        <a href="{{ $navUrl }}"
           class="{{ $isActive ? $activeClass : $inactiveClass }} {{ $linkClass }}">
            {{ $navSection }}
        </a>
    @endforeach
</div>