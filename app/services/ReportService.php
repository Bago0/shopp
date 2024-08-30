<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ReportService implements ReportServiceInterface
{
    public function index(): array
    {
        $cacheKey = 'main_page_summary';

        return Cache::remember($cacheKey, 30 * 60, function () {

            $startOfMonth = Carbon::now()->startOfMonth();
            $productCount = Product::count();
            $ordersThisMonth = Order::whereDate('created_at', '>=', $startOfMonth)->get();
            $totalOrderPrice = $ordersThisMonth->where('status', 'finished')->sum('total_price')/100;
            $activeOrdersCount = $ordersThisMonth->where('status', 'active')->count();
            $newOrdersCount = $ordersThisMonth->where('status', 'new')->count();
            $completedOrdersCount = $ordersThisMonth->where('status', 'finished')->count();
            $rejectedOrdersCount = $ordersThisMonth->where('status', 'rejected')->count();

            return [
                'productCount' => $productCount,
                'totalOrderPrice' => $totalOrderPrice,
                'activeOrdersCount' => $activeOrdersCount,
                'newOrdersCount' => $newOrdersCount,
                'completedOrdersCount' => $completedOrdersCount,
                'rejectedOrdersCount' => $rejectedOrdersCount,
            ];
        });
    }
}
