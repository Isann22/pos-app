<?php

namespace App\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Services\CartService;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

class Pos extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategoryId = null;



    public $showPaymentModal = false;
    public $showCashPaymentModal = false;
    public $paymentType = 'cash';
    public $cashGiven = 0;
    public $changeAmount = 0;


    public $errorMessage = '';
    public $successMessage = '';

    protected $listeners = ['cartUpdated' => 'saveCartToSession'];

    //Cart
    protected CartService $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function addToCart(Product $product)
    {
        try {
            if ($product->stock < 1) {
                throw new \Exception('Maaf, stok produk ini telah habis');
            }
            $this->cartService->addToCart($product);

            $this->dispatch('cartUpdated');
            Toaster::success('Produk berhasil ditambahkan ke keranjang');
        } catch (\Exception $e) {
            Toaster::error($e->getMessage());
            $this->addError('cart', $e->getMessage());
        }
    }

    public function removeFromCart($index)
    {
        try {
            $this->cartService->removeFromCart($index);
            $this->dispatch('cartUpdated');
            Toaster::info('Produk dihapus dari keranjang');
        } catch (\Exception $e) {
            Toaster::error(
                $e->getMessage()
            );
            $this->addError('cart', $e->getMessage());
        }
    }

    public function updateQuantity($index, $change)
    {
        try {
            $this->cartService->updateQuantity($index, $change);
            $this->dispatch('cartUpdated');
        } catch (\Exception $e) {
            Toaster::error(
                $e->getMessage()
            );
            $this->addError('quantity', $e->getMessage());
        }
    }

    public function clearCart()
    {
        try {
            $this->cartService->clearCart();
            $this->dispatch('cartUpdated');
            Toaster::info("keranjang berhasil dikosongkan");
        } catch (\Exception $e) {
            Toaster::error(
                $e->getMessage()
            );
            $this->addError('cart', $e->getMessage());
        }
    }

    public function openPaymentModal()
    {
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
    }

    public function processPaymentType()
    {
        if ($this->paymentType === 'cash') {
            $this->showPaymentModal = false;
            $this->showCashPaymentModal = true;
            $this->cashGiven = $this->cartService->getTotal();
            $this->calculateChange();
        } else {
            $this->processNonCashPayment();
        }
    }



    public function processCashPayment()
    {

        if ($this->cashGiven < $this->cartService->getTotal()) {
            $this->errorMessage = 'Uang yang diberikan kurang dari total pembayaran';
            return;
        }

        $this->showCashPaymentModal = false;
        $this->cashGiven = 0;
        $this->changeAmount = 0;
        $this->clearCart();
    }

    public function calculateChange()
    {
        if (is_numeric($this->cashGiven)) {
            $this->changeAmount = max(0, $this->cashGiven - $this->cartService->getTotal());
        } else {
            $this->changeAmount = 0;
        }
    }



    public function filterByCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    public function resetCategoryFilter()
    {
        $this->selectedCategoryId = null;
    }


    #[Title('Sales')]
    public function render()
    {
        $products = Product::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->selectedCategoryId, fn($query) => $query->where('category_id', $this->selectedCategoryId))
            ->paginate(9);

        return view('livewire.pos.pos', [
            'products'    => $products,
            'categories'  => Category::all(),
            'cart'        => $this->cartService->getCart(),
            'total'       => $this->cartService->getTotal(),
        ]);
    }
}
