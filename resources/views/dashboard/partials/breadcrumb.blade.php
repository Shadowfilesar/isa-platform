<div class="border-b border-slate-800 bg-[#111827]">

    <div class="flex items-center justify-between px-8 py-4">

        <nav class="flex items-center gap-3 text-sm">

            <a
                href="{{ route('dashboard') }}"
                class="text-slate-500 transition hover:text-white">

                Dashboard

            </a>

            <span class="text-slate-700">

                /

            </span>

            <span class="font-medium text-white">

                @yield('breadcrumb','Dashboard')

            </span>

        </nav>

        @hasSection('back-button')

            <a
                href="@yield('back-button')"
                class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-white transition hover:bg-slate-700">

                ← Back

            </a>

        @endif

    </div>

</div>