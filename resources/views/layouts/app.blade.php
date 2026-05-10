<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- 🔥 Custom Styling -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: #f8fafc;
        }
.btn-back-premium {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    /* 🔥 SAME AS NAVBAR */
    background: linear-gradient(90deg, #4f46e5, #7c3aed);

    color: #fff;
    padding: 14px 32px;
    border-radius: 999px;
    font-size: 16px;
    font-weight: 500;

    text-decoration: none;
    border: none;

    /* soft glow */
    box-shadow: 0 10px 25px rgba(79,70,229,0.35);

    transition: all 0.3s ease;
}

/* Hover */
.btn-back-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 35px rgba(124,58,237,0.45);
}

/* Click */
.btn-back-premium:active {
    transform: scale(0.96);
}
.arrow {
    color: #ffffff;     /* pure white */
    font-size: 20px;    /* thoda bada */
    font-weight: 700;   /* bold */
    line-height: 1;
}
.btn-back-premium:hover .arrow {
    transform: translateX(-4px);
    transition: 0.3s;
}
    /* Container polish */
        main {
            padding: 20px;
        }

        /* Smooth card look */
        .bg-white {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
    </style>

</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">

        <!-- Navbar -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow mb-3">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

       <div class="max-w-7xl mx-auto px-4">
<!--<a href="javascript:history.back()" class="btn-back-premium">
    ← Back
</a>-->
<a href="javascript:history.back()" class="btn-back-premium">
    <span class="arrow">←</span> Back
</a>
</div>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

    </div>

</body>
</html>