<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\OrderDetail; 
use App\Models\Menu; 
use App\Models\Restaurant; 
use App\Models\Driver; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log; 



class OrderController extends Controller
{

    
    /**
     * Store a new order (typically called by a customer user).
     * Rute: /orders (POST)
     * Middleware: auth (diasumsikan)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

     
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|numeric',
            'payment_method' => 'required|string',
            'payment_total' => 'required_without:total_price|numeric|min:1',
            'total_price' => 'required_without:payment_total|numeric|min:1',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'driver_name' => 'required|string',
            'vehicle_plate' => 'required|string',
            'delivery_type' => 'required|string',
            'delivery_cost' => 'required|numeric',
            'delivery_address' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            
            if (!Auth::check()) {
                return response()->json(['error' => 'You must be logged in to place an order.'], 401);
            }

            
            $driver = Driver::where('vehicle_plate', $request->vehicle_plate)->first();
            
            if (!$driver) {
                $driver = new Driver();
                $driver->name = $request->driver_name;
                $driver->vehicle_plate = $request->vehicle_plate;
                $driver->save();
            }
            
            // Get driver ID
            $driverId = $driver->driver_id;
            Log::info('Using driver ID: ' . $driverId);

            
            $order = new Order();
            $order->user_id = Auth::id();
            $order->restaurant_id = $request->restaurant_id;
            $order->status = 'pending';
            $order->payment_method = $request->payment_method;
            $order->payment_total = $request->total_price ?? $request->payment_total;
            $order->order_time = now();
            $order->delivery_driver_id = $driverId;
            $order->delivery_type = $request->delivery_type;
            $order->delivery_cost = $request->delivery_cost;
            $order->delivery_address = $request->delivery_address;
            $order->payment_status = 'successful'; 
            $order->delivery_status = 'pending'; 
            $order->save();

            Log::info('Order created with ID: ' . $order->order_id . ' and delivery_driver_id: ' . $order->delivery_driver_id);

            
            foreach ($request->items as $item) {
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            DB::commit();
            Log::info('Order placed successfully, returning JSON response.');
            return response()->json(['success' => true, 'order_id' => $order->order_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error placing order: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to place order: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the currently logged-in user's orders.
     * Rute: /orders (GET)
     * Middleware: auth (diasumsikan)
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        
         if (!Auth::check()) {
            Log::warning('Unauthorized access to user order list - no user logged in.');
            
            return redirect()->route('login')->withErrors(['error' => 'You must be logged in to view orders.']);
        }

        
        $orders = Order::with(['restaurant', 'user', 'driver', 'items.menu'])
                    ->where('user_id', Auth::id()) 
                    ->orderBy('order_time', 'desc') 
                    ->get();

        Log::info('User order list accessed', [
            'user_id' => Auth::id(),
            'order_count' => $orders->count()
        ]);

        
        return view('orders.index', compact('orders'));
    }


    /**
     * Cancel a pending or processing order (for customer user).
     * Rute: /orders/{order}/cancel (POST) - Menggunakan Route Model Binding {order} disarankan
     * Middleware: auth (diasumsikan)
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Order  $order - Laravel otomatis menemukan Order berdasarkan route parameter {order}
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function cancelOrder(Request $request, Order $order) 
{    
    
    Log::info('Checking user role and order ownership', [
        'User ID' => Auth::id(),
        'User Role' => Auth::user()->role ?? 'Tidak Terbaca',
        'Order ID' => $order->order_id ?? 'N/A',
        'Order Owner ID' => $order->user_id ?? 'N/A',
    ]);

    if (!Auth::check()) {
        Log::warning('Unauthorized attempt to cancel order - no user logged in.');
        return redirect()->route('login')->withErrors(['error' => 'You must be logged in to cancel an order.']);
    }

    // Pastikan hanya user yang bisa membatalkan pesanan
    if (Auth::user()->role !== 'user') {
        Log::warning('User with wrong role attempted cancellation', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role
        ]);
        return back()->withErrors(['error' => 'Only users can cancel orders.']);
    }

    
    if ((int) $order->user_id !== (int) Auth::id()) {
        Log::warning('User attempted to cancel order not belonging to them', [
            'user_id' => Auth::id(),
            'order_id_attempt' => $order->order_id,
            'user_role' => Auth::user()->role
        ]);
        abort(403, 'You do not have permission to cancel this order.');
    }

  
    if (!in_array(strtolower(trim($order->status)), ['pending', 'in process'])) {
        Log::warning('User attempted to cancel order with status: ' . $order->status, [
            'user_id' => Auth::id(),
            'order_id' => $order->order_id
        ]);
        return back()->withErrors(['error' => 'The order has been processed and cannot be canceled. (status: ' . $order->status . ').']);
    }
    
    try {
        // Ubah status pesanan menjadi 'Cancelled'
        $order->status = 'Cancelled';
        $order->save();

        Log::info('Order successfully cancelled by user', [
            'order_id' => $order->order_id,
            'user_id' => Auth::id()
        ]);

        return back()->with('success', 'The order has been successfully canceled.');
    } catch (\Exception $e) {
        Log::error('Error canceling order: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'order_id' => $order->order_id ?? 'N/A',
            'trace' => $e->getTraceAsString()
        ]);
        return back()->withErrors(['error' => 'Terjadi kesalahan saat membatalkan pesanan: ' . $e->getMessage()]);
    }
}


    /**
     * Display the user's order history (completed, delivered, cancelled).
     * Rute: /orders/history (GET)
     * Middleware: auth (diasumsikan)
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function history()
    {
         // Middleware 'auth' di rute seharusnya sudah memastikan user login.
         if (!Auth::check()) {
             Log::warning('Unauthorized access to user order history - no user logged in.');
            return redirect()->route('login')->withErrors(['error' => 'You must be logged in to view order history.']);
        }

        
        $completedOrders = Order::with(['user', 'restaurant', 'driver', 'items.menu']) 
                    ->where('user_id', Auth::id()) 
               
                    ->whereIn('status', ['Delivered', 'Cancelled'])
                    ->orderBy('order_time', 'desc') 
                    ->get();

        Log::info('User order history accessed', [
            'user_id' => Auth::id(),
            'history_count' => $completedOrders->count()
        ]);

        
        return view('orders.history', compact('completedOrders'));
    }


    public function checkout(Request $request)
{
    $order = Order::create([
        'user_id' => auth()->id(),
        'restaurant_id' => $request->restaurant_id,
        'total_price' => $request->total_price,
        'status' => 'pending'
    ]);

    foreach ($request->menus as $menu) {
        OrderDetail::create([
            'order_id' => $order->id,
            'menu_id' => $menu['id'],
            'quantity' => $menu['quantity'],
            'price' => $menu['price']
        ]);
    }

    return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
}

    public function show($orderId)
    {
        // Ambil pesanan berdasarkan ID beserta detail menu
        $order = Order::with('orderdetail.menu')->where('order_id', $orderId)->first();

    
        // Cek apakah pesanan ditemukan
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }
    
        return view('orders.show', compact('order'));
    }
    

    public function process(Request $request, Order $order)
{
    // Tambahkan log untuk debugging
    Log::info('Processing order:', ['order_id' => $order->order_id]);
   // Periksa apakah order berada dalam status yang valid untuk diproses
  
    if (!in_array(strtolower(trim($order->status)), ['pending', 'in process'])) {
        
        
        return back()->withErrors(['error' => 'Pesanan tidak dapat diproses karena statusnya bukan Pending (saat ini: ' . $order->status . ').']);
    }
    // Periksa apakah order berada dalam status yang valid untuk diproses
    if (!in_array(strtolower(trim($order->status)), ['pending', 'in process'])) {
        
        
        return back()->withErrors(['error' => 'Pesanan tidak dapat diproses karena statusnya bukan Pending (saat ini: ' . $order->status . ').']);
    }
    
    
    // Update status order
    $order->status = 'In Process';
    $order->save();

    return redirect()->route('restaurant.dashboard')
                     ->with('success', 'Order successfully processed.');
}





    // --- Method untuk Driver Dashboard ---

    /**
     * Mark an order as On The Way (accept job by driver).
     * Rute: /driver/orders/{order}/on-the-way (POST)
     * Middleware: auth.driver (diasumsikan)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order - Laravel otomatis menemukan Order berdasarkan route parameter {order}
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markOnTheWay(Request $request, Order $order)
    {
        // Middleware 'auth.driver' di rute seharusnya sudah memastikan driver login.
        $driverUser = Auth::guard('driver')->user();

        // Hanya driver yang terautentikasi yang bisa memanggil method ini (double check)
        if (!$driverUser) {
             Log::warning('Unauthorized attempt to mark order On The Way - no driver logged in.');
             // Menggunakan abort(403) lebih standar
             abort(403, 'Unauthorized action.'); // Forbidden
        }

        if ($order->status === 'In Process' && is_null($order->delivery_driver_id)) {
            try {
                 // Assign driver yang sedang login ke pesanan
                $order->delivery_driver_id = $driverUser->driver_id; // Menggunakan primary key dari model Driver
                $order->status = 'On The Way'; // Ubah status
                $order->assigned_at = now(); // Opsional: simpan waktu driver menerima
                $order->save();

                Log::info('Order assigned to driver and status changed to On The Way', [
                    'order_id' => $order->order_id,
                    'driver_id' => $driverUser->driver_id
                ]);
                return back()->with('success', 'Pesanan berhasil diterima! Status berubah menjadi On The Way.');

            } catch (\Exception $e) {
                Log::error('Error marking order On The Way: ' . $e->getMessage(), [
                    'order_id' => $order->order_id,
                    'driver_id' => $driverUser->driver_id,
                    'trace' => $e->getTraceAsString()
                ]);
                 return back()->with('error', 'Terjadi kesalahan saat menerima pesanan.');
            }

        } else {
            Log::warning('Driver attempted to accept order with invalid status or assignment', [
                'order_id' => $order->order_id,
                'driver_id' => $driverUser->driver_id,
                'current_status' => $order->status,
                'current_driver_id' => $order->delivery_driver_id
            ]);
            // Jika status tidak valid atau sudah di-assign
            return back()->with('error', 'Tidak dapat menerima pesanan. Status tidak valid atau sudah di-assign ke driver lain.');
        }
    }

    /**
     * Mark an order as Delivered (by driver).
     * Rute: /driver/orders/{order}/deliver (POST)
     * Middleware: auth.driver (diasumsikan)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order - 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deliverOrder(Request $request, Order $order)
    {
        
        $driverUser = Auth::guard('driver')->user();

         
        if (!$driverUser) {
            Log::warning('Unauthorized attempt to mark order Delivered - no driver logged in.');
            abort(403, 'Unauthorized action.'); // Forbidden
        }


        if ($order->delivery_driver_id === $driverUser->driver_id && $order->status === 'On The Way') {
            try {
                $order->status = 'Delivered'; // Ubah status akhir menjadi 'Delivered'
                $order->delivered_at = now(); // Opsional: simpan waktu delivered
               
                $order->save();

                Log::info('Order status changed from On The Way to Delivered by driver', [
                    'order_id' => $order->order_id,
                    'driver_id' => $driverUser->driver_id
                ]);
                return back()->with('success', 'Pesanan berhasil ditandai sebagai Delivered!');

            } catch (\Exception $e) {
                Log::error('Error marking order Delivered: ' . $e->getMessage(), [
                    'order_id' => $order->order_id,
                    'driver_id' => $driverUser->driver_id,
                    'trace' => $e->getTraceAsString()
                ]);
                 return back()->with('error', 'Terjadi kesalahan saat menandai pesanan.');
            }


        } else {
             Log::warning('Driver attempted to mark order as delivered with invalid status or assignment', [
                'order_id' => $order->order_id,
                'driver_id' => $driverUser->driver_id,
                'order_driver_id' => $order->delivery_driver_id,
                'order_status' => $order->status
            ]);
           
            return back()->with('error', 'Tidak dapat menandai pesanan sebagai Delivered. Status tidak valid atau bukan pesanan Anda.');
        }
    }

    

    public function getOrdersByRestaurant()
{
    $restaurant = Auth::guard('restaurant')->user();

    if (!$restaurant) {
        return response()->json(['error' => 'Restaurant not authenticated'], 401);
    }

    $orders = Order::where('restaurant_id', $restaurant->restaurant_id)
                   ->whereNotIn('status', ['Delivered', 'Cancelled'])
                   ->latest()
                   ->get();

    return response()->json($orders);
}

}

