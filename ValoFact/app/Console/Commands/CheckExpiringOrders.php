<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;
use App\Http\Controllers\OrderController;

class CheckExpiringOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expiring-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for orders that are expiring';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        // Get orders that are about to expire (within the next 5 minutes)
        if(!empty(Order::all())){
            $expiringOrders = Order::where('end_date', '<=', $now->copy()->addMinutes(5))
            ->where('status', '=', 'available') // Assuming you have an 'expired' status
            ->get();

            foreach ($expiringOrders as $order) {
                $remainingTime = $order->end_date->diffForHumans($now); // Get human-readable remaining time (e.g., "2 minutes from now")

                // Calculate seconds to expiry (for more precise actions)
                $secondsToExpire = $order->end_date->diffInSeconds($now);

                if ($secondsToExpire <= 0) {
                    // Order has expired
                    (new OrderController())->expired($order);

                    // Perform other actions (e.g., send notifications, etc.)
                    //$this->info("Order {$order->id} has expired.");
                }/* else {
                    // Order is about to expire
                    $this->info("Order {$order->id} will expire in {$remainingTime} ({$secondsToExpire} seconds).");
                }*/
            }
        }
        
    }
}
