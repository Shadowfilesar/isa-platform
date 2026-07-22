<aside class="w-72 min-h-screen bg-[#0E1525] border-r border-slate-800">

    <div class="px-8 py-8 border-b border-slate-800">

        <h1 class="text-2xl font-bold tracking-[6px] text-white">
            ISA
        </h1>

        <p class="mt-2 text-xs tracking-[4px] uppercase text-[#C8A878]">
            Intelligence Security Agency
        </p>

    </div>

    <nav class="p-6 space-y-2">

        <a href="{{ route('dashboard') }}"
           class="block rounded-lg px-4 py-3 text-slate-300 hover:bg-slate-800">
            Dashboard
        </a>

        <a href="{{ route('profile') }}"
           class="block rounded-lg px-4 py-3 text-slate-300 hover:bg-slate-800">
            Profile
        </a>

        <a href="{{ route('cases.index') }}"
           class="block rounded-lg px-4 py-3 text-slate-300 hover:bg-slate-800">
            Cases
        </a>
        
        <a href="{{ route('messages.index') }}"
           class="block rounded-lg px-4 py-3 text-slate-300 hover:bg-slate-800">
            Messages
        </a>

    </nav>

</aside>