@extends('layouts.app')

@section('content')
    <h1>Restaurant Reviews</h1>
    @foreach ($reviews as $review)
        <div class="review-card">
            <p><strong>Restaurant:</strong> {{ $review->restaurant->name }}</p>
            <p><strong>User:</strong> {{ $review->user->name }}</p>
            <p><strong>Rating:</strong> {{ $review->rating }} ⭐</p>
            <p>{{ $review->comment }}</p>
        </div>
    @endforeach
@endsection
