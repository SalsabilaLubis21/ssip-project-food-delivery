<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AutoProcessOrderController extends Controller
{
    /**
     * Automatically process and deliver orders
     * This method can be triggered via a cron job or called after order creation
     */
    public function autoProcessOrders()
    {
        try {
            // Get all pending orders
            $pendingOrders = Order::where('status', 'pending')->get();
            
            foreach ($pendingOrders as $order) {
                // Update order status to processing
                $order->status = 'processing';
                $order->save();
                
                Log::info("Order #{$order->order_id} automatically updated to processing");
                
                // Simulate processing time (5 seconds in this example)
                // Note: In production, you'd remove this line as this would run asynchronously
                // sleep(5);
                
                // Then update to delivered
                $order->status = 'delivered';
                $order->delivery_status = 'delivered';
                $order->save();
                
                Log::info("Order #{$order->order_id} automatically updated to delivered");
            }
            
            return ['success' => true, 'message' => count($pendingOrders) . ' orders processed automatically'];
        } catch (\Exception $e) {
            Log::error('Error in automatic order processing: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Process a single order immediately after creation
     * This can be called directly after order is created
     */
    public function processNewOrder($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            if ($order->status !== 'pending') {
                return ['success' => false, 'message' => 'Order is not in pending status'];
            }
            
            // Update to processing immediately
            $order->status = 'processing';
            $order->save();
            
            Log::info("New order #{$order->order_id} automatically updated to processing");
            
            // Schedule delivery after X minutes (simulate delivery time)
            // In a real app, this would be done with a queue job
            
            // For demo purpose, we'll update immediately
            $order->status = 'delivered';
            $order->delivery_status = 'delivered';
            $order->save();
            
            Log::info("New order #{$order->order_id} automatically updated to delivered");
            
            return ['success' => true, 'message' => "Order #{$orderId} processed and delivered automatically"];
        } catch (\Exception $e) {
            Log::error('Error processing new order: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}