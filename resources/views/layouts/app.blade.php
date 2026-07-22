<!DOCTYPE html>
<html lang="ar"
      dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'ISA')
    </title>

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700;900&display=swap"
          rel="stylesheet">

    <!-- FontAwesome -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>

        tailwind.config = {

            theme: {

                extend: {

                    colors: {

                        isa: {

                            gold:'#c5a880',

                            goldMuted:'rgba(197,168,128,.15)',

                            emerald:'#1e4620',

                            emeraldText:'#a3b899',

                            dark:'#080a0f',

                            navy:'#0f131c',

                            slate:'#171e2b',

                            burgundy:'#4c1d1d'

                        }

                    },

                    fontFamily:{

                        sans:['Inter','Tajawal','sans-serif'],

                        serif:['Cormorant Garamond','serif']

                    }

                }

            }

        }

    </script>

    <style>

        ::-webkit-scrollbar{

            width:4px;

            height:4px;

        }

        ::-webkit-scrollbar-track{

            background:#080a0f;

        }

        ::-webkit-scrollbar-thumb{

            background:#c5a880;

        }

        body{

            background:#080a0f;

            color:#cbd5e1;

            font-family:'Inter','Tajawal',sans-serif;

        }

        .brushed-bg{

            background:
            radial-gradient(circle at center,#111521 0%,#06080c 100%);

        }

        .executive-card{

            background:#0f131c;

            border:1px solid #1f2937;

            border-radius:10px;

        }

        .executive-glow{

            transition:.35s;

        }

        .executive-glow:hover{

            border-color:rgba(197,168,128,.35);

            box-shadow:

            0 0 25px rgba(197,168,128,.04);

        }

        .isa-input{

            width:100%;

            background:#080a0f;

            border:1px solid #263142;

            color:#fff;

            border-radius:8px;

            padding:12px;

        }

        .isa-input:focus{

            outline:none;

            border-color:#c5a880;

        }

        .isa-button{

            width:100%;

            background:#c5a880;

            color:#080a0f;

            font-weight:bold;

            padding:12px;

            border-radius:8px;

            transition:.3s;

        }

        .isa-button:hover{

            opacity:.9;

        }

    </style>

    @stack('styles')

</head>

<body class="brushed-bg min-h-screen">

@if(session('success'))

<div class="fixed top-6 left-1/2 -translate-x-1/2 z-50">

    <div class="bg-green-900/40 border border-green-700 text-green-300 px-6 py-3 rounded">

        {{ session('success') }}

    </div>

</div>

@endif

@if($errors->any())

<div class="fixed top-6 left-1/2 -translate-x-1/2 z-50">

    <div class="bg-red-900/30 border border-red-700 text-red-300 px-6 py-3 rounded">

        {{ $errors->first() }}

    </div>

</div>

@endif

@yield('content')

@stack('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>