<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - GoFood Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            padding-bottom: 80px;
        }

        .header {
            padding: 16px;
            background: white;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .back-button {
            text-decoration: none;
            color: #333;
            margin-right: 16px;
        }

        .restaurant-name {
            font-size: 16px;
            font-weight: 500;
        }

        .like-icon {
            margin-left: auto;
            padding: 8px;
            background: #fff4e5;
            border-radius: 50%;
            color: #ff9500;
        }

        .content {
            padding: 16px;
            background: white;
            margin: 16px;
            border-radius: 12px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: #666;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #eee;
        }

        .promo-card {
            display: flex;
            align-items: center;
            padding: 16px;
            background: #fff;
            margin: 16px;
            border-radius: 12px;
            border: 1px solid #eee;
        }

        .promo-info {
            flex: 1;
        }

        .promo-title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .promo-desc {
            color: #666;
            font-size: 14px;
        }

        .promo-button {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 20px;
            background: white;
            color: #333;
        }

        .delivery-options {
            margin: 16px;
            background: white;
            border-radius: 12px;
            padding: 16px;
        }

        .delivery-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
        }

        .delivery-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .delivery-time {
            color: #666;
            font-size: 14px;
        }

        .address-section {
            margin: 16px;
            background: white;
            border-radius: 12px;
            padding: 16px;
        }

        .checkout-button {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px;
            background: white;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }

        .checkout-button button {
            width: 100%;
            padding: 16px;
            background: #cccccc;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
        }

        .checkout-button button.active {
            background: #00AA13;
        }

        .delivery-option {
            cursor: pointer;
            position: relative;
            padding: 16px;
            border-radius: 8px;
        }

        .delivery-option.selected {
            background-color: #f0f9f1;
        }

        .delivery-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .delivery-option .radio-circle {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delivery-option.selected .radio-circle {
            border-color: #00AA13;
        }

        .delivery-option.selected .radio-circle::after {
            content: '';
            width: 12px;
            height: 12px;
            background: #00AA13;
            border-radius: 50%;
        }

        .payment-methods {
            margin: 16px;
            background: white;
            border-radius: 12px;
            padding: 16px;
        }

        .payment-method {
            cursor: pointer;
            position: relative;
            padding: 16px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-method.selected {
            background-color: #f0f9f1;
        }

        .payment-method input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .payment-method .radio-circle {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-method.selected .radio-circle {
            border-color: #00AA13;
        }

        .payment-method.selected .radio-circle::after {
            content: '';
            width: 12px;
            height: 12px;
            background: #00AA13;
            border-radius: 50%;
        }

        .payment-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .payment-logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border-radius: 12px;
            width: 80%;
            max-width: 500px;
        }

        .driver-info {
            margin-top: 20px;
        }

        .driver-header {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .driver-detail {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .driver-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #eee;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #666;
        }

        .driver-name {
            font-weight: 500;
        }

        .driver-vehicle {
            color: #666;
            font-size: 14px;
        }

        .close-button {
            width: 100%;
            padding: 12px;
            background: #00AA13;
            color: white;
            border: none;
            border-radius: 8px;
            margin-top: 16px;
            font-weight: 500;
            cursor: pointer;
        }

        .delivery-address-options {
            margin-top: 15px;
        }

        .address-option {
            cursor: pointer;
            position: relative;
            padding: 16px;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .address-option.selected {
            background-color: #f0f9f1;
        }

        .address-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .address-info {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .address-text {
            display: block;
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }

        .custom-address-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            min-height: 80px;
            resize: vertical;
        }

        .custom-address-input:focus {
            outline: none;
            border-color: #00AA13;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="javascript:history.back()" class="back-button">←</a>
        <span class="restaurant-name" id="restaurantName"></span>
        <span class="like-icon">👍</span>
    </div>

    <div class="content">
        <div class="section-title">Payment summary</div>
        <div class="price-row">
            <span>Price</span>
            <span id="subtotal"></span>
        </div>
        <div class="price-row">
            <span>Delivery and Processing Fees</span>
            <span id="deliveryFee">13.700</span>
        </div>
        <div class="total-row">
            <span>Total payment</span>
            <span id="totalPayment"></span>
        </div>
    </div>
        
    <div class="delivery-options">
        <div class="section-title">Delivery</div>
        @foreach($deliveryOptions as $key => $option)
        <label class="delivery-option" data-price="{{ $option['price'] }}">
            <input type="radio" name="delivery_type" value="{{ $key }}" 
                   {{ $key === 'reguler' ? 'checked' : '' }}>
            <div class="delivery-info">
                <div class="radio-circle"></div>
                <div>
                    <span>{{ $option['name'] }}</span>
                    <span class="delivery-time">{{ $option['time'] }}</span>
                </div>
            </div>
            <span>Rp {{ number_format($option['price'], 0, ',', '.') }}</span>
        </label>
        @endforeach
    </div>

    <div class="payment-methods">
        <div class="section-title">Payment Method</div>
        <label class="payment-method selected">
            <input type="radio" name="payment_method" value="gopay" checked>
            <div class="payment-info">
                <div class="radio-circle"></div>
                <div>
                    <span>GoPay</span>
                </div>
            </div>
        </label>
        <label class="payment-method">
            <input type="radio" name="payment_method" value="cash">
            <div class="payment-info">
                <div class="radio-circle"></div>
                <div>
                    <span>Cash</span>
                </div>
            </div>
        </label>
        <label class="payment-method">
            <input type="radio" name="payment_method" value="credit_card">
            <div class="payment-info">
                <div class="radio-circle"></div>
                <div>
                    <span>Credit Card</span>
                </div>
            </div>
        </label>
    </div>

    <div class="address-section">
        <div class="section-title">Delivery Address</div>
        <div class="delivery-address-options">
            <label class="address-option selected">
                <input type="radio" name="address_type" value="default" checked>
                <div class="address-info">
                    <div class="radio-circle"></div>
                    <div>
                        <span>Default address</span>
                        <span class="address-text">{{ $userAddress }}</span>
                    </div>
                </div>
            </label>
            <label class="address-option">
                <input type="radio" name="address_type" value="custom">
                <div class="address-info">
                    <div class="radio-circle"></div>
                    <div>
                        <span>Alternative address</span>
                    </div>
                </div>
            </label>
        </div>
        
        <div id="customAddressForm" style="display: none; margin-top: 15px;">
            <textarea id="customAddress" placeholder="Enter complete delivery address" class="custom-address-input"></textarea>
        </div>
    </div>

    <div class="checkout-button">
        <button class="active" id="checkoutButton">Buy and deliver now</button>
    </div>

    <!-- Modal untuk menampilkan informasi driver -->
    <div id="driverModal" class="modal">
        <div class="modal-content">
            <div class="section-title">Order Successful!</div>
            <p>Thank you for your order. Your order is being processed.</p>
            
            <div class="driver-info">
                <div class="driver-header">Driver Information</div>
                <div class="driver-detail">
                    <div class="driver-avatar">🛵</div>
                    <div>
                        <div class="driver-name" id="modalDriverName"></div>
                        <div class="driver-vehicle" id="modalVehiclePlate"></div>
                    </div>
                </div>
            </div>
            
            <button class="close-button" id="closeModal">View Order Status</button>
        </div>
    </div>

    <script>
        // Get cart data from URL
        const urlParams = new URLSearchParams(window.location.search);
        const cartData = JSON.parse(decodeURIComponent(urlParams.get('cart')));
        const restaurantName = urlParams.get('restaurant');

        // Update DOM
        document.getElementById('restaurantName').textContent = restaurantName;
        document.getElementById('subtotal').textContent = 'Rp ' + cartData.totalPrice.toLocaleString('id-ID');
        
        // Handle delivery option selection
        const deliveryOptions = document.querySelectorAll('.delivery-option');
        let selectedDeliveryFee = 13700; // Default to reguler
        let selectedDeliveryType = 'reguler'; // Default delivery type

        deliveryOptions.forEach(option => {
            const radio = option.querySelector('input[type="radio"]');
            
            option.addEventListener('click', () => {
                // Remove selected class from all options
                deliveryOptions.forEach(opt => opt.classList.remove('selected'));
                // Add selected class to clicked option
                option.classList.add('selected');
                // Check the radio button
                radio.checked = true;
                // Update selected delivery type
                selectedDeliveryType = radio.value;
                // Update delivery fee
                selectedDeliveryFee = parseInt(option.dataset.price);
                document.getElementById('deliveryFee').textContent = 'Rp ' + selectedDeliveryFee.toLocaleString('id-ID');
                // Update total
                const total = cartData.totalPrice + selectedDeliveryFee;
                document.getElementById('totalPayment').textContent = 'Rp ' + total.toLocaleString('id-ID');
            });

            // Initialize selected state
            if (radio.checked) {
                option.classList.add('selected');
            }
        });

        // Handle payment method selection
        const paymentMethods = document.querySelectorAll('.payment-method');
        let selectedPaymentMethod = 'gopay'; // Default payment method

        paymentMethods.forEach(method => {
            const radio = method.querySelector('input[type="radio"]');
            
            method.addEventListener('click', () => {
                // Remove selected class from all methods
                paymentMethods.forEach(opt => opt.classList.remove('selected'));
                // Add selected class to clicked method
                method.classList.add('selected');
                // Check the radio button
                radio.checked = true;
                // Update selected payment method
                selectedPaymentMethod = radio.value;
            });

            // Initialize selected state
            if (radio.checked) {
                method.classList.add('selected');
            }
        });

        // Initial total calculation
        const total = cartData.totalPrice + selectedDeliveryFee;
        document.getElementById('totalPayment').textContent = 'Rp ' + total.toLocaleString('id-ID');

        // Handle address option selection
        const addressOptions = document.querySelectorAll('.address-option');
        const customAddressForm = document.getElementById('customAddressForm');
        let selectedAddress = document.querySelector('input[name="address_type"]:checked').value;

        addressOptions.forEach(option => {
            const radio = option.querySelector('input[type="radio"]');
            
            option.addEventListener('click', () => {
                // Remove selected class from all options
                addressOptions.forEach(opt => opt.classList.remove('selected'));
                // Add selected class to clicked option
                option.classList.add('selected');
                // Check the radio button
                radio.checked = true;
                // Update selected address type
                selectedAddress = radio.value;
                
                // Show/hide custom address form
                if (selectedAddress === 'custom') {
                    customAddressForm.style.display = 'block';
                } else {
                    customAddressForm.style.display = 'none';
                }
            });

            // Initialize selected state
            if (radio.checked) {
                option.classList.add('selected');
                if (radio.value === 'custom') {
                    customAddressForm.style.display = 'block';
                }
            }
        });

        // Handle checkout button click
        const checkoutButton = document.getElementById('checkoutButton');
        const modal = document.getElementById('driverModal');
        const closeModalButton = document.getElementById('closeModal');
        
        // Random driver names and plates for demonstration
        const driverNames = [
            'Budi Santoso', 'Ahmad Rizki', 'Dedi Cahyono', 
            'Ratna Sari', 'Joko Widodo', 'Sinta Dewi'
        ];
        
        const vehiclePlates = [
            'B 1234 XYZ', 'B 5678 ABC', 'D 9012 EFG', 
            'F 3456 HIJ', 'T 7890 KLM', 'S 2345 NOP'
        ];
        
        checkoutButton.addEventListener('click', function() {
            // Validasi restaurant_id
            if (!cartData.restaurantId) {
                alert('Data restoran tidak valid. Silakan kembali ke halaman restoran dan coba lagi.');
                return;
            }
            
            // Disable the button to prevent multiple submissions
            checkoutButton.disabled = true;
            checkoutButton.textContent = 'processing...';
            
            // Randomly select driver and vehicle plate for demonstration
            const randomDriverIndex = Math.floor(Math.random() * driverNames.length);
            const driverName = driverNames[randomDriverIndex];
            const vehiclePlate = vehiclePlates[randomDriverIndex];
            
            // Update modal with driver info
            document.getElementById('modalDriverName').textContent = driverName;
            document.getElementById('modalVehiclePlate').textContent = vehiclePlate;
            
            // Tambahkan ini sebelum membuat orderData untuk debugging
            console.log('Cart Data Items:', cartData.items);

            // Get delivery address
            let deliveryAddress;
            if (selectedAddress === 'custom') {
                deliveryAddress = document.getElementById('customAddress').value.trim();
                if (!deliveryAddress) {
                    alert('Silakan masukkan alamat pengiriman');
                    checkoutButton.disabled = false;
                    checkoutButton.textContent = 'Beli dan antar sekarang';
                    return;
                }
            } else {
                deliveryAddress = "{{ $userAddress }}";
            }
            
            // Create order data
            const orderData = {
                restaurant_id: cartData.restaurantId,
                payment_method: selectedPaymentMethod,
                payment_total: total,
                delivery_type: selectedDeliveryType,
                delivery_cost: selectedDeliveryFee,
                delivery_address: deliveryAddress,
                items: Object.entries(cartData.items || {}).map(([key, item]) => ({
                    menu_id: parseInt(key),
                    quantity: item.quantity,
                    price: item.price
                })),
                driver_name: driverName,
                vehicle_plate: vehiclePlate,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            console.log('Order Data yang dikirim:', orderData);
            
            // Send order data to server
            fetch('/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(orderData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                // Tambahkan ini untuk debugging
                return response.text().then(text => {
                    console.log('Raw response:', text);
                    try {
                        const data = JSON.parse(text);
                        if (!response.ok) {
                            throw new Error(data.error || 'Unknown error');
                        }
                        return data;
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        throw new Error('Server returned invalid JSON: ' + text.substring(0, 100) + '...');
                    }
                });
            })
            .then(data => {
                // Show the driver info modal
                console.log('Success data:', data);
                modal.style.display = 'block';
                
                // Clear cart from session
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            })
            .catch(error => {
                console.error('Error detail:', error);
                alert('Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
                checkoutButton.disabled = false;
                checkoutButton.textContent = 'Beli dan antar sekarang';
            });
        });
        
        // Close modal and redirect to order status page
        closeModalButton.addEventListener('click', function() {
            modal.style.display = 'none';
            window.location.href = '/orders';
        });
    </script>
</body>
</html>