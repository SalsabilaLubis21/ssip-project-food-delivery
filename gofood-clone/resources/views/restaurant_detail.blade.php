<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Restoran - {{ $restaurant->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/restaurant_detail_styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <h1>🍽 GoFood Clone</h1>
            <a href="/restaurants" class="btn-back">← Back</a>
        </div>
    </nav>

    <!-- Restaurant Detail -->
    <div class="restaurant-detail-container">
        <!-- Header -->
        <div class="restaurant-header">
            <img src="{{ $restaurant->image_url ?? 'https://ik.imagekit.io/tvlk/blog/2019/11/TRAVELOKA-EATS-Rekomendasi-Ayam-Geprek-Enak-di-Jakarta-3.png?tr=dpr-2,w-675' }}" 
                 alt="{{ $restaurant->name }}" 
                 class="restaurant-image">
            <h2>{{ $restaurant->name }}</h2>
        </div>

        <!-- Info -->
        <div class="restaurant-info">
            <p><strong>📍 Address:</strong> {{ $restaurant->address }}</p>
            <p><strong>☎ Telephone Number:</strong> {{ $restaurant->phone }}</p>
            <p><strong>⏰ Operational Hour:</strong> {{ $restaurant->open_time }} - {{ $restaurant->close_time }}</p>
        </div>

        <!-- Additional Info -->
        <div class="restaurant-additional-info">
            <div class="rating">
                <span class="rating-value">{{ number_format($averageRating, 1) }}</span>
                <span class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        {!! $i <= $averageRating ? '⭐️' : '☆' !!}
                    @endfor
                </span>
                <a href="{{ route('restaurants.reviews', ['id' => $restaurant->restaurant_id]) }}" class="rating-link">View review</a>
            </div>
            <div class="delivery-info">
                <p><strong>🚚 Delivery:</strong> Arrive in 25-35 minutes (1.05 km)</p>
            </div>
            <div class="partner-info">
                <span class="partner-badge">Super Partner</span>
            </div>
        </div>

        <!-- Menu Section -->
        <div class="restaurant-menu">
            <h3>🍴 Menu</h3>
            <div class="menu-grid">
                @forelse ($restaurant->menus as $menu)
                    <div class="menu-card">
                        <div class="menu-card-content">
                            <h4 class="menu-name">{{ $menu->name }}</h4>
                            <p class="menu-description">{{ $menu->description }}</p>
                            <p class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="menu-card-actions">
                            <button class="btn-decrease" data-menu-id="{{ $menu->menu_id }}" data-restaurant-id="{{ $restaurant->restaurant_id }}">-</button>
                            <span class="menu-quantity" data-menu-id="{{ $menu->menu_id }}">0</span>
                            <button class="btn-increase" data-menu-id="{{ $menu->menu_id }}" data-restaurant-id="{{ $restaurant->restaurant_id }}">+</button>
                        </div>
                    </div>
                @empty
                    <p class="no-menu">Menu not available for this restaurant.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div id="cart-container" class="cart-container" onclick="handleCheckout()">
        <div class="cart-summary">
            <span id="cart-item-count">0 item</span>
            <span id="cart-total-price">Rp 0</span>
            <p id="cart-restaurant-name">{{ $restaurant->name }}</p>
        </div>
        <img src="https://tse3.mm.bing.net/th/id/OIP.43H2H8E1x1OJnhXwW8k6wwHaE8?rs=1&pid=ImgDetMain" class="checkout-icon" alt="checkout">
    </div>

    <script>
        let cart = {
            items: {},
            totalPrice: 0
        };

        function updateCartDisplay() {
            const itemCount = Object.values(cart.items).reduce((sum, item) => sum + item.quantity, 0);
            const cartContainer = document.getElementById('cart-container');
            
            if (itemCount > 0) {
                cartContainer.classList.add('active');
            } else {
                cartContainer.classList.remove('active');
            }
            
            document.getElementById('cart-item-count').textContent = `${itemCount} item`;
            document.getElementById('cart-total-price').textContent = `Rp ${cart.totalPrice.toLocaleString('id-ID')}`;
        }

        document.querySelectorAll('.btn-increase').forEach(button => {
            button.addEventListener('click', function () {
                const menuId = this.getAttribute('data-menu-id');
                const menuName = this.closest('.menu-card').querySelector('.menu-name').textContent;
                const menuPrice = parseInt(this.closest('.menu-card').querySelector('.menu-price').textContent.replace('Rp ', '').replace('.', ''));

                if (!cart.items[menuId]) {
                    cart.items[menuId] = { name: menuName, price: menuPrice, quantity: 0 };
                }
                cart.items[menuId].quantity++;
                cart.totalPrice += menuPrice;

                document.querySelector(`.menu-quantity[data-menu-id="${menuId}"]`).textContent = cart.items[menuId].quantity;
                updateCartDisplay();
            });
        });

        document.querySelectorAll('.btn-decrease').forEach(button => {
            button.addEventListener('click', function () {
                const menuId = this.getAttribute('data-menu-id');
                if (cart.items[menuId] && cart.items[menuId].quantity > 0) {
                    const menuPrice = cart.items[menuId].price;
                    cart.items[menuId].quantity--;
                    cart.totalPrice -= menuPrice;

                    if (cart.items[menuId].quantity === 0) {
                        delete cart.items[menuId];
                    }

                    document.querySelector(`.menu-quantity[data-menu-id="${menuId}"]`).textContent = cart.items[menuId]?.quantity || 0;
                    updateCartDisplay();
                }
            });
        });

        function handleCheckout() {
            if (Object.keys(cart.items).length === 0) {
                alert('Keranjang kosong. Tambahkan item terlebih dahulu.');
                return;
            }

            const cartData = {
        restaurantId: {{ $restaurant->restaurant_id }}, // Tambahkan ID restoran
        items: cart.items,
        totalPrice: cart.totalPrice
    };

            // Create form to send data via POST
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '{{ route("checkout") }}';

            // Add cart data
            const cartInput = document.createElement('input');
            cartInput.type = 'hidden';
            cartInput.name = 'cart';
            cartInput.value = JSON.stringify(cartData);
            form.appendChild(cartInput);

            // Add restaurant name
            const restaurantInput = document.createElement('input');
            restaurantInput.type = 'hidden';
            restaurantInput.name = 'restaurant';
            restaurantInput.value = '{{ $restaurant->name }}';
            form.appendChild(restaurantInput);

            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
