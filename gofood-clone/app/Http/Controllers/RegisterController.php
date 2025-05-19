<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Driver;

class RegisterController extends Controller
{
    /**
     * Show the general registration form with role selection
     */
    

    /**
     * Show user registration form
     */
    public function showUserRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Show restaurant registration form
     */
    public function showRestaurantRegistrationForm()
    {
        return view('auth.register-restaurant');
    }

    /**
     * Show driver registration form
     */
    public function showDriverRegistrationForm()
    {
        return view('auth.register-driver');
    }

    /**
     * Process user registration
     */
    public function registerUser(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'phone' => 'required|string|max:20|unique:user',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation'));
        }

        // Create new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set default role sebagai user
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login with your account.');
    }

    /**
     * Process restaurant registration
     */
    public function registerRestaurant(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:restaurant',
            'phone' => 'required|string|max:20|unique:restaurant',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'open_time' => 'required|string',
            'close_time' => 'required|string',
          
           
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation'));
        }

        // Create new restaurant
        Restaurant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'role' => 'restaurant admin', // Set default role sebagai user
           
        ]);

        return redirect()->route('restaurant.login')->with('success', 'Restaurant registration successful! Please wait for admin approval and then login.');
    }

    /**
     * Process driver registration
     */
    public function registerDriver(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:driver',
            'phone' => 'required|string|max:20|unique:driver',
            'password' => 'required|string|min:8|confirmed',
            'vehicle_plate' => 'required|string|max:20|unique:driver',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation'));
        }

        // Create new driver
        Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make(value: $request->password),
            'vehicle_plate' => $request->vehicle_plate,
            'role' => 'driver', // Set default role sebagai user
        ]);

        return redirect()->route('driver.login')->with('success', 'Driver registration successful! Please wait for admin approval and then login.');
    }
}