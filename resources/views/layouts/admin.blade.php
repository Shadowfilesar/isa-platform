{{-- resources/views/layouts/admin.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="min-h-screen">

    @include('admin.partials.header')

    <div class="lg:flex">

        @include('admin.partials.sidebar')

        <div class="min-w-0 flex-1">

            <div class="p-10">

                @include('admin.partials.alerts')

                @include('admin.partials.breadcrumb')

                @yield('admin-content')

            </div>

        </div>

    </div>

</div>

@endsection