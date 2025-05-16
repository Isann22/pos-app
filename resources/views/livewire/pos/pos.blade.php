<div>
    @include('livewire.pos.partial.header')

    @include('livewire.pos.partial.sidebar')
    @include('livewire.pos.partial.cart')




    <div class="p-6 mt-6">
        @if ($showPaymentModal)
            @include('livewire.pos.partial.modal')
        @endif

        @if ($showCashPaymentModal)
            @include('livewire.pos.payment.payment-cash')
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div wire:key="{{ $product->id }}"
                    class="product-card bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow border border-orange-50 hover:border-orange-100">
                    <div
                        class="w-full h-40 bg-orange-50 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                        <img src="{{ Storage::url('images/' . $product->image) }}" "alt="">
                    </div>
                    <h3 class="text-orange-800 font-semibold text-center">{{ $product->name }}</h3>
                    <p class="text-sm text-orange-600 text-center mt-1">
                        {{ format_currency($product->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-orange-500 text-center mt-1">Stok: {{ $product->stock }}</p>
                    <button wire:click.debounce.500ms="addToCart({{ $product->id }})"
                        class="cursor-pointer mt-4 w-full bg-orange-500 text-white py-2 rounded-lg font-medium hover:bg-orange-600 transition-colors text-sm shadow-sm hover:shadow-md">
                        Tambah ke Keranjang
                    </button>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
