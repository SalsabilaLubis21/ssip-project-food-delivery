<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\RestaurantReview; 
use App\Models\Order;            

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'password',
        'role', // Pastikan kolom role ada di tabel user
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
    

    /**
     * Get the column name for the primary key.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function restaurant()
{
    return $this->hasMany(Restaurant::class);
}

public function orders()
{
    
    return $this->hasMany(Order::class, 'user_id', 'user_id');
}


public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function getRoleAttribute()
{
    return $this->attributes['role'] ?? 'user';
}

    public function restaurantReviews()
    {
        
        return $this->hasMany(RestaurantReview::class, 'user_id', 'user_id');
    }



}
