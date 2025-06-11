<?php

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InventoryStats extends BaseWidget
{
  protected function getStats(): array
  {
    $criticalProducts = Product::where('stock', '<', 5)->count();
    $totalProducts = Product::count();
    $stockStatus = $criticalProducts > 0 ? 'kritis' : 'aman';

    return [
      Stat::make(
        label: $criticalProducts > 0 ? 'Perhatian! Stok Kritis' : 'Stok Aman',
        value: $criticalProducts > 0
          ? "$criticalProducts produk perlu restock"
          : "Semua produk aman"
      )
        ->description($criticalProducts > 0
          ? "Segera tambahkan stok untuk $criticalProducts produk"
          : "Tidak ada produk dengan stok kritis")
        ->color($criticalProducts > 0 ? 'danger' : 'success')
        ->icon($criticalProducts > 0
          ? 'heroicon-o-shield-exclamation'
          : 'heroicon-o-check-badge'),

      Stat::make('Total Produk', $totalProducts . ' produk')
        ->description('Jumlah total produk di sistem')
        ->color('gray')
        ->icon('heroicon-o-rectangle-stack'),

      Stat::make('Stok Terendah', Product::orderBy('stock')->value('name') ?? '-')
        ->description(Product::orderBy('stock')->value('stock') . ' item tersisa')
        ->color('warning')
        ->icon('heroicon-o-arrow-trending-down'),
    ];
  }
}
