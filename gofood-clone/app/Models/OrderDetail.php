<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Menu;

class OrderDetail extends Model
{
    protected $table = 'orderdetail';
    protected $primaryKey = 'order_detail_id';
    
    protected $fillable = ['order_id', 'menu_id', 'quantity', 'price'];

    public $timestamps = false;

    public function order() 
    { 
        return $this->belongsTo(Order::class, 'order_id', 'order_id'); 
    }

    public function menu() 
    { 
        return $this->belongsTo(Menu::class,  'menu_id', 'menu_id'); 
    }
}
