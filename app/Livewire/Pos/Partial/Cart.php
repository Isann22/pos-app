<?php

namespace App\Livewire\Pos\Partial;

use Livewire\Component;

class Cart extends Component
{
    public $isOpen = false;
    public $cartItems = [];
    public $total = 0;

    protected $listeners = [
        'toggleCart' => 'toggle',
        'addToCart' => 'addItem',
        'cartUpdated' => 'updateCart'
    ];

    public function mount()
    {
        // Initialize with dummy data for UI
        $this->cartItems = [
            [
                'id' => 1,
                'name' => 'Bunga Mawar Merah',
                'price' => 25000,
                'quantity' => 2,
                'image' => asset('images/placeholder-flower.jpg')
            ],
            [
                'id' => 2,
                'name' => 'Rangkaian Bunga Meja',
                'price' => 120000,
                'quantity' => 1,
                'image' => asset('images/placeholder-arrangement.jpg')
            ]
        ];
        $this->calculateTotal();
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function addItem($item)
    {
        // For UI demonstration only
        $this->cartItems[] = $item;
        $this->calculateTotal();
        $this->isOpen = true;
    }

    public function updateCart($items)
    {
        $this->cartItems = $items;
        $this->calculateTotal();
    }

    public function increment($index)
    {
        $this->cartItems[$index]['quantity']++;
        $this->calculateTotal();
    }

    public function decrement($index)
    {
        if ($this->cartItems[$index]['quantity'] > 1) {
            $this->cartItems[$index]['quantity']--;
            $this->calculateTotal();
        }
    }

    public function removeItem($index)
    {
        unset($this->cartItems[$index]);
        $this->cartItems = array_values($this->cartItems);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = array_reduce($this->cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function render()
    {
        return view('livewire.pos.partial.cart');
    }
}
