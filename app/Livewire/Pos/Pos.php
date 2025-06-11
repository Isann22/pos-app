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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Pos extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategoryId = null;


    public $showPaymentModal = false;
    public $showCashPaymentModal = false;
    public $showNonCashPaymentModal = false;
    public $paymentType = 'cash';
    public $cashGiven = 0;
    public $changeAmount = 0;
    public $snapToken = "";
    public $status = "";

    public $errorMessage = '';


    protected $listeners = ['print-receipt' => 'handlePrintReceipt'];


    protected OrderService $orderService;
    protected CartService $cartService;


    public function boot(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }


    /* --------------------------
    |  Cart
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
        } catch (\Exception $e) {
            Toaster::error(
                "gagal menghapus item"
            );
            $this->addError('cart', $e->getMessage());
        }
    }

    /* --------------------------
    |  Payment 
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
            : $this->prepareNonCashPayment();
    }

    /* --------------------------
    |  Payment Cash
    ---------------------------*/
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
            DB::beginTransaction();

            $order = $this->orderService->processCashOrder(
                $this->cartService->getCart(),
                $this->cashGiven,
                Auth::user()->name
            );


            $this->resetPaymentModal($order);
            $this->clearCart();
            DB::commit();
            Toaster::success('Pembayaran tunai berhasil diproses');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
            Toaster::error($this->errorMessage);
        }
    }

    /* --------------------------
    |  Payment Non Cash
    ---------------------------*/
    protected function prepareNonCashPayment()
    {
        $this->showPaymentModal = false;
        $this->showNonCashPaymentModal = true;
        $this->cashGiven = $this->cartService->getTotal();
        $this->calculateChange();
    }

    public function processMidtransPayment()
    {
        try {
            DB::beginTransaction();
            $order = $this->orderService->processMidtransOrder(
                $this->cartService->getCart(),
                Auth::user()->name
            );
            $this->dispatch('token', token: $order->midtrans_snap_token);
            $this->status = $order->status;
            $this->resetPaymentModal($order);
            $this->clearCart();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
            Toaster::error($this->errorMessage);
        }
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
            'showNonCashPaymentModal',
            'paymentType',
            'cashGiven',
            'changeAmount',
            'errorMessage',
        ]);
    }


    /* --------------------------
    |  Filter 
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


    /* --------------------------
    |  render
    ---------------------------*/
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
