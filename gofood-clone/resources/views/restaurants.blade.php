<!DOCTYPE html>
<html lang="en"> {{-- Changed language to English --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find the Best Restaurants - GoFood Clone</title> {{-- Translated title --}}
    {{-- Make sure the path to this CSS is correct --}} {{-- Translated comment --}}
    <link rel="stylesheet" href="{{ asset('css/restaurant_styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">
                <i class="fas fa-utensils"></i> GoFood Clone
            </a>
            <div class="navbar-links">
                
                <a href="/dashboard" class="nav-link btn btn-secondary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <header class="hero-banner">
        <div class="hero-content">
            <h1>Find Your Favorite Restaurant</h1> 
            <p>Explore a wide variety of the best culinary options around you.</p> {{-- Translated text --}}
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search restaurant name..." onkeyup="filterRestaurants()" /> {{-- Translated placeholder --}}
            </div>
        </div>
    </header>

    <main class="container">
        <h2 class="section-title">Popular Restaurants 🔥 </h2> 
        <section class="restaurants-grid" id="restaurantsGrid">
         
            @forelse($restaurants as $restaurant)
            <div class="restaurant-card">
                <div class="card-image">
                    
                    <img src="{{ $restaurant->image_url ? asset($restaurant->image_url) : asset('images/placeholder.jpg') }}" alt="Image {{ $restaurant->name }}"> {{-- Translated alt text --}}
                </div>
                <div class="card-content">
                    <h3>{{ $restaurant->name }}</h3>
                    <p class="card-info"><i class="fas fa-map-marker-alt icon"></i> {{ $restaurant->address }}</p>
                    <p class="card-info"><i class="fas fa-phone icon"></i> {{ $restaurant->phone }}</p>
                    <p class="card-info"><i class="fas fa-clock icon"></i> {{ $restaurant->open_time }} - {{ $restaurant->close_time }}</p>
                </div>
                <div class="card-footer">
                    
                    <a href="{{ route('restaurants.show', ['id' => $restaurant->restaurant_id]) }}" class="btn btn-primary btn-details">
                        View Menu <i class="fas fa-arrow-right"></i> 
                    </a>
                </div>
            </div>
            @empty

            <div class="no-results">
                <p>Oops! No restaurants available yet.</p> 
                <i class="fas fa-store-slash fa-3x"></i>
            </div>
            @endforelse
        </section>
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} GoFood Clone. All rights reserved.</p>
    </footer>

    <script>
        function filterRestaurants() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let cards = document.querySelectorAll('.restaurant-card');
            let grid = document.getElementById('restaurantsGrid');
            let found = false; 

            cards.forEach(card => {
                
                let restaurantName = card.querySelector('h3').textContent.toLowerCase();
                if (restaurantName.includes(input)) {
                    card.style.display = ''; 
                    found = true;
                } else {
                    card.style.display = 'none'; 
                }
            });

            let noResultsElement = grid.querySelector('.no-results-search');
            if (!found && input !== '') {
                if (!noResultsElement) {
                    noResultsElement = document.createElement('div');
                    noResultsElement.className = 'no-results no-results-search'; 
                    noResultsElement.innerHTML = `<p>Restaurant "${document.getElementById('searchInput').value}" not found.</p><i class="fas fa-search-minus fa-3x"></i>`; {{-- Translated text --}}
                    grid.appendChild(noResultsElement);
                }
                noResultsElement.style.display = ''; 
            } else if (noResultsElement) {
                noResultsElement.style.display = 'none'; 
            }
            
            let initialNoResults = grid.querySelector('.no-results:not(.no-results-search)');
            if (initialNoResults) {
                initialNoResults.style.display = cards.length > 0 && input === '' ? '' : 'none'; 
                 if (cards.length === 0 && input === '') {
                    initialNoResults.style.display = ''; 
                } else {
                     initialNoResults.style.display = 'none'; 
                }
            }
        }

        
        document.getElementById('searchInput').addEventListener('input', function() {
            if (this.value === '') {
                let noResultsSearch = document.querySelector('.no-results-search');
                if (noResultsSearch) {
                    noResultsSearch.style.display = 'none';
                }
                
                document.querySelectorAll('.restaurant-card').forEach(card => card.style.display = '');

                
                 let initialNoResults = document.querySelector('.no-results:not(.no-results-search)');
                 if (initialNoResults && document.querySelectorAll('.restaurant-card').length === 0) {
                     initialNoResults.style.display = '';
                 }
            }
        });

       
         document.addEventListener('DOMContentLoaded', function() {
             filterRestaurants();
         });
    </script>
</body>
</html>