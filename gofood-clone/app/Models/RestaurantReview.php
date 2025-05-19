<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Restaurant;

class RestaurantReview extends Model
{
    use HasFactory;

    protected $table = 'restaurantreview';
    protected $primaryKey = 'review_id';
    public $timestamps = false;

    protected $fillable = ['restaurant_id', 'user_id', 'rating', 'comment', 'review_date'];

    public function user() 
    { 
        return $this->belongsTo(User::class, 'user_id', 'user_id'); 
    }

    public function restaurant() 
    { 
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'restaurant_id'); 
    }
}


