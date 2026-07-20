{{-- resources/views/admin/partials/sidebar.blade.php --}}
<aside
    id="admin-sidebar"
    class="fixed inset-y-0 left-0 z-30 flex w-64 -translate-x-full transform flex-col border-r border-slate-800 bg-isa-navy transition-transform duration-200 ease-in-out lg:sticky lg:top-16 lg:z-0 lg:h-[calc(100vh-4rem)] lg:w-64 lg:translate-x-0">

    <nav class="flex-1 space-y-2 px-4 py-6">

        
            href="{{ route('admin.dashboard') }}"
            class="block rounded-lg px-4 py-3 font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-amber-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

            Dashboard

        </a>

        
            href="{{ route('admin.players.index') }}"
            class="block rounded-lg px-4 py-3 font-semibold {{ request()->routeIs('admin.players.*') ? 'bg-amber-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

            Players

        </a>

        
            href="{{ route('admin.cases.index') }}"
            class="block rounded-lg px-4 py-3 font-semibold {{ request()->routeIs('admin.cases.*') || request()->routeIs('admin.case-files.*') ? 'bg-amber-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

            Cases

        </a>

        
            href="{{ route('admin.mission-codes.index') }}"
            class="block rounded-lg px-4 py-3 font-semibold {{ request()->routeIs('admin.mission-codes.*') ? 'bg-amber-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

            Mission Codes

        </a>

    </nav>

</aside>