<?php
// resources/views/admin/mission-codes/index.blade.php
?>
@extends('layouts.admin')

@section('title','Mission Codes')

@php
    $breadcrumbs = [
        ['label' => 'Mission Codes'],
    ];
@endphp

@section('admin-content')

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold text-white">

                Mission Codes

            </h1>

            <p class="text-slate-400 mt-2">

                One-time investigation access codes

            </p>

        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <form
            method="POST"
            action="{{ route('admin.mission-codes.store') }}"
            class="executive-card p-6 space-y-5">

            @csrf

            <h2 class="text-xl font-bold text-white">

                Generate One

            </h2>

            <select
                name="case_id"
                class="isa-input">

                @foreach($cases as $case)

                    <option value="{{ $case->id }}">

                        {{ $case->code }} - {{ $case->title }}

                    </option>

                @endforeach

            </select>

            <input
                type="hidden"
                name="quantity"
                value="1">

            <button
                type="submit"
                class="isa-button">

                Generate One

            </button>

        </form>

        <form
            method="POST"
            action="{{ route('admin.mission-codes.store') }}"
            class="executive-card p-6 space-y-5">

            @csrf

            <h2 class="text-xl font-bold text-white">

                Bulk Generate

            </h2>

            <select
                name="case_id"
                class="isa-input">

                @foreach($cases as $case)

                    <option value="{{ $case->id }}">

                        {{ $case->code }} - {{ $case->title }}

                    </option>

                @endforeach

            </select>

            <input
                type="number"
                name="quantity"
                min="1"
                value="10"
                class="isa-input">

            <button
                type="submit"
                class="isa-button">

                Bulk Generate

            </button>

        </form>

        <form
            method="GET"
            action="{{ route('admin.mission-codes.index') }}"
            class="executive-card p-6 space-y-5">

            <h2 class="text-xl font-bold text-white">

                Search & Filters

            </h2>

            <input
                name="search"
                value="{{ $filters['search'] }}"
                placeholder="ISA-X7PD-8LQA"
                class="isa-input">

            <select
                name="status"
                class="isa-input">

                <option
                    value="all"
                    @selected($filters['status'] === 'all')>

                    All

                </option>

                <option
                    value="used"
                    @selected($filters['status'] === 'used')>

                    Used

                </option>

                <option
                    value="unused"
                    @selected($filters['status'] === 'unused')>

                    Unused

                </option>

            </select>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="rounded bg-amber-600 px-5 py-3 text-white">

                    Apply

                </button>

                <a
                    href="{{ route('admin.mission-codes.export',$filters) }}"
                    class="rounded bg-slate-800 px-5 py-3 text-white">

                    Export CSV

                </a>

            </div>

        </form>

    </div>

    <div class="executive-card overflow-hidden rounded-xl">

        <table class="w-full">

            <thead class="bg-slate-900">

                <tr>

                    <th class="text-left p-4">Activation Code</th>
                    <th class="text-left p-4">Case</th>
                    <th class="text-left p-4">Status</th>
                    <th class="text-left p-4">Used By</th>
                    <th class="text-left p-4">Activated At</th>
                    <th class="text-right p-4">Actions</th>

                </tr>

            </thead>

            <tbody>

            @forelse($missionCodes as $missionCode)

                <tr class="border-t border-slate-800">

                    <td class="p-4 font-semibold text-white">

                        {{ $missionCode->activation_code }}

                    </td>

                    <td class="p-4">

                        <div class="text-white">

                            {{ $missionCode->investigationCase?->code }}

                        </div>

                        <div class="text-sm text-slate-500">

                            {{ $missionCode->investigationCase?->title }}

                        </div>

                    </td>

                    <td class="p-4">

                        @if($missionCode->used)

                            <span class="text-red-400">

                                Used

                            </span>

                        @else

                            <span class="text-green-400">

                                Unused

                            </span>

                        @endif

                    </td>

                    <td class="p-4">

                        {{ $missionCode->player?->account_code ?? '-' }}

                    </td>

                    <td class="p-4">

                        {{ optional($missionCode->activated_at)->format('Y-m-d H:i') ?? '-' }}

                    </td>

                    <td class="p-4">

                        <div class="flex justify-end">

                            @if(! $missionCode->used)

                                <form
                                    method="POST"
                                    action="{{ route('admin.mission-codes.destroy',$missionCode) }}"
                                    onsubmit="return confirm('Delete this unused mission code?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded bg-red-700 px-4 py-2 text-white">

                                        Delete

                                    </button>

                                </form>

                            @else

                                <span class="text-slate-500">

                                    Locked

                                </span>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-10 text-slate-500">

                        No mission codes found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-8">

        {{ $missionCodes->links() }}

    </div>

@endsection