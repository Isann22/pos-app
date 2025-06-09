<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders';

    protected function getData(): array
    {

        $ordersData = OrderItem::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(DISTINCT order_id) as order_count'),
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        $orderCounts = array_fill(0, 12, 0);



        foreach ($ordersData as $order) {
            $monthIndex = $order->month - 1; // Convert to 0-based index
            $orderCounts[$monthIndex] = $order->order_count;
            $orderAmounts[$monthIndex] = $order->total_amount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Number of Orders',
                    'data' => $orderCounts,
                    'fill' => 'start',
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
