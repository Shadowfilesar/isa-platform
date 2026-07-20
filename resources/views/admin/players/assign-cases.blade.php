<?php
// resources/views/admin/players/assign-cases.blade.php
?>
@extends('layouts.admin')

@section('title','Assign Cases')

@php
    $breadcrumbs = [
        ['route' => 'admin.players.index', 'label' => 'Players'],
        ['route' => 'admin.players.edit', 'params' => $player, 'label' => $player->account_code],
        ['label' => 'Assign Cases'],
    ];
@endphp

@section('admin-content')

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
                        {{ in_array($case->id, $assignedCases) ? 'checked' : '' }}>

                </label>

            @empty

                <div class="py-10 text-center text-slate-500">

                    No cases available.

                </div>

            @endforelse

        </div>

        <div class="mt-10 flex items-center justify-end gap-4 border-t border-slate-800 pt-8">

            
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

@endsection