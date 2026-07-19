@extends('layouts.app')

@section('title','Profile')

@section('breadcrumb')

<span class="text-isa-gold">

Profile

</span>

@endsection

@section('content')

<div class="min-h-screen flex">

@include('dashboard.partials.sidebar')

<div class="flex-1">

@include('dashboard.partials.header')

@include('dashboard.partials.breadcrumb')

@include('dashboard.partials.alerts')

<div class="p-8">

<div class="executive-card p-8">

<h2
class="text-2xl text-white">

Investigator Profile

</h2>

<div class="grid grid-cols-2 gap-6 mt-8">

<div>

<p class="text-slate-500">

Account

</p>

<p class="text-white">

{{ $player->account_code }}

</p>

</div>

<div>

<p class="text-slate-500">

Rank

</p>

<p class="text-white">

{{ $player->rank }}

</p>

</div>

<div>

<p class="text-slate-500">

Level

</p>

<p class="text-white">

{{ $player->level }}

</p>

</div>

<div>

<p class="text-slate-500">

XP

</p>

<p class="text-white">

{{ $player->xp }}

</p>

</div>

</div>

</div>

</div>

</div>

</div>

@endsection