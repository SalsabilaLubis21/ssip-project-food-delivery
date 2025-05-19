<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Contracts\Auth\Authenticatable; 
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; 


class Driver extends Model implements Authenticatable 
{
    use HasFactory; 
    use AuthenticatableTrait; 

   
    protected $table = 'driver';
    protected $primaryKey = 'driver_id';
    public $incrementing = true;
    protected $keyType = 'int';

   

   
     protected $fillable = [
        'driver_id',
        'name',
        'email',
        'phone',
        'password', 
        'vehicle_plate',
        'role',
    ];

    protected $hidden = [
        'password',
        
        'remember_token',
    ];

    
    public $timestamps = false;


    
     public function getAuthIdentifierName()
    {
        return 'driver_id'; 
    }

    


    public function orders()
    {
       
        return $this->hasMany(Order::class, 'delivery_driver_id', 'driver_id');
    }

    public function getRoleAttribute()
    {
        return $this->attributes['role'] ?? 'driver';
    }
    

}