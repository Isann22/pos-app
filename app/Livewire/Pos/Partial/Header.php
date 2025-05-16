<?php

namespace App\Livewire\Pos\Partial;

use App\Models\Product;
use Livewire\Component;

class Header extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.pos.partial.header', [
            'products' => Product::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
                ->get(),
        ]);
    }
}
