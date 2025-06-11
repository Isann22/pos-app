<?php

use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class DailySalesChart extends ChartWidget

{
  protected static ?string $heading = 'Daily Sales';
  protected static ?string $maxHeight = '250px';
  protected int | string | array $columnSpan = 'full';
  protected static ?int $sort = 3;

  protected function getData(): array
  {
    $data = Trend::model(Order::class)
      ->between(
        start: now()->subDays(6),
        end: now(),
      )
      ->perDay()
      ->sum('total');

    return [
      'datasets' => [
        [
          'label' => 'Total Penjualan (Rp)',
          'data' => $data->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
          'backgroundColor' => '#4CAF50',
          'borderColor' => '#388E3C',
        ],
      ],
      'labels' => $data->map(function (TrendValue $value) {
        // Ensure the date is a Carbon instance before formatting
        $date = is_string($value->date) ? \Carbon\Carbon::parse($value->date) : $value->date;
        return $date->format('d M');
      })->toArray(),
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }

  protected function getOptions(): array
  {
    return [
      'scales' => [
        'y' => [
          'beginAtZero' => false,
          'ticks' => [
            'callback' => 'function(value) { return "Rp " + value.toLocaleString(); }'
          ],
        ],
      ],
    ];
  }
}
