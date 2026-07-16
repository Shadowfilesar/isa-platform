@if(session('success'))

<div class="px-8 pt-6">

    <div class="rounded-lg border border-green-700 bg-green-900/20 p-4">

        <p class="text-sm text-green-300">

            {{ session('success') }}

        </p>

    </div>

</div>

@endif

@if($errors->any())

<div class="px-8 pt-6">

    <div class="rounded-lg border border-red-700 bg-red-900/20 p-4">

        <p class="text-sm text-red-300">

            {{ $errors->first() }}

        </p>

    </div>

</div>

@endif