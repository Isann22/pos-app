<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\App;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProductOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total = $this->getTotalProducts();
        $stok = $this->getTotalStock();


        return [
            Stat::make('Total Produk', Number::abbreviate($total))
                ->icon('heroicon-o-shopping-bag')
                ->color('success'),
            Stat::make('Total Stok Produk', Number::abbreviate($stok))
                ->icon('heroicon-o-queue-list')
                ->color('success'),
        ];
    }

    // Helper methods
    protected function getTotalProducts(): int
    {
        return Product::count();
    }

    protected function getTotalStock()
    {
        return Product::count('stock');
    }
}
