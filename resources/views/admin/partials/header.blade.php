{{-- resources/views/admin/partials/header.blade.php --}}
<header class="sticky top-0 z-40 h-16 border-b border-slate-800 bg-isa-navy/95 backdrop-blur">

    <div class="flex h-16 items-center justify-between px-6 lg:px-10">

        <div class="flex items-center gap-4">

            <button
                type="button"
                onclick="document.getElementById('admin-sidebar').classList.toggle('-translate-x-full');"
                class="rounded-lg border border-slate-700 p-2 text-white lg:hidden">

                <i class="fa-solid fa-bars"></i>

            </button>

            <span class="font-serif text-lg font-bold tracking-wide text-amber-400">

                ISA Administration

            </span>

        </div>

        <div class="flex items-center gap-4">

            @auth('admin')

                <span class="hidden text-sm text-slate-400 sm:inline">

                    {{ Auth::guard('admin')->user()->email }}

                </span>

                <form method="POST" action="{{ route('admin.logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-sm text-white hover:border-amber-500">

                        Logout

                    </button>

                </form>

            @endauth

        </div>

    </div>

</header>