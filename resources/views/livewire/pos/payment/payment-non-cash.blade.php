<div
    class="fixed inset-0 backdrop-blur-md flex items-center justify-center z-50 p-4 transition-opacity duration-300 ease-in-out @if ($showNonCashPaymentModal) opacity-100 @else opacity-0 pointer-events-none @endif">
    <div
        class="bg-white rounded-lg shadow-xl w-full max-w-sm transform transition-transform duration-300 ease-out @if ($showNonCashPaymentModal) scale-100 translate-y-0 @else scale-95 translate-y-4 @endif">
        <!-- Header -->
        <div class="border-b px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Pembayaran Digital</h3>
            <button wire:click="$set('showNonCashPaymentModal', false)"
                class="text-gray-500 hover:text-gray-700 transition-colors duration-200 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        @if ($errorMessage)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 animate-fade-in">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ $errorMessage }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Body -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="transition-all duration-200 ease-in-out">
                    <p class="text-sm text-gray-600">Total Belanja</p>
                    <p class="text-xl font-bold text-gray-800">{{ format_currency($total) }}</p>
                </div>
                <div class="transition-all duration-200 ease-in-out">
                    <p class="text-sm text-gray-600">Metode Pembayaran</p>
                    <p class="text-xl font-bold text-gray-800">Digital</p>
                </div>
            </div>

            <div class="text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <p class="mt-2 text-gray-600">{{ $snapToken }}</p>
            </div>
        </div>



        <!-- Footer -->
        <div class="border-t px-6 py-4 bg-gray-50 rounded-b-lg space-y-3">
            <button wire:click="processMidtransPayment" wire:loading.attr="disabled"
                class="w-full bg-orange-500 text-white py-3 rounded-lg font-medium hover:bg-orange-600 transition-all duration-300 ease-in-out">
                <span wire:loading.remove>Lanjutkan Pembayaran</span>
                <span wire:loading>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses...
                </span>
            </button>
            <button wire:click="$set('showNonCashPaymentModal', false)"
                class="w-full bg-white text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-100 transition-all duration-300 ease-in-out border border-gray-300">
                Batalkan
            </button>

        </div>
    </div>
</div>

@script
    <script>
        Livewire.on('token', ({
            token
        }) => {
            window.snap.pay(token, {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("payment success!");
                    console.log(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
@endscript
