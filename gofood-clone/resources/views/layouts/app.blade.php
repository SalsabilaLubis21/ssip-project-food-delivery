<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoFood Clone</title>
    <link rel="stylesheet" href="{{ url('/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logout_styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lacak_styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav_tabs.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .main-content {
            padding-top: 0;
            margin-top: 0;
        }
        header {
            margin-top: 0;
            padding-top: 0;
            margin-bottom: 50px;
        }
        .navbar {
            background: #008f10;
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
        }
        .navbar-brand {
            color: white;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.5rem;
        }
        .orders-container {
            margin-top: 40px;
        }
        main {
            padding-top: 20px;
        }

        
footer {
    background-color:#212121; 
    color: white; 
    text-align: center; 
    padding: 20px 0; 
    margin-top: 40px; 
    width: 100%; 
   
}

footer p {
    margin: 0; 
    font-size: 0.9rem; 
}
    </style>
    @yield('styles')
    <script src="{{ url('/js/cart.js') }}" defer></script>
    <script src="{{ asset('js/logout.js') }}" defer></script>
</head>
<body>

    <div class="main-content">
        <header>
         
            <nav class="navbar">
                <a class="navbar-brand" href="/">GoFood Clone 🍽</a>
            </nav>
        </header>
    
        <main>
            @yield('content')
        </main>
    </div>
    
    <!-- Footer -->
    <footer>
        <p>🚀 GoFood Clone - Laravel Blade | &copy; {{ date('Y') }}</p>
    </footer>

    @yield('scripts')
</body>
</html>
