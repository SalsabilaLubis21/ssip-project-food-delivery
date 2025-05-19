@extends('layouts.app')

@section('content')
    <h1>{{ $restaurant->name }}</h1>
    <p><strong>Address:</strong> {{ $restaurant->address }}</p>
    <p><strong>Phone:</strong> {{ $restaurant->phone }}</p>
    <p><strong>Opening Hours:</strong> {{ $restaurant->open_time }} - {{ $restaurant->close_time }}</p>

    <h2>Menu</h2>
    @foreach ($restaurant->menus as $menu)
        <div class="menu-item">
            <h3>{{ $menu->name }}</h3>
            <p>{{ $menu->description }}</p>
            <p>Price: ${{ $menu->price }}</p>
            <button class="add-to-cart" data-menu-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-price="{{ $menu->price }}">Add to Cart</button>
        </div>
    @endforeach
@endsection
