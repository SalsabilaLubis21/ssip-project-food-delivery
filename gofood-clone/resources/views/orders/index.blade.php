@extends('layouts.app')

@section('styles')
 
    <link rel="stylesheet" href="{{ asset('css/lacak_styles.css') }}">
   <style>
    
   </style>

@endsection

@section('content')
<div class="orders-container">
    <div class="header-section">
        <a href="{{ route('dashboard') }}" class="back-button">
            <span class="icon">&larr;</span> Back to Dashboard
        </a>
        <h2 class="title">Your Order</h2>
    </div>

    <div class="nav-tabs">
        <a href="{{ route('orders.index') }}" class="nav-tab active">
            <span class="icon">🔄</span> Active Orders
            @php
                $activeCount = $orders->filter(function($order) {
                    return in_array(strtolower($order->status), ['pending', 'processing']);
                })->count();
            @endphp
            @if($activeCount > 0)
                <span class="badge">{{ $activeCount }}</span>
            @endif
        </a>
        <a href="{{ route('orders.history') }}" class="nav-tab">
            <span class="icon">📋</span> Order History
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $filteredOrders = $orders->filter(function($order) {
            return in_array(strtolower($order->status), ['pending', 'processing']);
        });
    @endphp

    @if($filteredOrders->isEmpty())
        <div class="alert alert-warning">
            <p>There are no orders with <strong>pending</strong> or <strong>processing</strong>status.</p>
        </div>
    @else
        <div class="order-cards">
            @foreach($filteredOrders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <div class="order-info">
                            <h3 class="order-id">Order ID: {{ $order->order_id }}</h3>
                            <span class="status {{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="order-card-body">
                        <p><strong>Restaurant:</strong> 
                            @if($order->restaurant)
                                {{ $order->restaurant->name }} 
                            @else
                                Restoran tidak ditemukan (ID: {{ $order->restaurant_id }})
                            @endif
                        </p>
                        <p><strong>Total Price:</strong> Rp {{ number_format($order->payment_total, 2) }}</p>
                        <p><strong>Delivery Address:</strong> 
                            @if(!empty($order->delivery_address))
                                {{ $order->delivery_address }}
                            @else
                                {{ $order->user ? $order->user->address : 'Alamat tidak ditemukan' }}
                            @endif
                        </p>
                        @if($order->driver)
                            <div class="driver-info">
                                <p><strong>Driver:</strong> {{ $order->driver->name }}</p>
                                <p><strong>Vehicle Plate:</strong> {{ $order->driver->vehicle_plate }}</p>
                            </div>
                        @else
                            <p><strong>Driver:</strong> Driver belum ditugaskan</p>
                        @endif

                        <p><strong>Payment Status:</strong> <span class="status {{ strtolower($order->payment_status) }}">
    {{ ucfirst($order->payment_status) }}
</span></p>
<p><strong>Delivery Status:</strong> <span class="status {{ strtolower($order->delivery_status) }}">
    {{ ucfirst($order->delivery_status) }}
</span></p>

                        <div class="menu-items">
                            <p><strong>Ordered Menu:</strong></p>
                            @if($order->orderdetail->isNotEmpty())
    <ul class="order-menu-list">
        @foreach($order->orderdetail as $detail)
            <li>{{ optional($detail->menu)->name ?? 'Menu Tidak Ditemukan' }} 
                ({{ $detail->quantity }}x) - Rp {{ number_format($detail->price, 0, ',', '.') }}</li>
        @endforeach
    </ul>
@else
    <p>No menu details</p>
@endif

                        </div>
                    </div>
                    <div class="order-card-footer">
                        @if(in_array(strtolower($order->status), ['pending', 'processing']))
                        <form method="POST" action="{{ route('orders.cancel', ['order' => $order]) }}">
    @csrf
    <button type="submit" class="btn btn-danger">Cancel</button>
</form>

                        @elseif(strtolower($order->status) === 'completed' && $order->restaurant)
                            <button type="button" class="btn btn-primary review-button" 
                                    data-restaurant-id="{{ $order->restaurant_id }}" 
                                    data-restaurant-name="{{ $order->restaurant->name }}">
                                
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Review -->
<div id="reviewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3>Review Restoran <span id="restaurantNameModal"></span></h3>
        
        <form id="reviewForm" method="POST" action="{{ route('reviews.store') }}">
            @csrf
            <input type="hidden" name="restaurant_id" id="restaurantIdInput">
            
            <div class="form-group">
                <label for="rating">Rating:</label>
                <div class="rating-select">
                    <span class="rating-star" data-rating="1">★</span>
                    <span class="rating-star" data-rating="2">★</span>
                    <span class="rating-star" data-rating="3">★</span>
                    <span class="rating-star" data-rating="4">★</span>
                    <span class="rating-star" data-rating="5">★</span>
                </div>
                <input type="hidden" name="rating" id="ratingInput" required>
            </div>
            
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea name="comment" id="commentInput" rows="4" required></textarea>
            </div>
            
            <button type="submit" class="btn-submit">Submit Review</button>
        </form>
    </div>
</div>

<script>
 
    const modal = document.getElementById('reviewModal');
    const closeModal = document.querySelector('.close-modal');
    const restaurantNameModal = document.getElementById('restaurantNameModal');
    const restaurantIdInput = document.getElementById('restaurantIdInput');
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('ratingInput');
    
    
    document.querySelectorAll('.review-button').forEach(button => {
        button.addEventListener('click', function() {
            const restaurantId = this.getAttribute('data-restaurant-id');
            const restaurantName = this.getAttribute('data-restaurant-name');
            
           
            restaurantNameModal.textContent = restaurantName;
            restaurantIdInput.value = restaurantId;
            
          
            ratingStars.forEach(star => star.classList.remove('selected'));
            ratingInput.value = '';
            
            
            modal.style.display = 'flex';
        });
    });
    
   
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
   
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
   
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            ratingInput.value = rating;
            
            
            ratingStars.forEach(s => {
                if (parseInt(s.getAttribute('data-rating')) <= rating) {
                    s.classList.add('selected');
                } else {
                    s.classList.remove('selected');
                }
            });
        });
        
        // Hover effect
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            
            ratingStars.forEach(s => {
                if (parseInt(s.getAttribute('data-rating')) <= rating) {
                    s.style.color = '#FFD700';
                }
            });
        });
        
        star.addEventListener('mouseout', function() {
            ratingStars.forEach(s => {
                if (!s.classList.contains('selected')) {
                    s.style.color = '#ddd';
                }
            });
        });
    });
</script>
@endsection