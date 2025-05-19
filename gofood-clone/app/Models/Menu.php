<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu'; 
    protected $primaryKey = 'menu_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['restaurant_id', 'name', 'price'];

    public function restaurant() {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'restaurant_id');
    }
}
