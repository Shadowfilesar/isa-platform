@extends('layouts.admin')

@section('title','ISA Administration')

@section('content')

<div class="space-y-8">

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-4xl font-bold text-white">

                ISA Administration

            </h1>

            <p class="mt-3 text-slate-500">

                Intelligence Operations Control Center

            </p>

        </div>

        <div class="flex flex-wrap gap-3">

            <a
                href="{{ route('admin.players.create') }}"
                class="rounded-lg bg-emerald-700 px-6 py-3 font-semibold text-white hover:bg-emerald-600">

                + New Player

            </a>

            <a
                href="{{ route('admin.cases.create') }}"
                class="rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white hover:bg-amber-500">

                + New Case

            </a>

            <a
                href="{{ route('admin.mission-codes.index') }}"
                class="rounded-lg bg-slate-700 px-6 py-3 font-semibold text-white hover:bg-slate-600">

                Mission Codes

            </a>

            <a
                href="{{ route('admin.messages.create') }}"
                class="rounded-lg bg-blue-700 px-6 py-3 font-semibold text-white hover:bg-blue-600">

                Director Message

            </a>

        </div>

    </div>

    <div class="grid gap-6 lg:grid-cols-5">

        <div class="card p-6">

            <p class="text-sm text-slate-400">

                Total Players

            </p>

            <div class="mt-4 text-4xl font-bold text-white">

                {{ $totalPlayers ?? 0 }}

            </div>

        </div>

        <div class="card p-6">

            <p class="text-sm text-slate-400">

                Total Cases

            </p>

            <div class="mt-4 text-4xl font-bold text-white">

                {{ $totalCases }}

            </div>

        </div>

        <div class="card p-6">

            <p class="text-sm text-slate-400">

                Mission Codes

            </p>

            <div class="mt-4 text-4xl font-bold text-white">

                {{ $totalMissionCodes }}

            </div>

        </div>

        <div class="card p-6">

            <p class="text-sm text-slate-400">

                Used Codes

            </p>

            <div class="mt-4 text-4xl font-bold text-red-400">

                {{ $usedMissionCodes }}

            </div>

        </div>

        <div class="card p-6">

            <p class="text-sm text-slate-400">

                Available Codes

            </p>

            <div class="mt-4 text-4xl font-bold text-green-400">

                {{ $unusedMissionCodes }}

            </div>

        </div>

    </div>
        <div class="grid gap-8 xl:grid-cols-3">

        <div class="card xl:col-span-2 overflow-hidden">

            <div class="flex items-center justify-between border-b border-slate-800 p-6">

                <div>

                    <h2 class="text-2xl font-bold text-white">

                        Recent Investigations

                    </h2>

                    <p class="mt-2 text-sm text-slate-500">

                        Latest investigation files created in ISA.

                    </p>

                </div>

                <a
                    href="{{ route('admin.cases.index') }}"
                    class="rounded-lg bg-slate-800 px-5 py-2 text-white hover:bg-slate-700">

                    View All

                </a>

            </div>

            <table class="w-full">

                <thead class="bg-slate-900">

                    <tr>

                        <th class="p-4 text-left">

                            Code

                        </th>

                        <th class="p-4 text-left">

                            Investigation

                        </th>

                        <th class="p-4 text-left">

                            Difficulty

                        </th>

                        <th class="p-4 text-left">

                            Status

                        </th>

                        <th class="p-4 text-right">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($recentCases as $case)

                    <tr class="border-t border-slate-800 hover:bg-slate-900/40">

                        <td class="p-4 font-semibold text-white">

                            {{ $case->code }}

                        </td>

                        <td class="p-4">

                            <div class="font-semibold text-white">

                                {{ $case->title }}

                            </div>

                        </td>

                        <td class="p-4">

                            <span class="rounded-full bg-slate-800 px-3 py-1 text-sm">

                                {{ $case->difficulty }}

                            </span>

                        </td>

                        <td class="p-4">

                            @if($case->published)

                                <span class="rounded-full bg-green-900 px-3 py-1 text-green-300">

                                    Published

                                </span>

                            @else

                                <span class="rounded-full bg-yellow-900 px-3 py-1 text-yellow-300">

                                    Draft

                                </span>

                            @endif

                        </td>

                        <td class="p-4">

                            <div class="flex justify-end gap-2">

                                <a
                                    href="{{ route('admin.case-files.index',$case) }}"
                                    class="rounded-lg bg-slate-800 px-4 py-2 text-white hover:bg-slate-700">

                                    Files

                                </a>

                                <a
                                    href="{{ route('admin.cases.edit',$case) }}"
                                    class="rounded-lg bg-amber-600 px-4 py-2 text-white hover:bg-amber-500">

                                    Edit

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="py-16 text-center text-slate-500">

                            No investigations available.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="space-y-6">

            <div class="card p-6">

                <h2 class="mb-6 text-xl font-bold text-white">

                    Quick Actions

                </h2>
                                <div class="space-y-3">

                    <a
                        href="{{ route('admin.players.index') }}"
                        class="block rounded-lg bg-emerald-700 px-5 py-4 text-center font-semibold text-white transition hover:bg-emerald-600">

                        👥 Manage Players

                    </a>

                    <a
                        href="{{ route('admin.cases.index') }}"
                        class="block rounded-lg bg-amber-600 px-5 py-4 text-center font-semibold text-white transition hover:bg-amber-500">

                        📂 Manage Cases

                    </a>

                    <a
                        href="{{ route('admin.mission-codes.index') }}"
                        class="block rounded-lg bg-slate-800 px-5 py-4 text-center font-semibold text-white transition hover:bg-slate-700">

                        🔑 Mission Codes

                    </a>

                    <a
                        href="{{ route('admin.messages.create') }}"
                        class="block rounded-lg bg-blue-700 px-5 py-4 text-center font-semibold text-white transition hover:bg-blue-600">

                        📨 Director Messages

                    </a>

                </div>

            </div>

            <div class="card p-6">

                <h2 class="mb-6 text-xl font-bold text-white">

                    System Overview

                </h2>

                <div class="space-y-5">

                    <div class="flex items-center justify-between">

                        <span class="text-slate-400">

                            Players

                        </span>

                        <span class="font-bold text-white">

                            {{ $totalPlayers ?? 0 }}

                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <span class="text-slate-400">

                            Cases

                        </span>

                        <span class="font-bold text-white">

                            {{ $totalCases }}

                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <span class="text-slate-400">

                            Mission Codes

                        </span>

                        <span class="font-bold text-white">

                            {{ $totalMissionCodes }}

                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <span class="text-slate-400">

                            Used Codes

                        </span>

                        <span class="font-bold text-red-400">

                            {{ $usedMissionCodes }}

                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <span class="text-slate-400">

                            Available Codes

                        </span>

                        <span class="font-bold text-green-400">

                            {{ $unusedMissionCodes }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection