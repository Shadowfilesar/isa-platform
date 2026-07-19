@extends('layouts.app')

@section('title','Admin')

@section('content')

<div class="p-10">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold text-white">

                ISA Administration

            </h1>

            <p class="text-slate-500 mt-3">

                Control Center

            </p>

        </div>

        <div class="flex gap-3">

            <a
                href="{{ route('admin.cases.create') }}"
                class="rounded bg-amber-600 px-6 py-3 text-white">

                New Case

            </a>

            <a
                href="{{ route('admin.mission-codes.index') }}"
                class="rounded bg-slate-800 px-6 py-3 text-white">

                Mission Codes

            </a>

        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        <div class="executive-card executive-glow p-6">

            <p class="text-slate-500">

                Total Cases

            </p>

            <div class="text-4xl font-bold text-white mt-3">

                {{ $totalCases }}

            </div>

        </div>

        <div class="executive-card executive-glow p-6">

            <p class="text-slate-500">

                Total Mission Codes

            </p>

            <div class="text-4xl font-bold text-white mt-3">

                {{ $totalMissionCodes }}

            </div>

        </div>

        <div class="executive-card executive-glow p-6">

            <p class="text-slate-500">

                Used Mission Codes

            </p>

            <div class="text-4xl font-bold text-red-400 mt-3">

                {{ $usedMissionCodes }}

            </div>

        </div>

        <div class="executive-card executive-glow p-6">

            <p class="text-slate-500">

                Unused Mission Codes

            </p>

            <div class="text-4xl font-bold text-green-400 mt-3">

                {{ $unusedMissionCodes }}

            </div>

        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="executive-card xl:col-span-2 overflow-hidden">

            <div class="p-6 border-b border-slate-800">

                <h2 class="text-2xl font-bold text-white">

                    Recent Cases

                </h2>

            </div>

            <table class="w-full">

                <thead class="bg-slate-900">

                    <tr>

                        <th class="text-left p-4">Code</th>
                        <th class="text-left p-4">Title</th>
                        <th class="text-left p-4">Difficulty</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-right p-4">Actions</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($recentCases as $case)

                    <tr class="border-t border-slate-800">

                        <td class="p-4 text-white">

                            {{ $case->code }}

                        </td>

                        <td class="p-4">

                            {{ $case->title }}

                        </td>

                        <td class="p-4">

                            {{ $case->difficulty }}

                        </td>

                        <td class="p-4">

                            @if($case->published)

                                <span class="text-green-400">

                                    Published

                                </span>

                            @else

                                <span class="text-yellow-400">

                                    Draft

                                </span>

                            @endif

                        </td>

                        <td class="p-4">

                            <div class="flex justify-end gap-3">

                                <a
                                    href="{{ route('admin.case-files.index',$case) }}"
                                    class="rounded bg-slate-800 px-4 py-2 text-white">

                                    Files

                                </a>

                                <a
                                    href="{{ route('admin.cases.edit',$case) }}"
                                    class="rounded bg-amber-600 px-4 py-2 text-white">

                                    Edit

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-10 text-slate-500">

                            No investigations created yet.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="executive-card p-6">

            <h2 class="text-2xl font-bold text-white mb-6">

                Quick Actions

            </h2>

            <div class="space-y-4">

                <a
                    href="{{ route('admin.cases.create') }}"
                    class="block rounded bg-amber-600 px-5 py-4 text-center font-semibold text-white">

                    New Case

                </a>

                <a
                    href="{{ route('admin.mission-codes.index') }}"
                    class="block rounded bg-slate-800 px-5 py-4 text-center font-semibold text-white">

                    Mission Codes

                </a>

            </div>

        </div>

    </div>

</div>

@endsection
