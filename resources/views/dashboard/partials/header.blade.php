<header class="border-b border-slate-800 bg-[#111827]">

    <div class="flex items-center justify-between px-8 py-6">

        <div>

            <h2 class="text-2xl font-semibold text-white">

                Intelligence Security Agency

            </h2>

            <p class="mt-1 text-sm text-slate-400">

                Tactical Operations Center

            </p>

        </div>

        <div class="flex items-center gap-8">

            <div class="text-right">

                <div class="text-xs uppercase tracking-widest text-slate-500">

                    Rank

                </div>

                <div class="text-[#C8A878]">

                    {{ $player->rank }}

                </div>

            </div>

            <div class="text-right">

                <div class="text-xs uppercase tracking-widest text-slate-500">

                    Level

                </div>

                <div class="text-white">

                    {{ $player->level }}

                </div>

            </div>

            <div class="text-right">

                <div class="text-xs uppercase tracking-widest text-slate-500">

                    XP

                </div>

                <div class="text-white">

                    {{ $player->xp }}

                </div>

            </div>

            <form
                method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="rounded-lg bg-red-700 px-5 py-2 text-white hover:bg-red-600">

                    Logout

                </button>

            </form>

        </div>

    </div>

</header>