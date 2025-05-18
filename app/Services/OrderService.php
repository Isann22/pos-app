<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class OrderService
{
  public function processCashOrder(array $cart, float $cashReceived, string $cashierName)
  {
    try {
      return DB::transaction(function () use ($cart, $cashReceived, $cashierName) {

        $orderId = Str::uuid();


        $order = Order::create([
          'id' => $orderId,
          'total' => $this->calculateTotal($cart),
          'payment_method' => 'cash',
          'cash_received' => $cashReceived,
          'change' => $cashReceived - $this->calculateTotal($cart),
          'cashier_name' => $cashierName,
          'completed_at' => now()
        ]);


        foreach ($cart as $item) {
          $product = Product::lockForUpdate()->find($item['product_id']);

          OrderItem::create([
            'order_id' => $orderId,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $item['price'],
            'quantity' => $item['qty'],
            'subtotal' => $item['price'] * $item['qty']
          ]);

          $product->decrement('stock', $item['qty']);
        }

        return $order;
      });
    } catch (\Exception $e) {
      throw new \Exception('Gagal memproses order: ' . $e->getMessage());
    }
  }

  private function calculateTotal(array $cart): float
  {
    return array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['qty']), 0);
  }
}
