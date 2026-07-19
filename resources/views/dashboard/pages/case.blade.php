@extends('layouts.app')

@section('title',$case->title)

@section('content')

<div class="min-h-screen flex">

@include('dashboard.partials.sidebar')

<div class="flex-1">

@include('dashboard.partials.header')

@include('dashboard.partials.breadcrumb')

@include('dashboard.partials.alerts')

<main class="p-8 space-y-8">

<div class="executive-card p-8">

<div class="flex justify-between">

<div>

<div class="text-amber-400 uppercase">

{{ $case->code }}

</div>

<h1 class="text-4xl text-white mt-2">

{{ $case->title }}

</h1>

<p class="text-slate-400 mt-4">

{{ $case->description }}

</p>

</div>

<div class="text-right">

<div class="text-slate-500">

Difficulty

</div>

<div class="text-amber-400 text-2xl">

{{ $case->difficulty }}

</div>

</div>

</div>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

<div class="executive-card p-5">

<div class="text-slate-500">

Total Files

</div>

<div class="text-3xl text-white font-bold mt-2">

{{ $stats['totalFiles'] }}

</div>

</div>

<div class="executive-card p-5">

<div class="text-slate-500">

Locked Files

</div>

<div class="text-3xl text-red-400 font-bold mt-2">

{{ $stats['lockedFiles'] }}

</div>

</div>

<div class="executive-card p-5">

<div class="text-slate-500">

Unlocked Files

</div>

<div class="text-3xl text-green-400 font-bold mt-2">

{{ $stats['unlockedFiles'] }}

</div>

</div>

<div class="executive-card p-5">

<div class="text-slate-500">

Sections

</div>

<div class="text-3xl text-white font-bold mt-2">

{{ $stats['totalSections'] }}

</div>

</div>

<div class="executive-card p-5">

<div class="text-slate-500">

Last Updated

</div>

<div class="text-lg text-white font-semibold mt-2">

{{ $stats['lastUpdated'] ? $stats['lastUpdated']->format('Y-m-d H:i') : '-' }}

</div>

</div>

</div>

<form
method="GET"
action="{{ route('cases.show',$case) }}"
class="executive-card p-6">

<div class="flex gap-3">

<input
name="search"
value="{{ $search }}"
placeholder="Search case files"
class="isa-input">

<button
type="submit"
class="rounded bg-amber-600 px-6 py-3 text-white">

Search

</button>

<a
href="{{ route('cases.show',$case) }}"
class="rounded bg-slate-800 px-6 py-3 text-white">

Clear

</a>

</div>

</form>

@forelse($sections as $section=>$files)

<div class="executive-card">

<div class="px-8 py-5 border-b border-slate-800 bg-slate-900/70">

<div class="flex justify-between items-center">

<h2
class="text-xl text-white uppercase tracking-widest">

{{ $section }}

</h2>

<div class="text-sm text-slate-500">

{{ $files->count() }} files

</div>

</div>

</div>

<div>

@foreach($files as $file)

<div
class="flex justify-between items-center px-8 py-5 border-b border-slate-900">

<div>

<div class="text-white text-lg">

{{ $file->title }}

</div>

<div class="text-slate-500 text-sm mt-1">

{{ $file->file_type }} / Order {{ $file->display_order }}

</div>

@if($file->description)

<div class="text-slate-500 mt-2">

{{ $file->description }}

</div>

@endif

</div>

<div>

@if($file->locked)

<span class="text-red-400">

Locked

</span>

@else

<a

href="{{ route('case-files.show',[$case,$file->id]) }}"

class="isa-button">

Open File

</a>

@endif

</div>

</div>

@endforeach

</div>

</div>

@empty

<div class="executive-card p-10 text-center text-slate-500">

No case files found.

</div>

@endforelse

</main>

</div>

</div>

@endsection
