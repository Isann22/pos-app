<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)" x-show="show" x-transition:enter="transition ease-out duration-400"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 backdrop-blur-md bg-white/10 flex items-center justify-center z-50 p-4">

    <!-- Modal Content with its own transition -->
    <div x-transition:enter="transition ease-out duration-400 delay-100"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4" <div
        class="bg-white rounded-lg shadow-lg w-full max-w-sm overflow-hidden animate-fadeIn">
        <!-- Header -->
        <div class="border-b px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Metode Pembayaran</h3>
            <button wire:click="closePaymentModal" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6">
            <!-- Total -->
            <div class="mb-6 text-center">
                <p class="text-sm text-gray-600">Total Pembayaran</p>
                <p class="text-2xl font-bold text-orange-600">{{ format_currency($total) }}</p>
            </div>

            <!-- Pilihan Pembayaran -->
            <div class="space-y-3">
                <!-- Tunai -->
                <button wire:click="$set('paymentType', 'cash')"
                    class="cursor-pointer w-full p-4 border rounded-lg flex items-center justify-start space-x-3
                        transition-all duration-300 ease-in-out hover:shadow-md hover:border-orange-300
                        @if ($paymentType === 'cash') border-orange-400 bg-orange-50 @else border-gray-300 @endif">
                    <div
                        class="p-2 rounded-full bg-orange-100 text-orange-600 transition-transform duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">Tunai</span>
                </button>

                <!-- Non-Tunai -->
                <button wire:click="$set('paymentType', 'non-cash')"
                    class="cursor-pointer w-full p-4 border rounded-lg flex items-center justify-start space-x-3
                        transition-all duration-300 ease-in-out hover:shadow-md hover:border-orange-300
                        @if ($paymentType === 'non-cash') border-orange-400 bg-orange-50 @else border-gray-300 @endif">
                    <div
                        class="p-2 rounded-full bg-orange-100 text-orange-600 transition-transform duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <span class="font-medium">Non-Tunai</span>
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t px-6 py-4 bg-gray-50 rounded-b-lg">
            <button wire:click="processPaymentType"
                class="cursor-pointer w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-medium transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg active:translate-y-[1px] active:shadow-md">
                Konfirmasi
            </button>
        </div>
    </div>
</div>
