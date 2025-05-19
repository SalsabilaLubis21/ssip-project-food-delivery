<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class CheckoutController extends Controller
{

    
    public function index(Request $request)
    {
        
        if (!Auth::check()) {
            // Jika tidak login, arahkan ke halaman login dengan pesan error
            return redirect()->route('login')->withErrors(['error' => 'Silakan login untuk melanjutkan checkout.']);
        }
        
        // ✅ Ambil data keranjang dari session
        $cart = session()->get('cart', [
            'totalPrice' => 0, // Nilai default jika keranjang kosong
            'items' => [] // Nilai default jika tidak ada item
        ]);
        
        // ✅ Dapatkan ID restoran dari item pertama di keranjang (jika ada)
        $restaurantId = null;
        $restaurantName = '';
        
        if (!empty($cart) && isset($cart['items']) && count($cart['items']) > 0) {
            $firstItem = reset($cart['items']);
            $restaurantId = $firstItem['restaurant_id'] ?? null;
            
            if ($restaurantId) {
                $restaurant = Restaurant::find($restaurantId);
                $restaurantName = $restaurant ? $restaurant->name : '';
            }
        }
        
        
        $deliveryOptions = [
            'express' => [
                'name' => 'Express', 
                'time' => '25 min', 
                'price' => 15700 
            ],
            'reguler' => [
                'name' => 'Reguler',
                'time' => '29-39 min',
                'price' => 13700
            ],
            'ekonomis' => [
                'name' => 'Ekonomis',
                'time' => '39-49 min',
                'price' => 5500
            ]
        ];
        
        // ✅ Kirim data ke view 'checkout'
        return view('checkout', [
            'userAddress' => Auth::user()->address ?? 'Alamat belum diatur', 
            'deliveryOptions' => $deliveryOptions, 
            'cart' => $cart, 
            'restaurantName' => $restaurantName,
            'restaurantId' => $restaurantId 
        ]);
    }

    
}