@if(isset($items) && count($items))

<nav class="mb-6">

    <ol class="flex items-center gap-2 text-sm text-slate-400">

        @foreach($items as $item)

            @if(!$loop->first)

                <span class="text-slate-600">

                    /

                </span>

            @endif

            @if(isset($item['url']))

                <a
                    href="{{ $item['url'] }}"
                    class="hover:text-white transition">

                    {{ $item['title'] }}

                </a>

            @else

                <span class="text-white">

                    {{ $item['title'] }}

                </span>

            @endif

        @endforeach

    </ol>

</nav>

@endif