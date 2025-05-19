@extends('layouts.app')

@section('content')
    <h1>Menus</h1>
    @foreach ($menus as $menu)
        <div class="menu-item">
            <h2>{{ $menu->name }}</h2>
            <p>{{ $menu->description }}</p>
            <p>Price: ${{ $menu->price }}</p>
            <button class="add-to-cart" data-menu-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-price="{{ $menu->price }}">Add to Cart</button>
        </div>
    @endforeach
@endsection
