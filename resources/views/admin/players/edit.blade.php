<?php
// resources/views/admin/players/edit.blade.php
?>
@extends('layouts.app')

@section('title','Edit Player')

@section('content')

<div class="p-10">

    <div class="mb-8">

        
            href="{{ route('admin.players.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white hover:border-amber-500">

            ← Back to Players

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
                Edit Player
            </span>

        </div>

    </div>

    <div class="mb-10">

        <h1 class="text-4xl font-bold text-white">
            Edit Player
        </h1>

        <p class="mt-2 text-slate-500">
            Investigator:
            <span class="text-white">
                {{ $player->account_code }}
            </span>
        </p>

    </div>

    @if ($errors->any())

        <div class="mb-8 rounded-lg border border-red-700 bg-red-900/40 px-5 py-4 text-red-300">

            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <form
        method="POST"
        action="{{ route('admin.players.update', $player) }}"
        class="executive-card p-8">

        @csrf
        @method('PUT')

        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <label for="account_code" class="mb-2 block text-sm font-semibold text-slate-300">
                    Account Code
                </label>
                <input
                    id="account_code"
                    name="account_code"
                    type="text"
                    value="{{ old('account_code', $player->account_code) }}"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
            </div>

            <div>
                <label for="rank" class="mb-2 block text-sm font-semibold text-slate-300">
                    Rank
                </label>
                <input
                    id="rank"
                    name="rank"
                    type="text"
                    value="{{ old('rank', $player->rank) }}"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
            </div>

            <div>
                <label for="level" class="mb-2 block text-sm font-semibold text-slate-300">
                    Level
                </label>
                <input
                    id="level"
                    name="level"
                    type="number"
                    value="{{ old('level', $player->level) }}"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
            </div>

            <div>
                <label for="xp" class="mb-2 block text-sm font-semibold text-slate-300">
                    XP
                </label>
                <input
                    id="xp"
                    name="xp"
                    type="number"
                    value="{{ old('xp', $player->xp) }}"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
            </div>

            <div class="md:col-span-2">
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-300">
                    Password
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Leave blank to keep current password"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
            </div>

        </div>

        <div class="mt-10 flex flex-wrap items-center justify-end gap-4 border-t border-slate-800 pt-8">

            
                href="{{ route('admin.players.assign-cases', $player) }}"
                class="rounded-lg border border-slate-700 bg-slate-900 px-8 py-3 font-semibold text-white hover:border-amber-500">

                Manage Assigned Cases

            </a>

            
                href="{{ route('admin.players.index') }}"
                class="rounded-lg border border-slate-700 bg-slate-900 px-8 py-3 font-semibold text-white hover:border-slate-500">

                Cancel

            </a>

            <button
                type="submit"
                class="rounded-lg bg-amber-600 px-8 py-3 font-semibold text-white hover:bg-amber-500">

                Save Player

            </button>

        </div>

    </form>

</div>

@endsection