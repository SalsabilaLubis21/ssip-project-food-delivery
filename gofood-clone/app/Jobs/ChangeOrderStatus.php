<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class ChangeOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;
    protected $newStatus;
    protected $newDeliveryStatus;

    /**
     * Create a new job instance.
     *
     * @param int $orderId
     * @param string $newStatus
     * @param string $newDeliveryStatus
     * @return void
     */
    public function __construct($orderId, $newStatus, $newDeliveryStatus)
    {
        $this->orderId = $orderId;
        $this->newStatus = $newStatus;
        $this->newDeliveryStatus = $newDeliveryStatus;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $order = Order::find($this->orderId);
            
            if (!$order) {
                Log::warning("Order #{$this->orderId} not found in status change job");
                return;
            }
            
            // Jangan ubah jika sudah dibatalkan
            if ($order->status === 'canceled') {
                Log::info("Order #{$this->orderId} is already canceled, skipping status change to {$this->newStatus}");
                return;
            }
            
            $order->status = $this->newStatus;
            $order->delivery_status = $this->newDeliveryStatus;
            $order->save();
            
            Log::info("Job: Order #{$this->orderId} status successfully updated to {$this->newStatus}");
            
            // Broadcast event untuk WebSocket jika diimplementasikan
            // event(new OrderStatusChanged($order));
            
        } catch (\Exception $e) {
            Log::error("Error changing order #{$this->orderId} status: " . $e->getMessage());
        }
    }
}