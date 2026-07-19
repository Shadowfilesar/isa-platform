@extends('layouts.app')

@section('title', $file->title)

@section('content')

<div class="min-h-screen flex">

    @include('dashboard.partials.sidebar')

    <div class="flex-1">

        @include('dashboard.partials.header')

        @include('dashboard.partials.breadcrumb')

        @include('dashboard.partials.alerts')

        <main class="p-8 space-y-8">

            <div class="executive-card p-8">

                <div class="flex justify-between items-start">

                    <div>

                        <div class="text-amber-400 uppercase tracking-widest">

                            {{ $case->code }}

                        </div>

                        <h1 class="text-4xl text-white mt-2">

                            {{ $file->title }}

                        </h1>

                        @if($file->description)

                            <p class="text-slate-400 mt-4">

                                {{ $file->description }}

                            </p>

                        @endif

                    </div>

                    <a
                        href="{{ route('cases.show',$case) }}"
                        class="text-amber-400">

                        ← Back

                    </a>

                </div>

            </div>

            <div class="executive-card p-8">

                @switch($file->file_type)

                    @case('image')

                        <img
                            src="{{ asset($file->file_path) }}"
                            class="rounded-xl w-full">

                    @break

                    @case('pdf')

                        <iframe
                            src="{{ asset($file->file_path) }}"
                            class="w-full h-[900px] rounded-xl">
                        </iframe>

                    @break

                    @case('text')

                        <div class="whitespace-pre-line text-slate-200 leading-8">

                            {!! nl2br(e(file_exists(public_path($file->file_path))
                                ? file_get_contents(public_path($file->file_path))
                                : 'File not found.')) !!}

                        </div>

                    @break

                    @case('audio')

                        <audio
                            controls
                            class="w-full">

                            <source
                                src="{{ asset($file->file_path) }}">

                        </audio>

                    @break

                    @case('video')

                        <video
                            controls
                            class="w-full rounded-xl">

                            <source
                                src="{{ asset($file->file_path) }}">

                        </video>

                    @break

                    @default

                        <div class="text-center py-20">

                            <div class="text-5xl mb-5">

                                📄

                            </div>

                            <div class="text-white text-xl">

                                Download File

                            </div>

                            <a
                                href="{{ asset($file->file_path) }}"
                                target="_blank"
                                class="isa-button mt-6 inline-block">

                                Open

                            </a>

                        </div>

                @endswitch

            </div>

        </main>

    </div>

</div>

@endsection