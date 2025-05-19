<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GoFood Clone</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard_styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <h1>🍽 GoFood Clone</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="welcome-banner">
            <h2>Welcome, {{ Auth::user()->name }} 👋</h2>
            <p>Start your journey on GoFood Clone!</p>
        </div>

        <div class="menu-grid">
            <a href="/orders" class="menu-card">
                <div class="menu-icon">🛒</div>
                <h3>View Order</h3>
                <p>Manage your orders simply and efficiently.</p>
            </a>
            <a href="/restaurants" class="menu-card">
                <div class="menu-icon">🍽</div>
                <h3>Find Restaurants</h3>
                <p>Explore your favorite restaurants nearby.</p>
            </a>
            <a href="/profile" class="menu-card">
                <div class="menu-icon">👤</div>
                <h3>Edit Profile</h3>
                <p>Update your account information anytime.</p>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="menu-card logout">
                @csrf
                <button type="submit">
                    <div class="menu-icon">🚪</div>
                    <h3>Logout</h3>
                    <p>Log out safely from your account.</p>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
