<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\Restaurant; 
use App\Models\Driver; 
use App\Models\OrderDetail; 
use Illuminate\Support\Facades\Log; 

class Order extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'orders'; 

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'order_id'; 

    /**
     * Menunjukkan apakah primary key auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true; 

    /**
     * Tipe data primary key.
     *
     * @var string
     */
    protected $keyType = 'int'; 

    /**
     * Menunjukkan apakah model harus ditimestamp.
     * Jika true (default), Eloquent akan mencari created_at dan updated_at.
     * Kita set false karena tabel 'orders' tampaknya tidak punya kolom tersebut.
     *
     * @var bool
     */
    public $timestamps = false; 


    /**
     * Atribut yang dapat diisi massal (mass assignable).
     * Sesuaikan dengan kolom-kolom yang ada di tabel 'orders' dan ingin Anda izinkan diisi via ::create() atau ->fill().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'status', 
        'payment_method',
        'total_amount', 
        'order_time', 
        'delivery_driver_id', 
        'delivery_type',
        'delivery_cost',
        'delivery_address', 
        'payment_status', 
        'delivery_status', 
        'assigned_at', 
        'delivered_at', 
    ];

    /**
     * Atribut yang harus di-cast ke tipe native.
     * Berguna untuk mengelola kolom tanggal/waktu atau tipe lain.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order_time' => 'datetime', 
        'assigned_at' => 'datetime', 
        'delivered_at' => 'datetime', 
      
    ];


    // --- Definisi Relasi Eloquent ---

    /**
     * Get the user (customer) that owns the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        
        return $this->belongsTo(User::class, 'user_id', 'user_id'); 
    }

    /**
     * Get the restaurant that the order was placed from.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'restaurant_id'); 
    }

    /**
     * Get the driver who is assigned to the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        
        return $this->belongsTo(Driver::class, 'delivery_driver_id', 'driver_id'); 
    }

    /**
     * Get the order details (items) for the order.
     * Relasi ini digunakan di method with(['items.menu']) di controller.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
       
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }


    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class, 'order_id');
}

public function orderdetail() {
    return $this->hasMany(OrderDetail::class, 'order_id');
}


public function menu()
{
    return $this->belongsTo(Menu::class, 'menu_id');
}

    

    protected static function boot()
    {
        parent::boot();

        
        static::deleting(function($order) {
            $order->orderDetails()->delete();
        });
    }





}