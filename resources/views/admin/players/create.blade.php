<?php
// resources/views/admin/players/create.blade.php
?>
@extends('layouts.admin')

@section('title','Create Player')

@php
    $breadcrumbs = [
        ['route' => 'admin.players.index', 'label' => 'Players'],
        ['label' => 'Create Player'],
    ];
@endphp

@section('admin-content')

    <div class="mb-10">

        <h1 class="text-4xl font-bold text-white">
            Create Player
        </h1>

        <p class="mt-2 text-slate-500">
            Register a new ISA investigator account.
        </p>

    </div>

    <form
        method="POST"
        action="{{ route('admin.players.store') }}"
        class="executive-card p-8">

        @csrf

        <div class="grid gap-6 md:grid-cols-2">

            <div>
                <label for="account_code" class="mb-2 block text-sm font-semibold text-slate-300">
                    Account Code
                </label>
                <input
                    id="account_code"
                    name="account_code"
                    type="text"
                    value="{{ old('account_code', $suggestedAccountCode) }}"
                    placeholder="ISA-INVS-001"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
                <p class="mt-2 text-xs text-slate-500">
                    Auto-generated. You may edit it before saving.
                </p>
            </div>

            <div>
                <label for="rank" class="mb-2 block text-sm font-semibold text-slate-300">
                    Rank
                </label>
                <input
                    id="rank"
                    name="rank"
                    type="text"
                    value="{{ old('rank') }}"
                    placeholder="Detective"
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
                    value="{{ old('level') }}"
                    placeholder="1"
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
                    value="{{ old('xp') }}"
                    placeholder="0"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-300">
                    Password
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Create a secure password"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white focus:border-amber-500 focus:outline-none">
            </div>

        </div>

        <div class="mt-10 flex items-center justify-end gap-4 border-t border-slate-800 pt-8">

            <a
                href="{{ route('admin.players.index') }}"
                class="rounded-lg border border-slate-700 bg-slate-900 px-8 py-3 font-semibold text-white hover:border-slate-500">

                Cancel

            </a>

            <button
                type="submit"
                class="rounded-lg bg-amber-600 px-8 py-3 font-semibold text-white hover:bg-amber-500">

                Create Player

            </button>

        </div>

    </form>

@endsection