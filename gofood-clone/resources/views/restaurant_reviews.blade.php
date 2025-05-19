<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan - {{ $restaurant->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/restaurant_reviews_styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('restaurants.show', ['id' => $restaurant->restaurant_id]) }}" class="btn-back">← Kembali</a>
            <h1>Review and Rating</h1>
        </div>
    </nav>

    <!-- Restaurant Info -->
    <div class="restaurant-info">
        <h2>{{ $restaurant->name }}</h2>
        <p><strong>Address:</strong> {{ $restaurant->address }}</p>
        <p><strong>Telephone Number:</strong> {{ $restaurant->phone }}</p>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-container">
        @forelse ($reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="user-avatar">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                    <div class="user-info">
                        <h4>{{ $review->user->name ?? 'Pengguna Tidak Dikenal' }}</h4>
                    </div>
                    <div class="review-rating">
                        <span class="rating-value">{{ $review->rating }}</span>
                        <span class="rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                {!! $i <= $review->rating ? '⭐️' : '☆' !!}
                            @endfor
                        </span>
                    </div>
                </div>
                <div class="review-body">
                    <p>{{ $review->comment }}</p>
                    <p class="review-date">Purchased in {{ $review->review_date }}</p>
                    <p>Review made in {{ \Carbon\Carbon::parse($review->review_date)->format('Y') ?? 'N/A' }}</p>
                </div>
            </div>
        @empty
            <p class="no-reviews">No reviews have been posted for this restaurant yet.</p>
        @endforelse
    </div>
</body>
</html>