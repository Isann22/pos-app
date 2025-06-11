<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class BestSellingProductsTable extends TableWidget

{
  protected static ?int $sort = 4;
  protected int | string | array $columnSpan = 'full';

  protected function getTableQuery(): Builder
  {
    return OrderItem::query()
      ->select('product_id', 'product_name')
      ->selectRaw('SUM(quantity) as total_sold')
      ->selectRaw('SUM(subtotal) as total_revenue')
      ->groupBy('product_id', 'product_name')
      ->orderByDesc('total_sold');
  }

  protected function getTableColumns(): array
  {
    return [
      TextColumn::make('product_name')
        ->label('Nama Produk')
        ->searchable()
        ->sortable(),

      TextColumn::make('total_sold')
        ->label('Jumlah Terjual')
        ->numeric()
        ->sortable(),

      TextColumn::make('total_revenue')
        ->label('Total Pendapatan')
        ->numeric()
        ->money('IDR')
        ->sortable(),
    ];
  }

  public function getTableRecordKey($record): string
  {
    return (string) ($record->product_id ?? $record->product_name);
  }

  protected function getTableEmptyStateHeading(): ?string
  {
    return 'Belum ada produk yang terjual';
  }

  protected function getTableEmptyStateDescription(): ?string
  {
    return 'Data produk terlaris akan muncul di sini setelah ada transaksi';
  }
}
