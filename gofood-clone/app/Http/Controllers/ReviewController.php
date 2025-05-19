<?php

namespace App\Http\Controllers;


use App\Models\RestaurantReview; 
use App\Models\Restaurant; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log; 


class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for a specific restaurant.
     * Rute: /restaurants/{restaurantId}/reviews (GET)
     *
     * @param  int  $restaurantId
     * @return \Illuminate\View\View
     */
    public function show($restaurantId) {
       
        $reviews = RestaurantReview::where('restaurant_id', $restaurantId)
                                   ->with('user') // Load relasi user jika perlu menampilkan nama user
                                   ->get();

        Log::info('Reviews accessed for restaurant', [
            'restaurant_id' => $restaurantId,
            'review_count' => $reviews->count()
        ]);

       
        return view('reviews.show', ['reviews' => $reviews]);
    }

    /**
     * Store a new restaurant review.
     * Rute: /reviews (POST)
     * Middleware: auth (diasumsikan)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        
        $request->validate([
            'restaurant_id' => 'required|exists:restaurant,restaurant_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // Cek apakah user yang login sudah memberikan review untuk restoran ini sebelumnya
        $existingReview = RestaurantReview::where('user_id', Auth::id())
                                          ->where('restaurant_id', $request->restaurant_id)
                                          ->first();

        if ($existingReview) {
            Log::warning('User attempted to leave multiple reviews for same restaurant', [
                'user_id' => Auth::id(),
                'restaurant_id' => $request->restaurant_id
            ]);
            
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk restoran ini sebelumnya.');
        }

        // Jika belum ada review dari user ini, simpan review baru
        try {
            RestaurantReview::create([
                'user_id' => Auth::id(), // ID user yang sedang login
                'restaurant_id' => $request->restaurant_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'review_date' => now() // Menggunakan waktu saat ini sebagai tanggal review
            ]);

            Log::info('Review stored successfully', [
                'user_id' => Auth::id(),
                'restaurant_id' => $request->restaurant_id
            ]);

            
            return redirect()->back()->with('success', 'Review successfully submitted. Thank you for your feedback!');

        } catch (\Exception $e) {
            
            Log::error('Error storing review: ' . $e->getMessage(), [
                 'user_id' => Auth::id(),
                 'restaurant_id' => $request->restaurant_id,
                 'trace' => $e->getTraceAsString() 
            ]);
           
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim review.');
        }
    }

    
}