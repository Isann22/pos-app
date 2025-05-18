gunakan alphine untuk trnasisis :
@if ($showCashPaymentModal)
    <div
        class="fixed inset-0 backdrop-blur-md flex items-center justify-center z-50 p-4 
                transition-opacity duration-300 ease-in-out 
                @if ($showCashPaymentModal) opacity-100 @else opacity-0 pointer-events-none @endif">
        <div
            class="bg-white rounded-lg shadow-xl w-full max-w-sm 
                    transform transition-transform duration-300 ease-out
                    @if ($showCashPaymentModal) scale-100 translate-y-0 @else scale-95 translate-y-4 @endif">
            <!-- Header -->
            <div class="border-b px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Pembayaran Tunai</h3>
                <button wire:click="$set('showCashPaymentModal', false)"
                    class="text-gray-500 hover:text-gray-700 
                         transition-colors duration-200 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
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
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="transition-all duration-200 ease-in-out">
                        <p class="text-sm text-gray-600">Total Belanja</p>
                        <p class="text-xl font-bold text-gray-800">{{ format_currency($total) }}</p>
                    </div>
                    <div class="transition-all duration-200 ease-in-out">
                        <p class="text-sm text-gray-600">Kembalian</p>
                        <p
                            class="text-xl font-bold transition-colors duration-300 @if ($changeAmount >= 0) text-green-600 @else text-red-600 @endif">
                            {{ abs($changeAmount) }}
                        </p>
                    </div>
                </div>

                <div>
                    <label for="cashGiven" class="block text-sm font-medium text-gray-700">Uang Diterima</label>
                    <input type="number" wire:model="cashGiven" wire:change="calculateChange" id="cashGiven"
                        min="0" step="500"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-right
                              focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-xl font-bold
                              transition-all duration-200 ease-in">
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t px-6 py-4 bg-gray-50 rounded-b-lg">
                <button wire:click="processCashPayment"
                    class="cursor-pointer w-full bg-orange-500 text-white py-3 rounded-lg font-medium hover:bg-orange-600 
                           transition-all duration-300 ease-in-out
                           @if ($changeAmount < 0 || $cashGiven <= 0) opacity-50 cursor-not-allowed @endif"
                    @if ($changeAmount < 0) disabled @endif>
                    Selesaikan Pembayaran
                </button>
            </div>
        </div>
    </div>
@endif
