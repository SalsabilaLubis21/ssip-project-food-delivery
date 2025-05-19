<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;



// --- 📌 Rute Pemilihan Peran (Harus Dipilih Sebelum Login) ---
Route::get('/select-role', [AuthController::class, 'showSelectRoleForm'])->name('select.role');
Route::post('/select-role', [AuthController::class, 'processSelectRole'])->name('process.role');

// --- 📌 Authentication Routes (Guest Only) ---
Route::middleware('guest')->group(function () {
    // Regular User Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'processUserLogin'])->name('login.process');
    
    // Driver Login
    Route::get('/driver/login', [AuthController::class, 'showDriverLoginForm'])->name('driver.login');
    Route::post('/driver/login', [AuthController::class, 'processDriverLogin'])->name('driver.login.process');

    // Restaurant Login
    Route::get('/restaurant/login', [AuthController::class, 'showRestaurantLoginForm'])->name('restaurant.login');
    Route::post('/restaurant/login', [AuthController::class, 'processRestaurantLogin'])->name('restaurant.login.process');
    
    // Registration routes
    Route::get('user/register', [RegisterController::class, 'showUserRegistrationForm'])->name('user.register');
    Route::post('user/register', [RegisterController::class, 'registerUser'])->name('user.register.process');
    
    Route::get('restaurant/register', [RegisterController::class, 'showRestaurantRegistrationForm'])->name('restaurant.register');
    Route::post('restaurant/register', [RegisterController::class, 'registerRestaurant'])->name('restaurant.register.process');

    Route::get('driver/register', [RegisterController::class, 'showDriverRegistrationForm'])->name('driver.register');
    Route::post('driver/register', [RegisterController::class, 'registerDriver'])->name('driver.register.process');
    
    // Password reset routes
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/reset-password/direct', [PasswordResetController::class, 'resetDirectly'])->name('password.reset.direct');
});

// --- 📌 Logout Routes ---
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:web,driver,restaurant');
Route::post('/restaurant/logout', [AuthController::class, 'logout'])->name('restaurant.logout');
Route::post('/driver/logout', [AuthController::class, 'logout'])->name('driver.logout');


// --- 📌 Publik Rute Utama ---
Route::get('/', [RestaurantController::class, 'showAppPage'])->name('home');

// --- 📌 Restaurant Routes (Public) ---
Route::prefix('restaurants')->group(function () {
    Route::get('/', [RestaurantController::class, 'index'])->name('restaurants.index');
    Route::get('/{id}', [RestaurantController::class, 'show'])->where('id', '[0-9]+')->name('restaurants.show');
    Route::get('/{id}/reviews', [RestaurantController::class, 'showReviews'])->name('restaurants.reviews');
   
});

// --- 📌 Dashboard Routes Based on Role ---
// Regular User Dashboard
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Restaurant Dashboard
Route::middleware(['auth:restaurant'])->group(function () {
    Route::get('/restaurant/dashboard', [RestaurantController::class, 'dashboard'])->name('restaurant.dashboard');
    Route::get('restaurant/history', [RestaurantController::class, 'history'])->name('history');
});

// Driver Dashboard
Route::middleware(['auth:driver'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
    Route::get('/history', [DriverController::class, 'history'])->name('driver.history');

});

// --- 📌 Protected Routes (Require Authentication) ---
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/password', [UserProfileController::class, 'updatePassword'])->name('profile.update.password');
    });

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/add-to-cart', [OrderController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/cart/clear', [OrderController::class, 'clearCart'])->name('cart.clear');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');

});

// --- 📌 Order Routes ---
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/history', [OrderController::class, 'history'])->name('history');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('cancel');
    Route::get('/{id}/track', [OrderController::class, 'trackOrder'])->name('track');
});

// Process order general route
Route::post('/{order}/process', [RestaurantController::class, 'processOrder'])->name('order.process');

// --- 📌 Restaurant Admin Routes ---
Route::middleware(['auth:restaurant'])->prefix('restaurant')->name('restaurant.')->group(function () {
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [RestaurantController::class, 'listOrders'])->name('index');
        Route::post('/{order}/process', [RestaurantController::class, 'processOrder'])->name('process');
        Route::post('/{order}/ready', [RestaurantController::class, 'markOrderReady'])->name('ready');
        Route::get('/{order}', [RestaurantController::class, 'showOrder'])->name('show');
    });
});

Route::prefix('profile')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- 📌 Driver Routes ---
Route::middleware(['auth:driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/available', [DriverController::class, 'listAvailableOrders'])->name('available');
        Route::get('/assigned', [DriverController::class, 'listAssignedOrders'])->name('assigned');
        Route::post('/{order}/accept', [DriverController::class, 'acceptOrder'])->name('accept');
        Route::post('/{order}/on-the-way', [DriverController::class, 'markOnTheWay'])->name('on-the-way');
        Route::post('/{order}/pickup', [DriverController::class, 'markPickedUp'])->name('pickup');
        Route::post('/{order}/deliver', [DriverController::class, 'deliverOrder'])->name('deliver');
        Route::get('/{order}', [DriverController::class, 'showOrder'])->name('show');
    });
});

// --- 📌 Review Routes ---
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// --- 📌 Debug Routes ---
Route::prefix('debug')->group(function () {
    Route::get('/auth', function () {
        $email = request('email', 'budi.s@example.com');
        $password = request('password', 'budi123');

        $user = \App\Models\User::where('email', $email)->first();

        return [
            'user_details' => [
                'found' => $user ? 'Yes' : 'No',
                'email' => $user ? $user->email : 'Not found',
                'user_id' => $user ? $user->user_id : 'Not found'
            ],
            'password_check' => [
                'input_password' => $password,
                'stored_password' => $user ? $user->password : 'Not found',
                'password_length' => $user ? strlen($user->password) : 0,
                'is_hashed' => $user ? str_starts_with($user->password, '$2y$') : false,
                'direct_match' => $user && $user->password === $password ? 'Yes' : 'No'
            ],
            'authentication' => [
                'auth_attempt_success' => Auth::attempt([
                    'email' => $email,
                    'password' => $password
                ]) ? 'Yes' : 'No',
                'session_active' => session()->has('user') ? 'Yes' : 'No',
                'auth_check' => Auth::check() ? 'Yes' : 'No'
            ]
        ];
    });

    Route::delete('/profile/delete', [UserProfileController::class, 'deleteAccount'])
    ->name('profile.delete')
    ->middleware(['auth']);

    Route::get('/hash-passwords', function () {
        $users = \App\Models\User::all();
        $updated = 0;

        foreach ($users as $user) {
            if (!str_starts_with($user->password, '$2y$')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($user->password);
                $user->save();
                $updated++;
            }
        }

        return [
            'message' => 'Password hashing complete',
            'users_updated' => $updated,
            'total_users' => $users->count()
        ];
    });
});