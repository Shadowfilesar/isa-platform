@extends('layouts.app')

@section('title','Profile')

@section('page-title','Profile')

@section('page-description','Investigator Profile')

@section('breadcrumb','Profile')

@section('content')

<div class="min-h-screen flex">

    @include('dashboard.partials.sidebar')

    <div class="flex-1">

        @include('dashboard.partials.header')

        @include('dashboard.partials.breadcrumb')

        @include('dashboard.partials.alerts')

        <main class="p-8 space-y-8">

            <div class="executive-card p-8">

                <div class="flex items-center justify-between">

                    <div>

                        <h1 class="text-4xl font-bold text-white">

                            Investigator Profile

                        </h1>

                        <p class="mt-3 text-slate-400">

                            Intelligence Security Agency Personnel Record.

                        </p>

                    </div>

                    <div class="text-right">

                        <div class="text-sm uppercase tracking-[4px] text-amber-500">

                            {{ $player->rank }}

                        </div>

                        <div class="mt-2 text-5xl font-bold text-white">

                            Level {{ $player->level }}

                        </div>

                    </div>

                </div>

            </div>

            <div class="grid gap-6 md:grid-cols-2">

                <div class="executive-card p-6">

                    <div class="text-slate-500">

                        Account Code

                    </div>

                    <div class="mt-3 text-2xl font-bold text-white">

                        {{ $player->account_code }}

                    </div>

                </div>

                <div class="executive-card p-6">

                    <div class="text-slate-500">

                        Rank

                    </div>

                    <div class="mt-3 text-2xl font-bold text-amber-400">

                        {{ $player->rank }}

                    </div>

                </div>

                <div class="executive-card p-6">

                    <div class="text-slate-500">

                        Level

                    </div>

                    <div class="mt-3 text-2xl font-bold text-white">

                        {{ $player->level }}

                    </div>

                </div>

                <div class="executive-card p-6">

                    <div class="text-slate-500">

                        XP

                    </div>

                    <div class="mt-3 text-2xl font-bold text-green-400">

                        {{ number_format($player->xp) }}

                    </div>

                </div>
                                <div class="executive-card p-6 md:col-span-2">

                    <div class="flex items-center justify-between mb-6">

                        <h2 class="text-2xl font-bold text-white">

                            Agent Progress

                        </h2>

                        <span class="text-slate-500">

                            Career Progress

                        </span>

                    </div>

                    <div class="mb-3 flex justify-between text-sm">

                        <span class="text-slate-400">

                            {{ number_format($player->xp) }} XP

                        </span>

                        <span class="text-slate-400">

                            Next Level

                        </span>

                    </div>

                    <div class="h-3 overflow-hidden rounded-full bg-slate-800">

                        <div
                            class="h-3 rounded-full bg-amber-600"
                            style="width: {{ min(($player->xp % 1000) / 10,100) }}%;">

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

@endsection