@extends('layouts.app')

@section('title','Edit Case')

@section('content')

<div class="p-10">

<h1 class="text-4xl text-white mb-8">

Edit Investigation

</h1>

<form

method="POST"

action="{{ route('admin.cases.update',$case) }}"

class="executive-card p-8 space-y-6">

@csrf

@method('PUT')

<input

name="code"

value="{{ $case->code }}"

class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">

<input

name="title"

value="{{ $case->title }}"

class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">

<textarea

name="description"

rows="6"

class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">{{ $case->description }}</textarea>

<select

name="difficulty"

class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">

<option {{ $case->difficulty=='Easy'?'selected':'' }}>Easy</option>

<option {{ $case->difficulty=='Medium'?'selected':'' }}>Medium</option>

<option {{ $case->difficulty=='Hard'?'selected':'' }}>Hard</option>

</select>

<label class="flex items-center gap-3 text-white">

<input

type="checkbox"

name="published"

value="1"

{{ $case->published ? 'checked' : '' }}>

Published

</label>

<button

class="rounded bg-amber-600 px-8 py-3 text-white">

Update Case

</button>

</form>

</div>

@endsection