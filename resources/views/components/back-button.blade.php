@if(url()->previous() !== url()->current())

<div class="mb-6">

    <a
        href="{{ url()->previous() }}"
        class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-5 py-3 text-white transition hover:bg-slate-700">

        ← Back

    </a>

</div>

@endif