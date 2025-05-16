<?php

namespace App\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Pos extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategoryId = null;
    public $cart = [];
    public $total = 0;

    public $showPaymentModal = false;

    public $showCashPaymentModal = false;

    public $paymentType = 'cash';
    public $cashGiven = 0;
    public $changeAmount = 0;


    public $errorMessage = '';
    public $successMessage = '';

    protected $listeners = ['cartUpdated' => 'saveCartToSession'];

    public function calculateChange()
    {
        if (is_numeric($this->cashGiven)) {
            $this->changeAmount = max(0, $this->cashGiven - $this->total);
        } else {
            $this->changeAmount = 0;
        }
    }



    public function processPaymentType()
    {
        if ($this->paymentType === 'cash') {
            $this->showPaymentModal = false;
            $this->showCashPaymentModal = true;
            $this->cashGiven = $this->total;
            $this->calculateChange();
        } else {
            $this->processNonCashPayment();
        }
    }

    public function processCashPayment()
    {

        if ($this->cashGiven < $this->total) {
            $this->errorMessage = 'Uang yang diberikan kurang dari total pembayaran';
            return;
        }



        $this->showCashPaymentModal = false;
        $this->cashGiven = 0;
        $this->changeAmount = 0;
        $this->clearCart();
    }



    public function openPaymentModal()
    {
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
    }


    public function addToCart(Product $product)
    {

        if ($product->stock < 1) {
            $this->dispatch('show-toast', type: 'error', message: 'Stok produk habis');
            return;
        }

        $existingIndex = collect($this->cart)->search(function ($item) use ($product) {
            return $item['product_id'] == $product->id;
        });

        if ($existingIndex !== false) {

            if ($product->stock <= $this->cart[$existingIndex]['qty']) {
                $this->dispatch('show-toast', type: 'error', message: 'Stok tidak mencukupi');
                return;
            }

            $this->cart[$existingIndex]['qty']++;
            $this->cart[$existingIndex]['total_price'] = $this->cart[$existingIndex]['qty'] * $product->price;
        } else {
            $this->cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
                'total_price' => $product->price,
                'image' => $product->image ?? null
            ];
        }


        $product->decrement('stock');
        $this->calculateTotal();
        $this->dispatch('cartUpdated');
    }

    public function removeFromCart($index)
    {
        if (isset($this->cart[$index])) {

            $product = Product::find($this->cart[$index]['product_id']);
            $product->increment('stock', $this->cart[$index]['qty']);

            unset($this->cart[$index]);
            $this->cart = array_values($this->cart);
            $this->calculateTotal();
            $this->dispatch('cartUpdated');
        }
    }

    public function updateQuantity($index, $change)
    {
        $newQty = $this->cart[$index]['qty'] + $change;

        if ($newQty < 1) {
            $this->removeFromCart($index);
            return;
        }

        $product = Product::find($this->cart[$index]['product_id']);

        if ($change > 0 && $product->stock < 1) {
            return;
        }


        if ($change > 0) {
            $product->decrement('stock');
        } else {
            $product->increment('stock');
        }

        $this->cart[$index]['qty'] = $newQty;
        $this->cart[$index]['total_price'] = $newQty * $this->cart[$index]['price'];
        $this->calculateTotal();
        $this->dispatch('cartUpdated');
    }

    protected function calculateTotal()
    {
        $this->total = collect($this->cart)->sum('total_price');
    }

    public function clearCart()
    {

        foreach ($this->cart as $item) {
            $product = Product::find($item['product_id']);
            $product->increment('stock', $item['qty']);
        }

        $this->cart = [];
        $this->total = 0;

        $this->dispatch('cartUpdated');
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    public function resetCategoryFilter()
    {
        $this->selectedCategoryId = null;
    }

    public function mount()
    {
        $this->loadCartFromSession();
    }

    public function saveCartToSession()
    {
        session(['pos_cart' => $this->cart]);
    }

    public function loadCartFromSession()
    {
        if (session()->has('pos_cart')) {
            $this->cart = session('pos_cart');
            $this->calculateTotal();
        }
    }

    #[Title('Sales')]
    public function render()
    {
        $products = Product::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->when($this->selectedCategoryId, function ($query) {
                $query->where('category_id', $this->selectedCategoryId);
            })->paginate(9);

        return view('livewire.pos.pos', [
            'products' => $products,
            'categories' => Category::all(),
            'total' => $this->total
        ]);
    }
}
