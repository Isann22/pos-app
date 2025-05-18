<div class="bg-white p-6 max-w-xs mx-auto" x-data="{
    printReceipt() {
        this.$dispatch('print-receipt');
        setTimeout(() => {
            window.print();
        }, 200);
    }
}" x-init="printReceipt()">
    <!-- Header Struk -->
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold">{{ config('app.name') }}</h1>
        <p class="text-sm text-gray-600">Jl. Contoh No. 123, Kota Anda</p>
        <p class="text-sm text-gray-600">Telp: 0812-3456-7890</p>
    </div>

    <!-- Info Transaksi -->
    <div class="border-b border-gray-200 pb-2 mb-2">
        <div class="flex justify-between">
            <span class="font-medium">No. Transaksi:</span>
            <span>{{ $order->id }}</span>
        </div>
        <div class="flex justify-between">
            <span class="font-medium">Tanggal:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex justify-between">
            <span class="font-medium">Kasir:</span>
            <span>{{ $order->cashier_name }}</span>
        </div>
    </div>

    <!-- Daftar Item -->
    <div class="mb-4">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left pb-1">Item</th>
                    <th class="text-right pb-1">Qty</th>
                    <th class="text-right pb-1">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr class="border-b border-gray-100">
                        <td class="py-1">{{ $item->product_name }}</td>
                        <td class="text-right py-1">{{ $item->quantity }} × {{ format_currency($item->price) }}</td>
                        <td class="text-right py-1">{{ format_currency($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Total Pembayaran -->
    <div class="border-t border-gray-200 pt-2 mb-4">
        <div class="flex justify-between font-medium">
            <span>Total:</span>
            <span>{{ format_currency($order->total) }}</span>
        </div>
        @if ($order->payment_method == 'cash')
            <div class="flex justify-between">
                <span>Tunai:</span>
                <span>{{ format_currency($order->cash_received) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kembali:</span>
                <span>{{ format_currency($order->change) }}</span>
            </div>
        @endif
    </div>

    <!-- Footer Struk -->
    <div class="text-center text-xs text-gray-500">
        <p>Terima kasih telah berbelanja</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
    </div>

    <!-- Tombol Cetak Ulang (Opsional) -->
    @if (!$isPrinting)
        <div class="mt-4">
            <button @click="printReceipt()" class="w-full bg-blue-500 text-white py-2 rounded">
                Cetak Ulang
            </button>
        </div>
    @endif
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .receipt-print,
        .receipt-print * {
            visibility: visible;
        }

        .receipt-print {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 100%;
        }
    }
</style>
