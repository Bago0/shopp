<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckForStaleOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-for-stale-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $staleOrders = Order::where('status', 'new')
            ->whereDate('created_at', '<=', $now->subDays(2))
            ->get();
        foreach ($staleOrders as $order) {
            $order->status = 'stale';
            $order->save();
            $this->info('Order ID ' . $order->id . ' status updated to "stale".');
        }

        $this->info('Stale orders check completed.');
    }
}
