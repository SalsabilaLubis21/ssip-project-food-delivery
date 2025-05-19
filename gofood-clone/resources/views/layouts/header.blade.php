<header>
    <nav class="navbar">
        <div class="navbar-container">
            <h1>🍽 GoFood Clone</h1>
            @auth
                <div class="user-actions">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>
    <nav class="secondary-nav">
        <a href="{{ route('home') }}" class="nav-link">Home</a>
        <a href="{{ route('restaurants.index') }}" class="nav-link">Restaurants</a>
        @auth
            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
        @endauth
    </nav>
</header>
