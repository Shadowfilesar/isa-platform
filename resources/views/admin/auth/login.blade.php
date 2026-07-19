@extends('layouts.app')

@section('title','Admin Login')

@section('content')

<div class="min-h-screen flex items-center justify-center">

<form

method="POST"

action="{{ route('admin.login.store') }}"

class="executive-card w-full max-w-lg p-10">

@csrf

<h1

class="text-3xl text-white mb-8">

ISA Administration

</h1>

<input

type="email"

name="email"

placeholder="Email"

class="w-full mb-5 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white">

<input

type="password"

name="password"

placeholder="Password"

class="w-full mb-8 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white">

<button

class="w-full rounded-lg bg-amber-600 py-3 text-white">

Login

</button>

</form>

</div>

@endsection