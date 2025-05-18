<?php

namespace App\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Services\CartService;
use App\Services\OrderService;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;


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

    protected $listeners = ['print-receipt' => 'handlePrintReceipt'];


    protected OrderService $orderService;


    protected CartService $cartService;


    public function boot(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    /* --------------------------
    |  Cart Methods
    ---------------------------*/
    public function addToCart(Product $product)
    {
        try {
            if ($product->stock < 1) {
                throw new \Exception('Maaf, stok produk ini telah habis');
            }
            $this->cartService->addToCart($product);

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
            Toaster::info("keranjang berhasil dikosongkan");
        } catch (\Exception $e) {
            Toaster::error(
                $e->getMessage()
            );
            $this->addError('cart', $e->getMessage());
        }
    }

    /* --------------------------
    |  Payment Methods
    ---------------------------*/

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
        $this->paymentType === 'cash'
            ? $this->prepareCashPayment()
            : $this->processNonCashPayment();
    }

    protected function prepareCashPayment()
    {
        $this->showPaymentModal = false;
        $this->showCashPaymentModal = true;
        $this->cashGiven = $this->cartService->getTotal();
        $this->calculateChange();
    }

    public function processCashPayment()
    {

        if ($this->cashGiven < $this->cartService->getTotal()) {
            $this->errorMessage = 'Uang yang diberikan kurang dari total pembayaran';
            return;
        }


        try {
            $order = $this->orderService->processCashOrder(
                $this->cartService->getCart(),
                $this->cashGiven,
                Auth::user()->name
            );

            $this->completePayment($order);
        } catch (\Exception $e) {
            $this->errorMessage = 'Pembayaran gagal';
            Toaster::error($this->errorMessage);
        }
    }

    protected function completePayment($order)
    {
        $this->resetPaymentModal();
        $this->cartService->clearCart();
        $this->dispatch('print-receipt', orderId: $order->id);
        Toaster::success("Transaksi #" . substr($order->id, 0, 8) . " berhasil");
    }




    /* --------------------------
    |  helper
    ---------------------------*/
    public function calculateChange()
    {
        if (is_numeric($this->cashGiven)) {
            $this->changeAmount = max(0, $this->cashGiven - $this->cartService->getTotal());
        } else {
            $this->changeAmount = 0;
        }
    }

    public function resetPaymentModal()
    {
        $this->reset([
            'showPaymentModal',
            'showCashPaymentModal',
            'paymentType',
            'cashGiven',
            'changeAmount',
            'errorMessage'
        ]);
    }

    /* --------------------------
    |  Filter Methods
    ---------------------------*/
    public function filterByCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    public function resetCategoryFilter()
    {
        $this->selectedCategoryId = null;
    }

    public function handlePrintReceipt($orderId) {}


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
