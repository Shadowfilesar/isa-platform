@extends('layouts.admin')

@section('title','Assign Cases')

@section('content')

<div class="p-10">

    <div class="mb-8">

        <a
            href="{{ route('admin.players.edit',$player) }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white hover:border-amber-500">

            ← Back to Player

        </a>

        <div class="mt-5 text-sm text-slate-500">

            <a href="{{ route('admin.dashboard') }}" class="hover:text-white">

                Dashboard

            </a>

            <span class="mx-2">/</span>

            <a href="{{ route('admin.players.index') }}" class="hover:text-white">

                Players

            </a>

            <span class="mx-2">/</span>

            <span class="text-amber-400">

                Assign Cases

            </span>

        </div>

    </div>

    <div class="mb-10">

        <h1 class="text-4xl font-bold text-white">

            Assign Investigation Cases

        </h1>

        <p class="mt-2 text-slate-500">

            Investigator:

            <span class="text-white">

                {{ $player->account_code }}

            </span>

        </p>

    </div>

    <form
        method="POST"
        action="{{ route('admin.players.assign-cases.save',$player) }}"
        class="executive-card p-8">

        @csrf

        <div class="space-y-4">

            @forelse($cases as $case)

                <label
                    class="flex items-center justify-between rounded-lg border border-slate-700 bg-slate-900 p-5 hover:border-amber-500">

                    <div>

                        <div class="font-semibold text-white">

                            {{ $case->code }}

                        </div>

                        <div class="mt-1 text-slate-400">

                            {{ $case->title }}

                        </div>

                    </div>

                    <input
                        type="checkbox"
                        name="cases[]"
                        value="{{ $case->id }}"
                        {{ $player->cases->contains($case->id) ? 'checked' : '' }}>

                </label>

            @empty

                <div class="py-10 text-center text-slate-500">

                    No cases available.

                </div>

            @endforelse

        </div>
                <div class="border-t border-slate-800 pt-8">

            <h2 class="mb-6 text-xl font-bold text-white">

                Quick Actions

            </h2>

            <div class="grid gap-4 md:grid-cols-3">

                <a
                    href="{{ route('admin.players.index') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white hover:bg-slate-700">

                    👥 All Players

                </a>

                <a
                    href="{{ route('admin.cases.index') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white hover:bg-slate-700">

                    📂 All Cases

                </a>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white hover:bg-slate-700">

                    🏠 Dashboard

                </a>

            </div>

        </div>

        <div class="mt-10 flex items-center justify-end gap-4 border-t border-slate-800 pt-8">

            <a
                href="{{ route('admin.players.edit',$player) }}"
                class="rounded-lg border border-slate-700 bg-slate-900 px-8 py-3 font-semibold text-white hover:border-slate-500">

                Cancel

            </a>

            <button
                type="submit"
                class="rounded-lg bg-amber-600 px-8 py-3 font-semibold text-white hover:bg-amber-500">

                Save Assigned Cases

            </button>

        </div>

    </form>

</div>

@endsection