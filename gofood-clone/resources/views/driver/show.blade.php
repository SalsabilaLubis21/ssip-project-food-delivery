@extends('layouts.app')

@section('content')
    <h1>Driver Information</h1>
    <p><strong>Name:</strong> {{ $driver->name }}</p>
    <p><strong>Phone:</strong> {{ $driver->phone }}</p>
    <p><strong>Vehicle Plate:</strong> {{ $driver->vehicle_plate }}</p>
@endsection
