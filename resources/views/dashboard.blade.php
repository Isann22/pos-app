<x-app-layout>
    <!-- Soft Background -->
    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-amber-50 p-6 sm:p-8">

        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div
                class="inline-flex items-center justify-center mb-6 p-3 rounded-full bg-white/80 shadow-sm border border-amber-100">
                <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-amber-900 mb-3">
                <span class="text-amber-500">🌸</span> Khalisa Florist
            </h1>
        </div>

        <!-- Main Cards Grid with Full Clickable Area -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
            <!-- POS Card -->
            <a href="{{ route('cashier') }}"
                class="block bg-white rounded-xl shadow-md overflow-hidden border border-amber-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="p-3 rounded-lg bg-amber-100/50">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-amber-900">POS</h2>
                        </div>
                    </div>
                    <div class="mt-auto flex justify-end">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Inventory Card -->
            <a href="{{ route('filament.admin.pages.dashboard') }}"
                class="block bg-white rounded-xl shadow-md overflow-hidden border border-amber-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="p-3 rounded-lg bg-green-100/50">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-amber-900">Inventory</h2>
                        </div>
                    </div>
                    <div class="mt-auto flex justify-end">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Floral Decoration -->
        <div class="flex justify-center mt-16 opacity-20">
            <svg class="w-10 h-10 text-amber-400 animate-float" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </div>
</x-app-layout>
