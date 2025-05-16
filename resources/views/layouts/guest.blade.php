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
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[image:var(--gradient-floral)] bg-cover px-4 sm:px-0">
        <div
            class="w-full max-w-md mt-28 lg:mt-4 sm:mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden rounded-2xl relative transition-all duration-300 hover:shadow-xl">
            <div class="mb-8 text-center font-sacramento">
                <h1 class="text-3xl font-bold text-orange-600 mt-4"><span class="text-floral-primary">🌸</span> Khalisa
                    FLorist</h1>

            </div>
            <div class="absolute -top-4 -left-4 w-16 h-16 rounded-full bg-orange-200 opacity-30"></div>
            <div class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-amber-200 opacity-30"></div>

            <div class="absolute top-0 right-0 transform rotate-45 opacity-20">
                <svg class="w-24 h-24 text-orange-400" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>

            </div>

            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>
