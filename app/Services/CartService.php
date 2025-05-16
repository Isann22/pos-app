<?php

namespace App\Services;

use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartService
{
  protected array $cart = [];
  protected float $total = 0;
  protected string $sessionKey = 'pos_cart';

  public function __construct()
  {
    $this->loadFromSession();
  }

  public function getCart(): array
  {
    return $this->cart;
  }

  public function getTotal(): float
  {
    return $this->total;
  }

  public function saveToSession(): void
  {
    Session::put($this->sessionKey, $this->cart);
  }

  public function loadFromSession(): void
  {
    $this->cart = Session::get($this->sessionKey, []);
    $this->calculateTotal();
  }

  protected function dispatchCartUpdated(): void {}

  public function addToCart(Product $product): void
  {
    try {
      if ($product->stock < 1) {
        throw new Exception('Stok produk habis');
      }

      $existingIndex = $this->findCartItemIndex($product->id);


      if ($existingIndex !== false) {
        $this->handleExistingCartItem($existingIndex, $product);
      } else {
        $this->addNewCartItem($product);
      }

      $product->decrement('stock');
      $this->calculateTotal();
      $this->saveToSession();
      $this->dispatchCartUpdated();
    } catch (Exception $e) {
      Log::error('Failed to add product to cart: ' . $e->getMessage());
    }
  }

  public function removeFromCart(int $index): void
  {
    try {
      if (!isset($this->cart[$index])) {
        return;
      }

      $product = Product::find($this->cart[$index]['product_id']);
      if (!$product) {
        throw new Exception('Produk tidak ditemukan');
      }

      $product->increment('stock', $this->cart[$index]['qty']);

      unset($this->cart[$index]);
      $this->cart = array_values($this->cart);
      $this->calculateTotal();
      $this->saveToSession();
      $this->dispatchCartUpdated();
    } catch (Exception $e) {
      Log::error('Failed to remove item from cart: ' . $e->getMessage());
      throw $e;
    }
  }

  public function updateQuantity(int $index, int $change): void
  {
    try {
      if (!isset($this->cart[$index])) {
        throw new Exception('Item keranjang tidak valid');
      }

      $newQty = $this->cart[$index]['qty'] + $change;

      if ($newQty < 1) {
        $this->removeFromCart($index);
        return;
      }

      $product = Product::find($this->cart[$index]['product_id']);
      if (!$product) {
        throw new Exception('Produk tidak ditemukan');
      }

      if ($change > 0 && $product->stock < 1) {
        throw new Exception('Stok produk habis');
      }

      $this->adjustProductStock($product, $change);

      $this->cart[$index]['qty'] = $newQty;
      $this->cart[$index]['total_price'] = $newQty * $this->cart[$index]['price'];
      $this->calculateTotal();
      $this->saveToSession();
      $this->dispatchCartUpdated();
    } catch (Exception $e) {
      Log::error('Failed to update cart quantity: ' . $e->getMessage());
      throw $e;
    }
  }

  public function clearCart(): void
  {
    try {
      foreach ($this->cart as $item) {
        $product = Product::find($item['product_id']);
        if ($product) {
          $product->increment('stock', $item['qty']);
        }
      }

      $this->cart = [];
      $this->total = 0;
      $this->saveToSession();
      $this->dispatchCartUpdated();
    } catch (Exception $e) {
      Log::error('Failed to clear cart: ' . $e->getMessage());
      throw $e;
    }
  }


  protected function handleExistingCartItem(int $index, Product $product): void
  {
    try {
      if ($product->stock <= $this->cart[$index]['qty']) {
        throw new Exception('Stok tidak mencukupi');
      }

      $this->cart[$index]['qty']++;
      $this->cart[$index]['total_price'] = $this->cart[$index]['qty'] * $product->price;
    } catch (Exception $e) {
      Log::error('Failed to handle existing cart item: ' . $e->getMessage());
      throw $e;
    }
  }

  protected function adjustProductStock(Product $product, int $change): void
  {
    try {
      if ($change > 0) {
        $product->decrement('stock');
      } else {
        $product->increment('stock');
      }
    } catch (Exception $e) {
      Log::error('Failed to adjust product stock: ' . $e->getMessage());
      throw new Exception('Gagal mengupdate stok produk');
    }
  }

  protected function findCartItemIndex(int $productId)
  {
    foreach ($this->cart as $index => $item) {
      if ($item['product_id'] == $productId) {
        return $index;
      }
    }
    return false;
  }



  protected function addNewCartItem(Product $product): void
  {
    $this->cart[] = [
      'product_id' => $product->id,
      'name' => $product->name,
      'price' => $product->price,
      'qty' => 1,
      'total_price' => $product->price,
    ];
  }


  protected function calculateTotal(): void
  {
    $this->total = array_reduce($this->cart, function ($carry, $item) {
      return $carry + $item['total_price'];
    }, 0);
  }
}
