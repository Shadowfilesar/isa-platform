@extends('layouts.app')


@section('title','Cases')


@section('page-title','Cases')


@section('page-description','Assigned Investigation Cases')


@section('breadcrumb','Cases')


@section('content')



        @include('dashboard.partials.alerts')


        <main class="p-8 space-y-8">


            <div class="executive-card p-8">


                <div class="flex items-center justify-between">


                    <div>


                        <h1 class="text-4xl font-bold text-white">


                            Investigation Cases


                        </h1>


                        <p class="mt-3 text-slate-400">


                            Browse all investigations assigned to your account.


                        </p>


                    </div>


                    <div class="text-right">


                        <div class="text-slate-500">


                            Total Assigned


                        </div>


                        <div class="mt-2 text-5xl font-bold text-white">


                            {{ $cases->count() }}


                        </div>


                    </div>


                </div>


            </div>


            <div class="grid gap-6 md:grid-cols-3">


                <div class="executive-card p-6">


                    <div class="text-slate-500">


                        Total Cases


                    </div>


                    <div class="mt-3 text-3xl font-bold text-white">


                        {{ $cases->count() }}


                    </div>


                </div>


                <div class="executive-card p-6">


                    <div class="text-slate-500">


                        Active


                    </div>


                    <div class="mt-3 text-3xl font-bold text-amber-400">


                        {{ $cases->count() }}


                    </div>


                </div>


                <div class="executive-card p-6">


                    <div class="text-slate-500">


                        Completed


                    </div>


                    <div class="mt-3 text-3xl font-bold text-green-400">


                        0


                    </div>


                </div>


            </div>


            <div class="space-y-5">
                                @forelse($cases as $case)


                    <a
                        href="{{ route('cases.show',$case) }}"
                        class="block rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-amber-500 hover:bg-slate-800">


                        <div class="flex items-start justify-between">


                            <div class="flex-1">


                                <div class="flex items-center gap-3">


                                    <span
                                        class="rounded-full bg-blue-900 px-3 py-1 text-xs font-semibold text-blue-300">


                                        🔍 In Progress


                                    </span>


                                    <span class="text-sm text-slate-500">


                                        {{ $case->code }}


                                    </span>


                                </div>


                                <h2 class="mt-5 text-2xl font-bold text-white">


                                    {{ $case->title }}


                                </h2>


                                @if($case->description)


                                    <p class="mt-3 text-slate-400">


                                        {{ \Illuminate\Support\Str::limit($case->description,180) }}


                                    </p>


                                @endif


                            </div>


                            <div class="text-right">


                                <div class="text-sm text-slate-500">


                                    Difficulty


                                </div>


                                <div class="mt-2 text-xl font-bold text-amber-400">


                                    {{ $case->difficulty }}


                                </div>


                                <div class="mt-6">


                                    <span
                                        class="rounded-lg bg-amber-600 px-5 py-3 font-semibold text-white">


                                        Open Case


                                    </span>


                                </div>


                            </div>


                        </div>


                    </a>


                @empty


                    <div class="executive-card p-12 text-center">


                        <div class="text-6xl">


                            🗂️


                        </div>


                        <h2 class="mt-6 text-2xl font-bold text-white">


                            No Cases Available


                        </h2>


                        <p class="mt-3 text-slate-500">


                            Unlock a mission using a Mission Code to receive your first investigation.


                        </p>


                    </div>


                @endforelse
                            </div>


        </main>



@endsection