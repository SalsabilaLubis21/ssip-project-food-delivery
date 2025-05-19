<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Contracts\Auth\Authenticatable; 
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; 

use App\Models\Menu;
use App\Models\RestaurantReview;


class Restaurant extends Model implements Authenticatable 
{
    use HasFactory; 
    use AuthenticatableTrait; 

    protected $table = 'restaurant';
    protected $primaryKey = 'restaurant_id';
    public $incrementing = false;
    protected $keyType = 'int';

    public $timestamps = false;


    protected $fillable = [
        'restaurant_id',
        'name',
        'address',
        'phone',
        'open_time',
        'close_time',
        'image_url',
        'email', 
        'password', 
        'role'
    ];

    protected $hidden = [
        'password',
        
        'remember_token',
    ];

   

    public function getAuthIdentifierName()
    {
        return 'restaurant_id'; 
    }

    
    public function menus() {
        return $this->hasMany(Menu::class, 'restaurant_id', 'restaurant_id');
    }

    public function reviews()
    {
        return $this->hasMany(RestaurantReview::class, 'restaurant_id', 'restaurant_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'restaurant_id', 'restaurant_id');
    }

    public function getRoleAttribute()
    {
        return $this->attributes['role'] ?? 'restaurant'; 
    }
    


}