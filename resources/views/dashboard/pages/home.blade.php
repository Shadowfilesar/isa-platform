@extends('layouts.app')


@section('title','Dashboard')


@section('page-title','Dashboard')


@section('page-description','Intelligence Security Agency')


@section('breadcrumb','Dashboard')


@section('content')



        @include('dashboard.partials.alerts')


        <main class="p-8 space-y-8">


            <!-- Welcome -->


            <div class="executive-card p-8">


                <div class="flex items-center justify-between">


                    <div>


                        <h1 class="text-4xl font-bold text-white">


                            Welcome,
                            {{ $player->account_code }}


                        </h1>


                        <p class="mt-3 text-slate-400">


                            Welcome back to the Intelligence Security Agency.


                        </p>


                    </div>


                    <div class="text-right">


                        <div class="text-sm uppercase tracking-[4px] text-amber-500">


                            {{ $player->rank }}


                        </div>


                        <div class="mt-2 text-5xl font-bold text-white">


                            Lv. {{ $player->level }}


                        </div>


                    </div>


                </div>


            </div>


            <!-- Top Cards -->


            <div class="grid gap-6 lg:grid-cols-2">


                <!-- Continue Investigation -->


                <div class="executive-card p-6">


                    <div class="flex items-center justify-between">


                        <div>


                            <h2 class="text-xl font-semibold text-white">


                                Continue Investigation


                            </h2>


                            <p class="mt-2 text-slate-500">


                                Resume your latest active investigation.


                            </p>


                        </div>


                        <div class="text-4xl">


                            🕵️


                        </div>


                    </div>


                    <div class="mt-6">
                                                @if($activeCases->count())


                            <a
                                href="{{ route('cases.show',$activeCases->first()) }}"
                                class="inline-flex items-center rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white transition hover:bg-amber-500">


                                Continue


                            </a>


                        @else


                            <span class="text-slate-500">


                                No active investigation.


                            </span>


                        @endif


                    </div>


                </div>


                <!-- XP Progress -->


                <div class="executive-card p-6">


                    <div class="flex items-center justify-between">


                        <div>


                            <h2 class="text-xl font-semibold text-white">


                                XP Progress


                            </h2>


                            <p class="mt-2 text-slate-500">


                                Continue solving investigations to earn XP.


                            </p>


                        </div>


                        <div class="text-4xl">


                            ⭐


                        </div>


                    </div>


                    <div class="mt-8">


                        <div class="mb-2 flex justify-between text-sm">


                            <span class="text-slate-400">


                                {{ $player->xp }} XP


                            </span>


                            <span class="text-slate-400">


                                Level {{ $player->level }}


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


            </div>


            <!-- Mission Code -->


            <div class="executive-card p-8">


                <div class="flex items-center justify-between mb-6">


                    <div>


                        <h2 class="text-2xl font-bold text-white">


                            Unlock Investigation


                        </h2>


                        <p class="mt-2 text-slate-500">


                            Enter your mission code to unlock a new investigation.


                        </p>


                    </div>


                    <div class="text-5xl">


                        🔓


                    </div>


                </div>
                                @if(session('success'))


                    <div class="mb-6 rounded-lg bg-green-900/40 border border-green-700 px-5 py-4 text-green-300">


                        {{ session('success') }}


                    </div>


                @endif


                @if($errors->has('code'))


                    <div class="mb-6 rounded-lg bg-red-900/40 border border-red-700 px-5 py-4 text-red-300">


                        {{ $errors->first('code') }}


                    </div>


                @endif


                <form
                    action="{{ route('mission.redeem') }}"
                    method="POST"
                    class="flex gap-4">


                    @csrf


                    <input
                        type="text"
                        name="code"
                        placeholder="Enter Mission Code..."
                        class="flex-1 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white focus:border-amber-500 focus:outline-none">


                    <button
                        type="submit"
                        class="rounded-lg bg-amber-600 px-8 py-3 font-semibold text-white transition hover:bg-amber-500">


                        Unlock


                    </button>


                </form>


            </div>


            <!-- Statistics -->


            <div class="grid gap-6 md:grid-cols-3">


                <div class="executive-card p-6">


                    <div class="text-sm uppercase tracking-widest text-slate-500">


                        Total Cases


                    </div>


                    <div class="mt-4 text-4xl font-bold text-white">


                        {{ $statistics['totalCases'] }}


                    </div>


                </div>


                <div class="executive-card p-6">


                    <div class="text-sm uppercase tracking-widest text-slate-500">


                        Active Cases


                    </div>


                    <div class="mt-4 text-4xl font-bold text-amber-400">


                        {{ $statistics['activeCases'] }}


                    </div>


                </div>


                <div class="executive-card p-6">


                    <div class="text-sm uppercase tracking-widest text-slate-500">


                        Completed Cases


                    </div>


                    <div class="mt-4 text-4xl font-bold text-green-400">


                        {{ $statistics['completedCases'] }}


                    </div>


                </div>


            </div>


            <!-- Latest Activity -->


            <div class="grid gap-6 lg:grid-cols-2">


                <div class="executive-card p-6">


                    <h2 class="mb-4 text-xl font-bold text-white">


                        Latest Notification


                    </h2>


                    <p class="text-slate-400">


                        Coming in Pack 7.2.1


                    </p>


                </div>


                <div class="executive-card p-6">


                    <h2 class="mb-4 text-xl font-bold text-white">


                        Latest Director Message


                    </h2>


                    <p class="text-slate-400">


                        Coming in Pack 7.2.1


                    </p>


                </div>


            </div>
                                <!-- Quick Actions -->


            <div class="executive-card p-8">


                <div class="flex items-center justify-between mb-6">


                    <h2 class="text-2xl font-bold text-white">


                        Quick Actions


                    </h2>


                    <span class="text-slate-500">


                        Frequently Used


                    </span>


                </div>


                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">


                    <a
                        href="{{ route('cases.index') }}"
                        class="rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-amber-500 hover:bg-slate-800">


                        <div class="text-4xl">


                            🗂️


                        </div>


                        <h3 class="mt-4 text-lg font-semibold text-white">


                            Cases


                        </h3>


                        <p class="mt-2 text-sm text-slate-500">


                            Browse all assigned investigations.


                        </p>


                    </a>


                    <a
                        href="{{ route('messages.index') }}"
                        class="rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-amber-500 hover:bg-slate-800">


                        <div class="text-4xl">


                            📬


                        </div>


                        <h3 class="mt-4 text-lg font-semibold text-white">


                            Director Inbox


                        </h3>


                        <p class="mt-2 text-sm text-slate-500">


                            Read secure communications.


                        </p>


                    </a>


                    <a
                        href="{{ route('notifications.index') }}"
                        class="rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-amber-500 hover:bg-slate-800">


                        <div class="text-4xl">


                            🔔


                        </div>


                        <h3 class="mt-4 text-lg font-semibold text-white">


                            Notifications


                        </h3>


                        <p class="mt-2 text-sm text-slate-500">


                            Review recent agency notifications.


                        </p>


                    </a>


                    <a
                        href="{{ route('profile') }}"
                        class="rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-amber-500 hover:bg-slate-800">


                        <div class="text-4xl">


                            👤


                        </div>


                        <h3 class="mt-4 text-lg font-semibold text-white">


                            Profile


                        </h3>


                        <p class="mt-2 text-sm text-slate-500">


                            View your investigator profile.


                        </p>


                    </a>


                </div>


            </div>


            <!-- Active Cases -->
                                 <div class="executive-card p-8">


                <div class="mb-6 flex items-center justify-between">


                    <h2 class="text-2xl font-bold text-white">


                        Active Investigations


                    </h2>


                    <a
                        href="{{ route('cases.index') }}"
                        class="text-sm text-amber-500 hover:text-amber-400">


                        View All


                    </a>


                </div>


                @forelse($activeCases as $case)


                    <a
                        href="{{ route('cases.show',$case) }}"
                        class="mb-4 block rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-amber-500">


                        <div class="flex items-start justify-between">


                            <div>


                                <h3 class="text-xl font-semibold text-white">


                                    {{ $case->title }}


                                </h3>


                                <p class="mt-2 text-slate-500">


                                    {{ $case->code }}


                                </p>


                            </div>


                            <div class="text-right">


                                <div class="text-amber-400">


                                    {{ $case->difficulty }}


                                </div>


                                <div class="mt-3">


                                    <span class="rounded-full bg-blue-900 px-3 py-1 text-xs font-semibold text-blue-300">


                                        🔍 In Progress


                                    </span>


                                </div>


                            </div>


                        </div>


                    </a>


                @empty


                    <div class="rounded-xl border border-dashed border-slate-700 py-12 text-center">


                        <div class="text-5xl">


                            🗂️


                        </div>


                        <h3 class="mt-5 text-xl font-semibold text-white">


                            No Active Investigations


                        </h3>


                        <p class="mt-2 text-slate-500">


                            Unlock a mission using a Mission Code to begin your next investigation.


                        </p>


                    </div>


                @endforelse


            </div>


        </main>


@endsection