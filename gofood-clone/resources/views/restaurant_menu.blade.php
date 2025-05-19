<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu Restoran</title>
</head>
<body>
    @foreach ($menus as $menu)
    <div class="menu-item">
        <h4>{{ $menu->name }}</h4>
        <p>Price: Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
        <button class="btn-add-to-cart" data-menu-id="{{ $menu->menu_id }}" data-restaurant-id="{{ $restaurant->restaurant_id }}">
            Add
        </button>
    </div>
    @endforeach

    <script>
        document.querySelectorAll('.btn-add-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                const menuId = this.getAttribute('data-menu-id');
                const restaurantId = this.getAttribute('data-restaurant-id');

                console.log('Menu ID:', menuId); // Debugging
                console.log('Restaurant ID:', restaurantId); // Debugging

                fetch('/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ menu_id: menuId, restaurant_id: restaurantId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Item berhasil ditambahkan ke keranjang!');
                        console.log(data.cart); // Debugging
                    } else {
                        alert('Gagal menambahkan item ke keranjang.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            });
        });
    </script>
</body>
</html>