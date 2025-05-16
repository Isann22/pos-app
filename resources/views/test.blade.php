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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Styles */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Sidebar transitions */
        .sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-left {
            transform: translateX(-100%);
        }

        .sidebar-right {
            transform: translateX(100%);
        }

        .sidebar-left.open {
            transform: translateX(0);
        }

        .sidebar-right.open {
            transform: translateX(0);
        }

        /* Navbar styling */
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 0 rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        /* Responsive adjustments */
        @media (min-width: 640px) {
            .sidebar-left {
                transform: translateX(0);
            }

            .sidebar-right {
                transform: translateX(0);
            }

            .navbar {
                width: calc(100% - 20rem);
                /* 100% minus right panel width */
                right: 20rem;
            }
        }

        /* Overlay styling */
        .sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(2px);
        }

        /* Cart item hover effect */
        .cart-item:hover {
            background-color: rgba(249, 168, 37, 0.1);
        }

        /* Product card styling */
        .product-card {
            transition: all 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(249, 168, 37, 0.1);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex flex-col h-screen">
        <!-- Navbar with shadow and border -->
        <nav class="fixed top-0 z-50 navbar bg-gradient-to-r from-orange-50 to-amber-50">
            <div class="px-4 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start rtl:justify-end">
                        <button id="toggle-left-sidebar"
                            class="inline-flex items-center p-2 text-sm text-orange-600 rounded-lg sm:hidden hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                </path>
                            </svg>
                        </button>
                        <a href="/dashboard" wire:navigate
                            class="flex items-center p-2 rounded-lg text-orange-700 hover:bg-orange-100 transition-colors mb-1">
                            <div class="flex-1 ms-6">
                                <h1 class="text-xl font-bold text-orange-600 font-serif">Khalisa Florist</h1>
                                <p class="text-xs text-amber-600">{{ now()->translatedFormat('l, d F Y') }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <div class="relative flex-1 mx-4 max-w-2xl">
                                <!-- Search Icon -->
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-orange-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>

                                <!-- Search Input -->
                                <input type="text" placeholder="Cari produk bunga..."
                                    class="w-full border border-orange-200 rounded-full py-2.5 px-10 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent placeholder-orange-300 bg-white">

                                <!-- Clear Button -->
                                <button type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-orange-400 hover:text-orange-600 hidden"
                                    id="clear-search">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- Mobile cart toggle button -->
                        <button id="toggle-right-sidebar"
                            class="inline-flex items-center p-2 text-sm text-orange-600 rounded-lg sm:hidden hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-orange-300 ml-2">
                            <span class="sr-only">Open cart</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Left Sidebar -->
        <aside id="left-sidebar"
            class="mt-16 fixed top-0 left-0 z-40 w-64 h-screen pt-4 sidebar sidebar-left bg-gradient-to-b from-orange-50 to-amber-50 border-r border-orange-100 sm:translate-x-0">
            <div class="h-full px-3 pb-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="#"
                            class="flex items-center p-3 rounded-lg text-orange-700 hover:bg-orange-100 transition-colors">
                            <div class="p-2 rounded-lg bg-orange-100 text-orange-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <span class="ml-3">Bunga Potong</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bg-white/80 border-t border-orange-100 p-3">
                <div class="flex items-center">
                    <div
                        class="bg-gradient-to-br from-orange-500 to-amber-500 rounded-full w-9 h-9 flex items-center justify-center text-white font-bold shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-orange-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-amber-500">Kasir</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="ml-auto items-end text-orange-500 hover:text-orange-700 p-1 rounded-full hover:bg-orange-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Right Panel (Cart) -->
        <aside id="right-sidebar"
            class="fixed top-0 right-0 z-40 w-80 h-screen pt-16 sidebar sidebar-right bg-white border-l border-orange-100 shadow-sm">
            <div class="h-full flex flex-col">
                <div class="px-4 py-4 overflow-y-auto flex-grow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-orange-700">Keranjang Belanja</h3>
                        <span class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full">0 items</span>
                    </div>

                    <div class="space-y-3">
                        <!-- Cart items will go here -->
                        <div class="text-center py-12 text-orange-300">
                            <svg class="w-16 h-16 mx-auto opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="mt-4 text-sm text-orange-400">Keranjang belanja kosong</p>
                            <p class="text-xs text-orange-300 mt-1">Tambahkan produk ke keranjang</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white border-t border-orange-100 shadow-inner">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-orange-600 font-medium">Total:</span>
                        <span class="font-semibold text-orange-700 text-lg">Rp 0</span>
                    </div>
                    <button
                        class="w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white py-3 rounded-lg font-medium hover:from-orange-600 hover:to-amber-600 transition-all shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Checkout
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 pt-16 sm:ml-64 sm:mr-80 overflow-auto bg-white">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-orange-700">Daftar Produk</h2>
                    <p class="text-orange-500">Pilih bunga favorit Anda</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Product Cards -->
                    <div
                        class="product-card bg-orange-50 rounded-xl p-5 border border-orange-100 hover:border-orange-200">
                        <div class="w-full h-40 bg-orange-100 rounded-lg mb-4 flex items-center justify-center">
                            <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-orange-700 font-semibold text-center">Bunga Mawar</h3>
                        <p class="text-sm text-orange-500 text-center mt-1">Rp 25.000</p>
                        <button
                            class="mt-4 w-full bg-orange-100 text-orange-600 py-2 rounded-lg font-medium hover:bg-orange-200 transition-colors text-sm">
                            Tambah ke Keranjang
                        </button>
                    </div>

                    <!-- More product cards... -->
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const toggleLeftSidebar = document.getElementById('toggle-left-sidebar');
            const toggleRightSidebar = document.getElementById('toggle-right-sidebar');
            const leftSidebar = document.getElementById('left-sidebar');
            const rightSidebar = document.getElementById('right-sidebar');

            // Create overlay
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 z-30 sidebar-overlay hidden';
            overlay.id = 'sidebar-overlay';
            document.body.appendChild(overlay);

            // Close sidebars function
            function closeSidebars() {
                leftSidebar.classList.remove('open');
                rightSidebar.classList.remove('open');
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Toggle left sidebar
            toggleLeftSidebar.addEventListener('click', function() {
                const isOpening = !leftSidebar.classList.contains('open');
                leftSidebar.classList.toggle('open');
                rightSidebar.classList.remove('open');
                overlay.classList.toggle('hidden', !isOpening);
                document.body.style.overflow = isOpening ? 'hidden' : 'auto';
            });

            // Toggle right sidebar
            toggleRightSidebar.addEventListener('click', function() {
                const isOpening = !rightSidebar.classList.contains('open');
                rightSidebar.classList.toggle('open');
                leftSidebar.classList.remove('open');
                overlay.classList.toggle('hidden', !isOpening);
                document.body.style.overflow = isOpening ? 'hidden' : 'auto';
            });

            // Close when clicking overlay
            overlay.addEventListener('click', closeSidebars);

            // Close with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSidebars();
                }
            });

            // Handle window resize
            function handleResize() {
                if (window.innerWidth >= 640) {
                    leftSidebar.classList.add('open');
                    rightSidebar.classList.add('open');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }

            // Initialize
            handleResize();
            window.addEventListener('resize', handleResize);

            // Sample cart functionality
            const addToCartButtons = document.querySelectorAll('.product-card button');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // In a real app, this would add the product to cart
                    console.log('Product added to cart');
                });
            });
        });
    </script>
</body>

</html>
