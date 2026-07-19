@extends('layouts.app')

@section('title','Create Case')

@section('content')

<div class="p-10">

<h1 class="text-4xl text-white mb-8">

Create Investigation

</h1>

<form

method="POST"

action="{{ route('admin.cases.store') }}"

class="executive-card p-8 space-y-6">

@csrf

<input

name="code"

placeholder="CS-001"

class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">

<input

name="title"

placeholder="Case Title"

class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">

<textarea

name="description"

rows="6"

placeholder="Description"

class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white"></textarea>

<select

name="difficulty"

class="w-full rounded border border-slate-700 bg-slate-900 px-5 py-3 text-white">

<option>Easy</option>

<option>Medium</option>

<option>Hard</option>

</select>

<label class="flex items-center gap-3 text-white">

<input

type="checkbox"

name="published"

value="1">

Published

</label>

<button

class="rounded bg-amber-600 px-8 py-3 text-white">

Save Case

</button>

</form>

</div>

@endsection