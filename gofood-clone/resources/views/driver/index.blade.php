@extends('layouts.app')

@section('content')
    <h1>Available Drivers</h1>
    @foreach ($drivers as $driver)
        <div class="driver-card">
            <h2>{{ $driver->name }}</h2>
            <p>Phone: {{ $driver->phone }}</p>
            <p>Vehicle: {{ $driver->vehicle_plate }}</p>
            <a href="/drivers/{{ $driver->id }}">View Details</a>
        </div>
    @endforeach
@endsection
