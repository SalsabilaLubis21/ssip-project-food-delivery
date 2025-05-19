<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\RestaurantReview;
use App\Models\User;
use App\Models\Restaurant; 

class MenuController extends Controller
{
    /**
     * Menampilkan daftar menu berdasarkan restoran.
     *
     * @param  int  $restaurantId
     * @return \Illuminate\View\View
     */
    public function show($restaurantId)
    {
        
        $restaurant = Restaurant::findOrFail($restaurantId);

        
        $menus = Menu::where('restaurant_id', $restaurantId)->get();

        return view('menus.show', compact('menus', 'restaurant'));
    }
}
