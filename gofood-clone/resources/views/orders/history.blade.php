@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/lacak_styles.css') }}">
    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            position: relative;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .close-modal {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #666;
            transition: color 0.2s;
            z-index: 1001;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
        }
        
        .close-modal:hover {
            color: #000;
            background-color: #f0f0f0;
        }
    </style>
@endsection

@section('content')
<div class="orders-container">
    <div class="header-section">
        <a href="{{ route('dashboard') }}" class="back-button">
            <span class="icon">&larr;</span> Back to Dashboard
        </a>
        <h2 class="title">Order History</h2>
    </div>

    <div class="nav-tabs">
        <a href="{{ route('orders.index') }}" class="nav-tab">
            <span class="icon">🔄</span> Active Orders
        </a>
        <a href="{{ route('orders.history') }}" class="nav-tab active">
            <span class="icon">📋</span> Order History
            @if($completedOrders->count() > 0)
                <span class="badge">{{ $completedOrders->count() }}</span>
            @endif
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

    @if($completedOrders->isEmpty())
        <div class="alert alert-warning">
            <p>No order history.</p>
        </div>
    @else
        <div class="order-cards">
            @foreach($completedOrders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <div class="order-info">
                            <h3 class="order-id">Order ID : {{ $order->order_id }}</h3>
                            <span class="status {{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <div class="order-time">
                                {{ date('d M Y, H:i', strtotime($order->order_time)) }}
                            </div>
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
                        <p><strong>Delivery Address:</strong> {{ $order->user ? $order->user->address : 'Alamat tidak ditemukan' }}</p>
                        
                        @if($order->driver)
                            <div class="driver-info">
                                <p><strong>Driver:</strong> {{ $order->driver->name }}</p>
                                <p><strong>Vehicle plate:</strong> {{ $order->driver->vehicle_plate }}</p>
                            </div>
                        @else
                            <p><strong>Driver:</strong> Driver belum ditugaskan</p>
                        @endif

                        <div class="menu-items">
                            <p><strong>Ordered Menu:</strong></p>
                            @if($order->orderDetails && $order->orderDetails->count() > 0)
                                <ul class="order-menu-list">
                                    @foreach($order->orderDetails as $detail)
                                        <li>
                                            @if($detail->menu)
                                                {{ $detail->menu->name }} 
                                            @else
                                                Menu #{{ $detail->menu_id }}
                                            @endif
                                            ({{ $detail->quantity }}x) - Rp {{ number_format($detail->price, 0, ',', '.') }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No menu details</p>
                            @endif
                        </div>
                    </div>
                    <div class="order-card-footer">
                        @php
                            $hasReviewed = \App\Models\RestaurantReview::where('user_id', Auth::id())
                                            ->where('restaurant_id', $order->restaurant_id)
                                            ->exists();
                        @endphp

                        @if($hasReviewed)
                            <span class="already-reviewed">✓ Already reviewed</span>
                        @else
                            <button type="button" class="btn btn-primary review-button" 
                                    onclick="openReviewModal('{{ $order->restaurant_id }}', '{{ $order->restaurant ? $order->restaurant->name : 'Restoran #'.$order->restaurant_id }}')"
                                    data-restaurant-id="{{ $order->restaurant_id }}" 
                                    data-restaurant-name="{{ $order->restaurant ? $order->restaurant->name : 'Restoran #'.$order->restaurant_id }}">
                                Give a Review
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
            
            <button type="submit" class="btn-submit">Send Review</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/history_script.js') }}"></script>
@endsection