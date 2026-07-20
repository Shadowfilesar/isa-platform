{{-- resources/views/admin/partials/alerts.blade.php --}}
@if(session('success'))

    <div class="mb-6 rounded-lg border border-green-700 bg-green-900/40 px-5 py-4 text-green-300">

        {{ session('success') }}

    </div>

@endif

@if($errors->any())

    <div class="mb-6 rounded-lg border border-red-700 bg-red-900/40 px-5 py-4 text-red-300">

        <ul class="space-y-1">

            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>

    </div>

@endif