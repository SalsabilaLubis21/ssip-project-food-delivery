<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Menu; // Explicitly import related models
use App\Models\RestaurantReview;

class Restaurant extends Model
{
    protected $fillable = ['restaurant_id', 'name', 'address', 'phone', 'open_time', 'close_time'];

    public function menus() 
    { 
        return $this->hasMany(Menu::class); 
    }

    public function reviews() 
    { 
        return $this->hasMany(RestaurantReview::class); 
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'restaurant_id', 'restaurant_id');
    }
    
    }

