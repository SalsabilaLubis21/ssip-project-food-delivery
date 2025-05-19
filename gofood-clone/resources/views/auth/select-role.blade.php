@php
    
    $roles = [
        [
            'id' => 'user',
            'title' => 'User',
            'description' => 'Order food from your favorite restaurants',
            'image' => asset('images/user.png'),
            'color' => 'from-green-primary to-green-secondary',
            'hoverColor' => 'from-green-secondary to-green-dark',
        ],
        [
            'id' => 'restaurant',
            'title' => 'Restaurant Admin',
            'description' => 'Manage your restaurant and orders',
            'image' => asset('images/chef.png'),
            'color' => 'from-green-primary to-green-secondary',
            'hoverColor' => 'from-green-secondary to-green-dark',
        ],
        [
            'id' => 'driver',
            'title' => 'Driver',
            'description' => 'Deliver orders and earn money',
            'image' => asset('images/driver.png'),
            'color' => 'from-green-primary to-green-secondary',
            'hoverColor' => 'from-green-secondary to-green-dark',
        ]
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoFood - Select Role</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
   
    <link rel="stylesheet" href="{{ asset('css/index_login.css') }}">
</head>
<body>
    <div class="animated-background">
        <div class="gradient-bg"></div>
        <div class="food-pattern"></div>
        <canvas id="food-particles"></canvas>
        <div id="delivery-routes"></div>
        <div class="top-gradient"></div>
        <div class="bottom-gradient"></div>
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>

    <div id="floating-food" class="floating-food"></div>

    <div class="container">
        <div class="header">
            <div class="gofood-logo">
                <div class="logo-container">
                    <div class="logo-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.5 14.25C8.5 14.25 9.75 12.5 12 12.5C14.25 12.5 15.5 14.25 15.5 14.25" stroke="#00AA13" stroke-width="2" stroke-linecap="round"/>
                            <path d="M7 9.75H7.01" stroke="#00AA13" stroke-width="2" stroke-linecap="round"/>
                            <path d="M17 9.75H17.01" stroke="#00AA13" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="#00AA13" stroke-width="2"/>
                        </svg>
                    </div>
                    <span class="logo-text">GoFood</span>
                </div>
            </div>

            <h1 class="main-title">Welcome to GoFood</h1>
            <p class="subtitle">Select how you want to login</p>
        </div>

        <div class="role-grid">
          
            @foreach ($roles as $role)
                <div class="role-card" data-role="{{ $role['id'] }}">
                    @php
                        
                        $targetRoute = '';
                        if ($role['id'] === 'user') {
                            
                            $targetRoute = route('login');
                        } elseif ($role['id'] === 'restaurant') {
                             
                            $targetRoute = route('restaurant.login');
                        } elseif ($role['id'] === 'driver') {
                           
                            $targetRoute = route('driver.login');
                        }
                    @endphp

                    
                    @if($targetRoute)
                       
                        <a href="{{ $targetRoute }}" class="role-link">
                     
                            <div class="role-content {{ $role['color'] }}">
                                <div class="role-image-container">
                                    
                                    <img src="{{ $role['image'] }}" alt="{{ $role['title'] }} cartoon" class="role-image">
                                </div>

                                <div class="role-text">
                                    <h2 class="role-title">Login as {{ $role['title'] }}</h2>
                                    <p class="role-description">{{ $role['description'] }}</p>
                                </div>
                            </div>
                        </a>
                    @endif 
                </div> 
            @endforeach 
        </div> 
    </div> 

    
    <script src="{{ asset('js/animated-background.js') }}"></script>
    <script src="{{ asset('js/floating-food.js') }}"></script>
    <script src="{{ asset('js/role-cards.js') }}"></script>
</body>
</html>