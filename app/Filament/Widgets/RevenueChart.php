<?php

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
  protected static ?int $sort = 2;
  protected static ?string $heading = 'Revenue by Payment Method';
  protected static ?string $maxHeight = '250px';

  protected function getData(): array
  {
    $cashOrders = Order::where('payment_method', 'cash')->count();
    $cashRevenue = Order::where('payment_method', 'cash')->sum('total');

    $nonCashOrders = Order::where('payment_method', '!=', 'cash')->count();
    $nonCashRevenue = Order::where('payment_method', '!=', 'cash')->sum('total');

    return [
      'datasets' => [
        [
          'label' => 'Revenue (Rp)',
          'data' => [$cashRevenue, $nonCashRevenue],
          'backgroundColor' => ['#4CAF50', '#2196F3'],
          'borderColor' => ['#388E3C', '#1976D2'],
        ],
      ],
      'labels' => [
        "Cash ($cashOrders orders)",
        "Non-Cash ($nonCashOrders orders)"
      ],
    ];
  }

  protected function getType(): string
  {
    return 'bar'; // Tipe chart bar untuk perbandingan jelas
  }
}
