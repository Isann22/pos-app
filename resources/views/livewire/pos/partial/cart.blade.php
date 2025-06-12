<aside id="right-sidebar"
    class="fixed top-0 right-0 z-40 w-60 h-screen pt-24 sm:pt-10 sidebar sidebar-right bg-gradient-to-b from-orange-50 to-amber-50 border-l border-orange-100">

    <div class="h-full flex flex-col">
        <div class="flex items-center justify-center gap-4 pb-4 text-orange-400">
            <span>
                <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>
            <h2 class="text-xl text-orange-700 font-semibold">Order Item</h2>
        </div>
        <hr>
        <div class="px-4 overflow-y-auto flex-grow">
            @if (count($cart) > 0)
                <div class="space-y-4 py-2">
                    @foreach ($cart as $index => $item)
                        <div class="bg-white p-3 rounded-lg shadow-sm border border-orange-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-orange-800">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-orange-600">{{ $item['price'] }}</p>
                                </div>
                                <button wire:click="removeFromCart({{ $index }}) "
                                    class="cursor-pointer text-orange-400 hover:text-orange-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center border border-orange-200 rounded-lg">
                                    <button wire:click="updateQuantity({{ $index }}, -1)"
                                        class="px-2 text-orange-600 hover:bg-orange-50 rounded-l-lg">
                                        -
                                    </button>
                                    <span class="px-2 text-sm">{{ $item['qty'] }}</span>
                                    <button wire:click="updateQuantity({{ $index }}, 1)"
                                        class="px-2 text-orange-600 hover:bg-orange-50 rounded-r-lg">
                                        +
                                    </button>
                                </div>
                                <span
                                    class="font-medium text-orange-700">{{ format_currency($item['total_price']) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-orange-400">
                    <p class="mt-2 text-sm">kosong</p>
                </div>
            @endif
        </div>

        <div class="p-4 bg-white/80 border-t border-orange-100">
            <div class="flex justify-between mb-2">
                <span class="text-orange-600">Total:</span>
                <span class="font-medium text-orange-700">{{ format_currency($total) }}</span>
            </div>

            @if (count($cart) > 0)
                <div class="flex gap-2 mb-2">
                    <button wire:click="clearCart"
                        class="flex-1 cursor-pointer bg-white border border-orange-300 text-orange-600 py-2 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                        Bersihkan
                    </button>
                    <button wire:click="openPaymentModal"
                        class="flex-1 cursor-pointer bg-gradient-to-r from-orange-500 to-amber-500 text-white py-2 rounded-lg font-medium hover:from-orange-600 hover:to-amber-600 transition-colors">
                        Checkout
                    </button>
                </div>
            @else
                <button wire:click="openPaymentModal"
                    class="w-full cursor-not-allowed bg-gradient-to-r from-orange-500 to-amber-500 text-white py-2 rounded-lg font-medium hover:from-orange-600 hover:to-amber-600 transition-colors disabled:opacity-50"
                    disabled>
                    Checkout
                </button>
            @endif

            <button
                class="w-full mt-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white py-2 rounded-lg font-medium hover:from-orange-600 hover:to-amber-600 transition-colors">
                <a href="{{ route('form-deteksi') }}">
                    Deteksi Uang
                </a>
            </button>
        </div>
    </div>
</aside>
