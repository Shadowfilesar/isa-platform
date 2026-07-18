@extends('layouts.app')


@section('title', $file->title)


@section('page-title', $file->title)
@section('page-description', 'Case File Viewer')
@section('breadcrumb', $file->title)


@section('content')
@php
    $isLocked = (bool) ($file->locked ?? false);
    $filePath = $file->file_path ?? null;
    $fileUrl = $filePath ? asset($filePath) : null;
    $extension = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;


    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
    $audioExtensions = ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac'];
    $videoExtensions = ['mp4', 'webm', 'mov', 'avi', 'mkv', 'm4v'];
    $textExtensions = ['txt', 'md', 'log', 'csv', 'json', 'xml'];


    $detectedType = match (true) {
        $extension === 'pdf' => 'pdf',
        in_array($extension, $imageExtensions, true) => 'image',
        in_array($extension, $audioExtensions, true) => 'audio',
        in_array($extension, $videoExtensions, true) => 'video',
        in_array($extension, $textExtensions, true) => 'text',
        default => 'unknown',
    };


    $classification = $case->classification
        ?? $file->classification
        ?? 'TOP SECRET';


    $verifiedMetadata = [
        'Case Code' => $case->code ?? null,
        'File Extension' => $extension ? strtoupper($extension) : null,
        'Display Order' => $file->display_order ?? null,
        'Last Updated' => isset($file->updated_at) && $file->updated_at
            ? $file->updated_at->format('Y-m-d H:i')
            : null,
    ];


    $textContent = null;
    if ($detectedType === 'text' && $filePath) {
        $absolutePath = public_path($filePath);
        $textContent = file_exists($absolutePath)
            ? file_get_contents($absolutePath)
            : 'File not found.';
    }
@endphp


<div class="min-h-screen flex">


    <div class="flex-1">
        @include('dashboard.partials.alerts')


        <main class="p-4 sm:p-6 lg:p-8 space-y-6 lg:space-y-8">
            <div class="executive-card p-5 sm:p-6 lg:p-8 transition duration-300 hover:border-slate-700/80">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="text-sm uppercase tracking-[0.25em] text-amber-400">
                                {{ $case->code }}
                            </div>


                            <span class="rounded-full border border-red-900 bg-red-950/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-red-300">
                                {{ $classification }}
                            </span>


                            @if($isLocked)
                                <span class="rounded-full border border-red-800 bg-red-950/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-red-300">
                                    Locked
                                </span>
                            @else
                                <span class="rounded-full border border-green-800 bg-green-950/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-green-300">
                                    Available
                                </span>
                            @endif
                        </div>


                        <h1 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-white">
                            {{ $file->title }}
                        </h1>


                        @if($file->description)
                            <p class="mt-4 max-w-4xl text-sm sm:text-base lg:text-lg leading-7 lg:leading-8 text-slate-400">
                                {{ $file->description }}
                            </p>
                        @endif
                    </div>


                    <div class="w-full xl:w-auto">
                        <a
                            href="{{ route('cases.show', $case) }}"
                            class="inline-flex min-h-[56px] w-full items-center justify-center rounded-xl border border-amber-500/30 bg-amber-500/10 px-5 py-3 text-sm font-semibold text-amber-300 transition duration-300 hover:border-amber-500 hover:bg-amber-500/15 hover:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/60 xl:w-auto"
                        >
                            ← Back to Case
                        </a>
                    </div>
                </div>


                @if($previousFile || $nextFile)
                    <div class="mt-6 grid gap-3 md:grid-cols-2">
                        @if($previousFile)
                            <a
                                href="{{ route('case-files.show', ['case' => $case, 'file' => $previousFile->id]) }}"
                                class="group relative flex min-h-[56px] w-full items-center gap-4 overflow-hidden rounded-2xl border border-slate-700 bg-slate-900/90 px-5 py-4 text-left shadow-[0_0_0_rgba(245,158,11,0)] transition duration-300 hover:border-amber-500/70 hover:bg-slate-800 hover:shadow-[0_0_24px_rgba(245,158,11,0.15)] focus:outline-none focus:ring-2 focus:ring-amber-500/60"
                            >
                                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-amber-400 via-amber-500 to-amber-600 opacity-70 transition duration-300 group-hover:opacity-100"></div>
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-amber-500/30 bg-amber-500/10 text-2xl text-amber-300 transition duration-300 group-hover:border-amber-400/70 group-hover:bg-amber-500/20 group-hover:text-white">
                                    ←
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-[11px] uppercase tracking-[0.22em] text-slate-500 transition duration-300 group-hover:text-amber-300">
                                        Previous File
                                    </div>
                                    <div class="mt-1 truncate text-sm sm:text-base font-semibold text-white transition duration-300 group-hover:text-amber-50">
                                        {{ $previousFile->title }}
                                    </div>
                                </div>
                            </a>
                        @endif


                        @if($nextFile)
                            <a
                                href="{{ route('case-files.show', ['case' => $case, 'file' => $nextFile->id]) }}"
                                class="group relative flex min-h-[56px] w-full items-center gap-4 overflow-hidden rounded-2xl border border-slate-700 bg-slate-900/90 px-5 py-4 text-left shadow-[0_0_0_rgba(245,158,11,0)] transition duration-300 hover:border-amber-500/70 hover:bg-slate-800 hover:shadow-[0_0_24px_rgba(245,158,11,0.15)] focus:outline-none focus:ring-2 focus:ring-amber-500/60"
                            >
                                <div class="absolute inset-y-0 right-0 w-1 bg-gradient-to-b from-amber-400 via-amber-500 to-amber-600 opacity-70 transition duration-300 group-hover:opacity-100"></div>
                                <div class="min-w-0 flex-1 text-left md:text-right">
                                    <div class="text-[11px] uppercase tracking-[0.22em] text-slate-500 transition duration-300 group-hover:text-amber-300">
                                        Next File
                                    </div>
                                    <div class="mt-1 truncate text-sm sm:text-base font-semibold text-white transition duration-300 group-hover:text-amber-50">
                                        {{ $nextFile->title }}
                                    </div>
                                </div>
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-amber-500/30 bg-amber-500/10 text-2xl text-amber-300 transition duration-300 group-hover:border-amber-400/70 group-hover:bg-amber-500/20 group-hover:text-white">
                                    →
                                </div>
                            </a>
                        @endif
                    </div>
                @endif
            </div>


            <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.8fr)_minmax(320px,0.8fr)] xl:grid-cols-[minmax(0,1.55fr)_minmax(300px,0.9fr)]">
                <div class="order-1 space-y-6">
                    <div class="executive-card overflow-hidden transition duration-300 hover:border-slate-700/80">
                        <div class="border-b border-slate-800 bg-slate-900/70 px-5 py-4 sm:px-6 sm:py-5 lg:px-8">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <h2 class="text-lg sm:text-xl font-bold uppercase tracking-widest text-white">
                                    File Preview
                                </h2>


                                @if($extension)
                                    <span class="text-sm font-medium text-slate-500">
                                        {{ strtoupper($extension) }}
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="p-3 sm:p-5 lg:p-6 xl:p-8">
                            @switch($detectedType)
                                @case('image')
                                    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-950 shadow-2xl shadow-black/20">
                                        <div class="bg-gradient-to-b from-slate-900 to-slate-950 p-2 sm:p-4">
                                            <img
                                                src="{{ $fileUrl }}"
                                                alt="{{ $file->title }}"
                                                class="w-full rounded-xl object-contain"
                                            >
                                        </div>
                                    </div>
                                @break


                                @case('pdf')
                                    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-950 shadow-2xl shadow-black/20">
                                        <iframe
                                            src="{{ $fileUrl }}"
                                            class="h-[72vh] min-h-[620px] w-full bg-slate-950 lg:h-[78vh] xl:h-[82vh]"
                                            title="{{ $file->title }}"
                                        ></iframe>
                                    </div>
                                @break


                                @case('text')
                                    <div class="rounded-2xl border border-slate-800 bg-slate-950/80 p-5 sm:p-6 lg:p-8 shadow-xl shadow-black/10">
                                        <div class="whitespace-pre-line text-sm sm:text-base lg:text-[1.02rem] leading-8 lg:leading-9 text-slate-200">
                                            {!! nl2br(e($textContent)) !!}
                                        </div>
                                    </div>
                                @break


                                @case('audio')
                                    <div class="rounded-2xl border border-slate-800 bg-slate-950/80 p-5 sm:p-6 lg:p-8 shadow-xl shadow-black/10">
                                        <div class="mb-4 text-sm uppercase tracking-[0.2em] text-slate-500">
                                            Audio Evidence
                                        </div>
                                        <audio
                                            controls
                                            class="w-full"
                                        >
                                            <source src="{{ $fileUrl }}">
                                        </audio>
                                    </div>
                                @break


                                @case('video')
                                    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-950 shadow-2xl shadow-black/20">
                                        <div class="bg-gradient-to-b from-slate-900 to-slate-950 p-2 sm:p-4">
                                            <video
                                                controls
                                                class="w-full rounded-xl"
                                            >
                                                <source src="{{ $fileUrl }}">
                                            </video>
                                        </div>
                                    </div>
                                @break


                                @default
                                    <div class="rounded-2xl border border-slate-800 bg-slate-950/60 px-6 py-16 text-center sm:px-8 sm:py-20 shadow-xl shadow-black/10">
                                        <div class="text-5xl mb-5">📄</div>
                                        <div class="text-xl font-semibold text-white">
                                            Preview Not Available
                                        </div>
                                        <p class="mt-3 text-sm sm:text-base text-slate-400">
                                            This file type cannot be previewed directly in the viewer.
                                        </p>


                                        @if($fileUrl)
                                            <a
                                                href="{{ $fileUrl }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="isa-button mt-6 inline-block"
                                            >
                                                Open File
                                            </a>
                                        @endif
                                    </div>
                                @break
                            @endswitch
                        </div>
                    </div>
                </div>


                <div class="order-2 space-y-6 xl:sticky xl:top-6 xl:self-start">
                    <div class="executive-card p-5 sm:p-6 transition duration-300 hover:border-slate-700/80">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-amber-500/20 bg-amber-500/10 text-amber-300">
                                ⬢
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">File Status</h2>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Forensic Access Profile</p>
                            </div>
                        </div>


                        <div class="mt-6 space-y-3">
                            <div class="rounded-xl border border-slate-800 bg-slate-950/60 px-4 py-4 transition duration-300 hover:border-slate-700">
                                <div class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Access Status</div>
                                @if($isLocked)
                                    <div class="mt-2 text-base font-semibold text-red-400">Locked</div>
                                @else
                                    <div class="mt-2 text-base font-semibold text-green-400">Available</div>
                                @endif
                            </div>


                            <div class="rounded-xl border border-slate-800 bg-slate-950/60 px-4 py-4 transition duration-300 hover:border-slate-700">
                                <div class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Classification</div>
                                <div class="mt-2 text-base font-semibold text-white">{{ $classification }}</div>
                            </div>


                            @if($extension)
                                <div class="rounded-xl border border-slate-800 bg-slate-950/60 px-4 py-4 transition duration-300 hover:border-slate-700">
                                    <div class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Format</div>
                                    <div class="mt-2 text-base font-semibold text-white">{{ strtoupper($extension) }}</div>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="executive-card p-5 sm:p-6 transition duration-300 hover:border-slate-700/80">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-700 bg-slate-900 text-slate-300">
                                ≣
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">Verified Metadata</h2>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Confirmed File Attributes</p>
                            </div>
                        </div>


                        <div class="mt-6 space-y-3 text-sm">
                            @foreach($verifiedMetadata as $label => $value)
                                @if(!is_null($value) && $value !== '')
                                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 px-4 py-4 transition duration-300 hover:border-slate-700">
                                        <div class="text-[11px] uppercase tracking-[0.2em] text-slate-500">{{ $label }}</div>
                                        <div class="mt-2 text-sm sm:text-base font-semibold text-white break-words">{{ $value }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>


                    <div class="executive-card p-5 sm:p-6 transition duration-300 hover:border-slate-700/80">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-700 bg-slate-900 text-slate-300">
                                ↗
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">File Access</h2>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Open or export evidence</p>
                            </div>
                        </div>


                        <div class="mt-6 space-y-3">
                            @if($fileUrl)
                                <a
                                    href="{{ $fileUrl }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex min-h-[56px] w-full items-center justify-center rounded-xl bg-amber-600 px-5 py-3 text-sm font-semibold text-white transition duration-300 hover:bg-amber-500 hover:shadow-[0_0_20px_rgba(245,158,11,0.18)] focus:outline-none focus:ring-2 focus:ring-amber-500/60"
                                >
                                    Open in New Tab
                                </a>


                                <a
                                    href="{{ $fileUrl }}"
                                    download
                                    class="inline-flex min-h-[56px] w-full items-center justify-center rounded-xl border border-slate-700 bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition duration-300 hover:border-amber-500 hover:bg-slate-800 hover:text-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-500/40"
                                >
                                    Download File
                                </a>
                            @else
                                <div class="rounded-xl border border-red-900 bg-red-950/40 px-5 py-4 text-center">
                                    <div class="text-sm font-semibold text-red-300">File unavailable</div>
                                    <div class="mt-1 text-xs text-red-400">No file path is available for this record.</div>
                                </div>
                            @endif
                        </div>
                    </div>


                    @if($file->description)
                        <div class="executive-card p-5 sm:p-6 transition duration-300 hover:border-slate-700/80">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-700 bg-slate-900 text-slate-300">
                                    ⌁
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white">Briefing</h2>
                                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Case Summary</p>
                                </div>
                            </div>
                            <p class="mt-5 text-sm sm:text-base leading-7 text-slate-400">
                                {{ $file->description }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>


@endsection