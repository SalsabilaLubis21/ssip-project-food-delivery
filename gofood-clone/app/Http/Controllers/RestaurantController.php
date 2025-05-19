<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log; 
use Illuminate\View\View; 

class RestaurantController extends Controller
{
    
    public function showAppPage()
    {
        $restaurants = Restaurant::take(3)->get(); 
        return view('app', compact('restaurants')); 
    }

    
    public function index()
    {
        $restaurants = Restaurant::all();
        foreach ($restaurants as $restaurant) {
            logger('Restaurant ID: ' . $restaurant->restaurant_id); 
        }
        
        return view('restaurants', compact('restaurants'));
    }

    
    public function show($id)
    {
        // Ambil data restoran berdasarkan ID
        // Pastikan relasi 'reviews' ada di model Restaurant
        $restaurant = Restaurant::with('reviews')->findOrFail($id);

        // Hitung rata-rata rating
        $averageRating = $restaurant->reviews->avg('rating') ?? 0; // Default 0 jika tidak ada ulasan

        
        return view('restaurant_detail', compact('restaurant', 'averageRating'));
    }

    
    public function showReviews($id)
    {
        // Ambil data restoran berdasarkan ID
        $restaurant = Restaurant::findOrFail($id);

        // Ambil data ulasan terkait restoran
        $reviews = $restaurant->reviews()->with('user')->get(); 

    
        return view('restaurant_reviews', compact('restaurant', 'reviews'));
    }

    

    

    /**
     * Show the restaurant dashboard with orders.
     * Rute: /restaurant/dashboard (GET)
     * Middleware: auth:restaurant
     */
    public function dashboard(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        
        $restaurant = Auth::guard('restaurant')->user();

       
        if (!$restaurant) {
             Log::warning('Unauthorized access to restaurant dashboard - no restaurant user logged in.');
             return redirect()->route('restaurant.login'); // Arahkan kembali ke login restaurant
        }

        
        // Mengambil yang statusnya belum Delivered atau Cancelled (masih aktif)
        $orders = Order::where('restaurant_id', $restaurant->restaurant_id)
                       ->whereNotIn('status', ['Delivered', 'Cancelled']) 
                       ->orderBy('status') 
                       ->orderBy('order_time', 'desc') 
                       ->with(['user', 'items.menu']) 
                       ->get();
   

        Log::info('Restaurant dashboard accessed', [
            'restaurant_id' => $restaurant->restaurant_id,
            'order_count' => $orders->count(),
            'ip' => $request->ip()
        ]);

        
        return view('restaurant.dashboard', [
            'restaurant' => $restaurant,
            'orders' => $orders,
        ]);
    }

    /**
     * Process an order (change status from Pending to In Process).
     * Rute: /orders/{order}/process (POST) - Gunakan Route Model Binding
     * Middleware: auth:restaurant
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processOrder(Request $request, Order $order)
    {
        $restaurantUser = Auth::guard('restaurant')->user();

        
        if ($order->restaurant_id !== $restaurantUser->restaurant_id) {
            Log::warning('Restaurant attempted to process order not belonging to them', [
                'restaurant_id' => $restaurantUser->restaurant_id,
                'order_id' => $order->order_id 
            ]);
            
            abort(403, 'Unauthorized action.'); // Forbidden
        }

        
        if ($order->status === 'pending') {
            $order->status = 'In Process'; 
            $order->save();
            Log::info('Order status changed from Pending to In Process by restaurant', ['order_id' => $order->order_id, 'restaurant_id' => $restaurantUser->restaurant_id]);
            return back()->with('success', 'The order has been successfully received and processed.!');
        } else {
            Log::warning('Restaurant attempted to process order with status: ' . $order->status, [
                'order_id' => $order->order_id,
                'restaurant_id' => $restaurantUser->restaurant_id
            ]);
            
            return back()->with('error', 'Pesanan tidak dapat diproses karena statusnya bukan Pending (saat ini: ' . $order->status . ').');
        }
    }

     /**
     * Log the restaurant user out.
     * Rute: /restaurant/logout (POST)
     * Middleware: auth:restaurant
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
     public function logout(Request $request)
     {
         
         Auth::guard('restaurant')->logout();

         
         $request->session()->invalidate();
         $request->session()->regenerateToken();

         Log::info('Restaurant user logged out', ['ip' => $request->ip()]);

         
         return redirect()->route('select.role')->with('message', 'Anda telah berhasil logout sebagai Restaurant Admin.');
     }

     public function showRestaurantDashboard()
     {
         $restaurant = Auth::guard('restaurant')->user();
         
         
         if (!$restaurant) {
             dd("Restaurant user not found. Ensure you are logged in.");
         }
     
         $orders = $restaurant->orders()->latest()->get(); 
     
         dd($restaurant, $orders); 
     
         return view('restaurant.dashboard', compact('restaurant', 'orders'));
     }
     
     
     public function getOrdersByRestaurant()
{
    $restaurant = Auth::guard('restaurant')->user();
    $orders = Order::where('restaurant_id', $restaurant->restaurant_id)
                   ->whereNotIn('status', ['Delivered', 'Cancelled'])
                   ->latest()
                   ->get();
    
    return response()->json($orders);
}

public function history(Request $request)
{
    
    $restaurantUser = Auth::guard('restaurant')->user();

    
    if (!$restaurantUser || !$restaurantUser->restaurant_id) {
       
        return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai restoran.');
    }

    // Ambil data dari $restaurantUser
    $restaurantId = $restaurantUser->restaurant_id;
    
    $restaurant = $restaurantUser->restaurant;

    // Status yang dianggap sebagai riwayat
    $historyStatuses = ['completed', 'cancelled','delivered']; // Sesuaikan jika perlu

    // Ambil data pesanan dari database
    $orders = Order::where('restaurant_id', $restaurantId)
                   ->whereIn('status', $historyStatuses)
                   ->with(['user', 'items']) // Eager load
                   ->orderBy('order_time', 'desc')
                   ->paginate(15); // Pagination

    // Kirim data ke view
    // Pastikan $restaurant tidak null jika view membutuhkannya
    return view('restaurant.history', compact('orders', 'restaurant'));
}



}