<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


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

  public function processMidtransOrder(array $cart, string $cashierName)
  {


    return DB::transaction(function () use ($cart, $cashierName) {
      try {

        $this->configureMidtrans();


        $order = $this->createOrderRecord($cart, $cashierName);


        $this->processOrderItems($order, $cart);


        $this->generateMidtransPayment($order, $cart);

        return $order;
      } catch (\Exception $e) {
        logger()->error('Midtrans Order Failed: ' . $e->getMessage(), [
          'cart' => $cart,
          'trace' => $e->getTraceAsString()
        ]);
        throw new \Exception('Transaksi Midtrans gagal: ' . $e->getMessage());
      }
    });
  }

  protected function configureMidtrans()
  {
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production');
    \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
    \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
  }

  protected function createOrderRecord(array $cart, string $cashierName)
  {
    return Order::create([
      'id' => Str::uuid(),
      'total' => $this->calculateTotal($cart),
      'payment_method' => 'non-cash',
      'cashier_name' => $cashierName,
      'status' => 'pending',
      'created_at' => now()
    ]);
  }

  protected function processOrderItems(Order $order, array $cart)
  {
    foreach ($cart as $item) {
      $product = Product::lockForUpdate()->findOrFail($item['product_id']);

      // Validasi stok
      if ($product->stock < $item['qty']) {
        throw new \Exception("Stok produk {$product->name} tidak mencukupi");
      }

      OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'product_name' => $product->name,
        'price' => $item['price'],
        'quantity' => $item['qty'],
        'subtotal' => $item['price'] * $item['qty']
      ]);

      $product->decrement('stock', $item['qty']);
    }
  }

  protected function generateMidtransPayment(Order $order, array $cart)
  {
    $params = [
      'transaction_details' => [
        'order_id' => $order->id,
        'gross_amount' => $order->total,

      ],
      "enabled_payments" => [
        "gopay",
        "shopeepay",
        "bca_va",
        "bni_va",
        "akulaku"
      ],

      'item_details' => array_map(function ($item) {
        return [
          'id' => $item['product_id'],
          'price' => $item['price'],
          'quantity' => $item['qty'],
          'name' => $item['product_name'] ?? Product::find($item['product_id'])->name,
        ];
      }, $cart),
    ];

    $snapResponse = \Midtrans\Snap::createTransaction($params);

    $order->update([
      'midtrans_snap_token' => $snapResponse->token,
      'status' => "paid"
    ]);
  }




  private function calculateTotal(array $cart): float
  {
    return array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['qty']), 0);
  }

  public function getOrder($orderId)
  {
    return Order::find($orderId);
  }
}
