
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to GoFood Clone</title>
 
    <link rel="stylesheet" href="{{ asset('css/homepage_styles.css') }}">
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- -------------------------------------------------------------- --}}


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">
                <i class="fas fa-utensils"></i> GoFood Clone
            </a>
            <div class="navbar-links">
                
                <a href="{{ route('select.role') }}" class="nav-link btn btn-primary">
                    <i class="fas fa-utensils"></i> Start Exploring
                </a>
                {{-- If using authentication and want Login/Register or Dashboard/Logout buttons --}}
                {{-- @auth
                    <a href="{{ route('dashboard') }}" class="nav-link btn btn-secondary">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link btn btn-secondary">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link btn btn-primary">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endif
                @endauth --}}
            </div>
        </div>
    </nav>

    <header class="homepage-hero">
        <div class="hero-content">
           
            <h1 class="scroll-animated">Order Your Favorite Food, Delivered Instantly!</h1>
            <p class="scroll-animated" style="transition-delay: 0.1s;">Find thousands of delicious culinary options from the best restaurants around you with ease.</p>
            
            <a href="{{ route('select.role') }}" class="btn btn-primary btn-large scroll-animated" style="transition-delay: 0.2s;">Start Exploring Restaurants</a>
        </div>
    </header>

    <main>
        <section class="about-gofood-clone">
            <div class="container">
               
                <h2 class="section-title scroll-animated">About GoFood Clone</h2>
                
                <p class="scroll-animated" style="transition-delay: 0.1s;">GoFood Clone is a food delivery service platform that connects you with various restaurants and your favorite dishes.</p>
                <p class="scroll-animated" style="transition-delay: 0.2s;">We are committed to providing a fast, easy, and enjoyable ordering experience, right from your hand.</p>
            </div>
        </section>

        
        <div class="image-section">
             <img src="https://i0.wp.com/www.mime.asia/wp-content/uploads/2020/07/10.-Gojek-and-Grab-Strategies-to-Compete-with-other-Startup-during-the-Pandemic.jpg?resize=820%2C394&ssl=1"
                  alt="GoFood Clone Service Image"
                  class="scroll-animated-image"> 
        </div>


        <section class="why-choose-us">
            <div class="container">
                
                <h2 class="section-title scroll-animated">Why Choose Us?</h2>
                <div class="features-grid">
                    
                    <div class="feature-item scroll-animated" style="transition-delay: 0.1s;">
                        <i class="fas fa-clock"></i>
                        <h3>Fast Delivery</h3>
                        <p>We ensure your order arrives quickly and safely.</p>
                    </div>
                     
                     <div class="feature-item scroll-animated" style="transition-delay: 0.2s;">
                        <i class="fas fa-hand-holding-heart"></i>
                        <h3>Diverse Options</h3>
                        <p>Explore thousands of menus from various types of cuisine.</p>
                    </div>
                     
                     <div class="feature-item scroll-animated" style="transition-delay: 0.3s;">
                        <i class="fas fa-tags"></i>
                        <h3>Attractive Promos</h3>
                        <p>Get discounts and special offers every day.</p>
                    </div>
                </div>
            </div>
        </section>


        <section class="cta-section">
            <div class="container">
               
                <h2 class="section-title scroll-animated">Ready to Order?</h2>
             
                <p class="scroll-animated" style="transition-delay: 0.1s;">Thousands of delicious dishes await you. Click the button below to view our list of restaurants!</p>
                 
                <a href="{{ route('select.role') }}" class="btn btn-primary btn-large scroll-animated" style="transition-delay: 0.2s;">
                     <i class="fas fa-arrow-right"></i> Try Us
                </a>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="container">
            
            <div class="social-icons">
                <a href="https://www.instagram.com/gofoodindonesia/" target="_blank" class="social-icon">
                    <i class="fab fa-instagram"></i> 
                </a>
                <a href="https://x.com/gofoodindonesia/" target="_blank" class="social-icon">
                    <i class="fab fa-twitter"></i> 
                </a>
                <a href="https://www.facebook.com/gofoodindonesia/" target="_blank" class="social-icon">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.youtube.com/@gofoodpartners" target="_blank" class="social-icon">
                     <i class="fab fa-youtube"></i> 
                </a>
            </div>

          
            <p>© {{ date('Y') }} GoFood Clone. All rights reserved.</p>
        </div>
    </footer>

    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
           
            const elements = document.querySelectorAll('.scroll-animated-image, .scroll-animated');

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                      
                    } else {
                         
                    }
                });
            }, {
                threshold: 0.2 
            });

            elements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>
</html>
