@extends('layouts.app')

@section('title','Cases')

@section('content')

<div class="min-h-screen flex">

    @include('dashboard.partials.sidebar')

    <div class="flex-1">

        @include('dashboard.partials.header')

        @include('dashboard.partials.breadcrumb')

        @include('dashboard.partials.alerts')

        <main class="p-8">

            <div class="executive-card p-8">

                <h1 class="text-3xl text-white mb-8">

                    Investigation Cases

                </h1>

                @forelse($cases as $case)

                    <a
                        href="{{ route('cases.show',$case) }}"
                        class="block border border-slate-800 rounded-xl p-6 mb-5 hover:border-amber-500">

                        <div class="flex justify-between">

                            <div>

                                <div class="text-2xl text-white">

                                    {{ $case->title }}

                                </div>

                                <div class="text-slate-500 mt-2">

                                    {{ $case->code }}

                                </div>

                            </div>

                            <div class="text-right">

                                <div class="text-slate-500">

                                    Difficulty

                                </div>

                                <div class="text-amber-400 mt-2">

                                    {{ $case->difficulty }}

                                </div>

                            </div>

                        </div>

                    </a>

                @empty

                    <div class="text-center py-12 text-slate-500">

                        No investigations assigned.

                    </div>

                @endforelse

            </div>

        </main>

    </div>

</div>

@endsection