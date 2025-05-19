<?php

namespace App\Http\Controllers;


use App\Models\Driver; 
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 
use Illuminate\View\View; 
use Carbon\Carbon; 

class DriverController extends Controller
{
    


public function processLogin(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $driver = Driver::where('email', $credentials['email'])->first();

    if (!$driver || !Hash::check($credentials['password'], $driver->password)) {
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    Auth::guard('driver')->login($driver);

    return redirect()->route('driver.dashboard')->with('success', 'Login successful!');
}

    public function dashboard(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        // Mendapatkan driver yang sedang login dari guard 'driver'
        $driverUser = Auth::guard('driver')->user();

        // Jika tidak ada driver yang login (middleware auth.driver seharusnya sudah menangani)
        if (!$driverUser) {
            Log::warning('Unauthorized access to driver dashboard - no driver user logged in.');
            // Redirect ke login driver atau pemilihan peran
            return redirect()->route('driver.login'); // Atau route('select.role')
        }

        Log::info('Driver dashboard accessed', [
            'driver_id' => $driverUser->driver_id, // Menggunakan driver_id sesuai model Driver
            'ip' => $request->ip()
        ]);

        // Mengambil pesanan yang statusnya 'In Process' dan belum punya driver_id (Available Jobs)
        // Order::whereNull('delivery_driver_id') jika menggunakan nama kolom tsb
        $availableOrders = Order::where('status', 'In Process')
                                // Asumsi kolom yang menyimpan driver ID di tabel orders adalah 'delivery_driver_id' berdasarkan OrderController::store
                                ->whereNull('delivery_driver_id')
                                ->orderBy('order_time', 'asc') // Pesanan paling lama tampil duluan
                                // Load relasi user (customer), restaurant, items, dan menu
                                ->with(['user', 'restaurant', 'items.menu'])
                                ->paginate(10);
// 

        // Mengambil pesanan yang sudah di-assign ke driver ini
        // Asumsi kolom yang menyimpan driver ID di tabel orders adalah 'delivery_driver_id'
        $assignedOrders = Order::where('delivery_driver_id', $driverUser->driver_id) // Memfilter berdasarkan driver_id yang login
        ->whereIn('status', ['In Process', 'On The Way'])
        ->orderBy('status')
        ->with(relations: ['user', 'restaurant', 'items.menu']) // Tambahkan kembali with relasi jika Anda menghapusnya
        ->paginate(10);  // <--- TAMBAHKAN .get() DI SINI UNTUK MENGEKSEKUSI QUERY

        

        Log::info('Driver dashboard data fetched', [
            'driver_id' => $driverUser->driver_id,
            'available_count' => $availableOrders->count(),
            'assigned_count' => $assignedOrders->count()
        ]);


        // Mengembalikan view dashboard driver dengan data pesanan
        // Pastikan view ini ada: resources/views/driver/dashboard.blade.php
        return view('driver.dashboard', [
            'driver' => $driverUser,
            'availableOrders' => $availableOrders,
            'assignedOrders' => $assignedOrders,
        ]);
    }

    public function pickUpOrder(Request $request, Order $order)
{
    if ($order->status === 'In Process' && $order->delivery_driver_id === Auth::guard('driver')->id()) {
        $order->status = 'On The Way'; // Driver picks up the order
        $order->save();

        return redirect()->route('driver.dashboard')->with('success', 'Order picked up successfully.');
    }

    return back()->withErrors(['error' => 'Order cannot be picked up.']);
}

public function deliverOrder(Request $request, Order $order)
{

    

    \Log::info("Deliver attempt", [
        "order_id" => $order->order_id,
        "current_status" => $order->status,
        "driver_id" => $order->delivery_driver_id,
        "logged_in_driver" => Auth::guard('driver')->user()->driver_id,
    ]);

    if ($order->status === 'In Process' && $order->delivery_driver_id === Auth::guard('driver')->user()->driver_id) {
        $order->delivery_time = Carbon::now();
        $order->status = 'Delivered';
        
        $order->save();

        return redirect()->route('driver.dashboard')->with('success', 'Order delivered successfully.');
    }

    return back()->withErrors(['error' => 'Order cannot be marked as delivered.']);
}



    // Menampilkan semua driver (hanya untuk admin, bukan driver biasa) - Tetap biarkan jika memang ada rute untuk ini
    public function index()
    {
         // Pastikan view ini ada: resources/views/drivers/index.blade.php
        return view('drivers.index', ['drivers' => Driver::all()]);
    }

    // Menampilkan detail driver - Tetap biarkan jika memang ada rute untuk ini
    public function show($id)
    {
        // Pastikan view ini ada: resources/views/drivers/show.blade.php
        return view('drivers.show', ['driver' => Driver::findOrFail($id)]);
    }

    
    public function logout(Request $request)
    {
        // Logout dari guard 'driver'
        Auth::guard('driver')->logout();

        // Invalidasi sesi dan regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Driver user logged out', ['ip' => $request->ip()]);

        // Redirect kembali ke halaman pemilihan peran atau login driver
        return redirect()->route('select.role')->with('message', 'Anda telah berhasil logout sebagai Driver.'); // atau route('driver.login')
    }

    public function history(Request $request)
    {
        
        $driverUser = Auth::guard('driver')->user();

        if (!$driverUser) {
           
            return redirect()->route('driver.login')->with('error', 'Akses ditolak. Silakan login sebagai driver.');
        }

       
        $driverId = $driverUser->driver_id;

        
        $historyStatuses = ['completed', 'delivered', 'cancelled'];

        // Ambil data pesanan dari database untuk driver ini dengan status riwayat
        $orders = Order::where('delivery_driver_id', $driverId) // Filter pesanan yang ditugaskan ke driver ini
                       ->whereIn('status', $historyStatuses) // Filter berdasarkan status riwayat
                       ->with(['user', 'restaurant', 'items.menu']) // Eager load relasi user, restaurant, dan detail item menu
                       ->orderBy('order_time', 'desc') // Urutkan dari yang terbaru
                       ->paginate(15); 

        
        return view('driver.history', compact('driverUser', 'orders')); // Pastikan nama view 'driver.history' sesuai dengan lokasi file Blade Anda
    }


    

}