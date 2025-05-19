@extends('layouts.app')

@section('content')
    <h1>Reviews for {{ $restaurant->name }}</h1>
    
    @foreach ($reviews as $review)
        <div class="review-card">
            <p><strong>User:</strong> {{ $review->user->name }}</p>
            <p><strong>Rating:</strong> {{ $review->rating }} ⭐</p>
            <p>{{ $review->comment }}</p>
            <p><small>Reviewed on: {{ $review->review_date }}</small></p>
        </div>
    @endforeach

    <h2>Submit a Review</h2>
    <form action="/reviews" method="POST">
        @csrf
        <input type="hidden" name="restaurant_id" value="{{ request()->route('restaurant_id') }}">
        <label>Rating:</label>
        <select name="rating">
            <option value="5">5 Stars</option>
            <option value="4">4 Stars</option>
            <option value="3">3 Stars</option>
            <option value="2">2 Stars</option>
            <option value="1">1 Star</option>
        </select>
        <label>Comment:</label>
        <textarea name="comment"></textarea>
        <button type="submit">Submit Review</button>
    </form>
@endsection
