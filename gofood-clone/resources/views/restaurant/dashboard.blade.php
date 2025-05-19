<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoPartner Lite - Terima Pesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --gojek-green: #00AA13;
            --gojek-green-dark: #008c10;
            --gojek-green-light: #e6f8e7; 
            --gojek-red: #D91B1B;
            --gojek-red-dark: #b81717;
            --grey-lightest: #f8f9fa;
            --grey-light: #f1f3f5;
            --grey-medium: #dee2e6;
            --grey-dark: #6c757d;
            --text-dark: #212529;
            --text-light: #fff;
            --warning-orange: #fd7e14; 
            --processing-blue: #007bff;
            --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            --card-shadow-hover: 0 8px 20px rgba(0, 0, 0, 0.12);
            --border-radius: 10px; 
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--grey-lightest); 
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 230px; 
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%); 
            padding: 25px 15px;
            box-shadow: 3px 0 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--grey-medium);
            transition: width var(--transition-speed) ease;
            position: sticky; 
            top: 0;
            height: 100vh;
        }

        .sidebar .logo {
            font-size: 1.7em;
            font-weight: 800; 
            color: var(--gojek-green);
            margin-bottom: 40px;
            text-align: center;
            padding: 10px 0;
        }
         .sidebar .logo i {
            margin-right: 10px;
            transform: scale(1.1); 
         }

        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar nav ul li a {
            display: flex;
            align-items: center;
            padding: 14px 20px; 
            color: var(--grey-dark);
            text-decoration: none;
            border-radius: var(--border-radius);
            margin-bottom: 10px;
            transition: all var(--transition-speed) ease;
            font-weight: 500;
            position: relative;
            overflow: hidden; 
        }
         .sidebar nav ul li a i {
            margin-right: 12px;
            width: 22px;
            text-align: center;
            font-size: 1.1em; 
         }

        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background-color: var(--gojek-green);
            color: var(--text-light);
            transform: translateX(5px); 
            box-shadow: 0 4px 10px rgba(0, 170, 19, 0.2);
        }
      
         .sidebar nav ul li a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px;
            background-color: var(--gojek-green-dark);
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
         }


        .sidebar .logout-section {
            margin-top: auto;
            padding: 15px 0;
        }

        .main-content {
            flex-grow: 1;
            padding: 35px; 
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: var(--text-dark);
            font-size: 2.2em; 
            font-weight: 700;
            display: flex;
            align-items: center;
        }
        .header h1 i {
            margin-right: 15px;
            color: var(--gojek-green);
            font-size: 1.2em;
        }

       
        .order-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); 
            gap: 30px; 
        }

        .order-card {
            background-color: #fff;
            border: 1px solid var(--grey-medium);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            display: flex;
            flex-direction: column;
            transition: all var(--transition-speed) ease;
            overflow: hidden;
            position: relative; 
        }
        .order-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-5px);
        }

        
        .order-card--pending {
            border-left: 6px solid var(--warning-orange); 
            background-color: #fff; 
        }
         .order-card--pending .order-card-header {
            background-color: #fff; 
         }
         .order-card--pending .order-actions .btn-primary {
             
             font-size: 1em;
             padding: 12px 22px;
             box-shadow: 0 4px 12px rgba(0, 170, 19, 0.3);
         }
         .order-card--pending .order-actions .btn-primary:hover {
             box-shadow: 0 6px 15px rgba(0, 170, 19, 0.4);
         }

         
         .order-card:not(.order-card--pending) {
       
            opacity: 0.85; 
         }
          .order-card:not(.order-card--pending):hover {
             opacity: 1;
          }
         .order-card:not(.order-card--pending) .order-card-header {
            background-color: var(--grey-light);
         }


        .order-card-header {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--grey-medium);
            transition: background-color var(--transition-speed) ease;
        }
        .order-card-header h3 {
            margin: 0;
            font-size: 1.2em;
            font-weight: 700; 
            color: var(--text-dark);
        }
        .order-card-header .order-time {
            font-size: 0.9em;
            color: var(--grey-dark);
            display: flex;
            align-items: center;
        }
         .order-card-header .order-time i {
            margin-right: 5px;
            font-size: 1.1em;
         }

        .order-card-body {
            padding: 20px;
            flex-grow: 1;
        }
        .order-card-body p {
            margin: 0 0 12px 0;
            font-size: 0.95em;
            line-height: 1.6;
            color: var(--grey-dark);
             display: flex;
             align-items: center;
        }
         .order-card-body p i {
             margin-right: 8px;
             width: 16px; /* Align icons */
             text-align: center;
             color: var(--gojek-green);
         }
        .order-card-body p strong {
             color: var(--text-dark);
             font-weight: 600;
             margin-right: 5px;
        }

        .item-list {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed var(--grey-medium);
        }
        .item-list p.item-title {
            font-size: 1em;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
             display: flex;
             align-items: center;
        }
        .item-list p.item-title i {
            color: var(--gojek-green);
            margin-right: 8px;
        }

        .item-list ul {
            list-style: none;
            padding-left: 5px; 
            margin: 0;
        }
        .item-list li {
            font-size: 0.95em; 
            margin-bottom: 8px;
            color: var(--text-dark);
            display: flex;
            justify-content: space-between;
            align-items: center; 
            padding: 5px 0;
        }
         .item-list li:not(:last-child) {
             border-bottom: 1px solid var(--grey-light);
         }
         .item-list li .item-name {
            flex-grow: 1;
            margin-right: 10px;
            color: var(--grey-dark);
         }
         .item-list li .item-name span { 
             font-weight: 600;
             color: var(--text-dark);
             margin-right: 5px;
             display: inline-block;
             min-width: 20px; 
             text-align: right;
         }
         .item-list li .item-price {
            white-space: nowrap;
            font-weight: 600;
            color: var(--text-dark);
            min-width: 80px; 
            text-align: right;
         }


        .order-card-footer {
            padding: 15px 20px;
            background-color: var(--grey-lightest); 
            border-top: 1px solid var(--grey-medium);
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 65px; 
        }


        
        .status {
            padding: 6px 14px;
            border-radius: 20px; 
            font-size: 0.85em;
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            transition: all var(--transition-speed) ease;
        }
         .status i {
             margin-right: 6px;
             font-size: 0.9em;
         }

        .status-pending {
            background-color: var(--warning-orange);
            color: var(--text-light); 
             box-shadow: 0 2px 5px rgba(253, 126, 20, 0.3);
        }
        .status-processing {
            background-color: var(--processing-blue);
            color: var(--text-light);
            box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
        }
        


        .btn {
            border: none;
            padding: 10px 18px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 0.95em; 
            font-weight: 600;
            transition: all var(--transition-speed) ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            line-height: 1.5;
        }
        .btn i {
            margin-right: 8px;
             font-size: 1.1em; 
        }

        .btn-primary {
            background-color: var(--gojek-green);
            color: var(--text-light);
        }
        .btn-primary:hover {
            background-color: var(--gojek-green-dark);
            transform: translateY(-2px); 
            box-shadow: 0 4px 10px rgba(0, 170, 19, 0.3);
        }

        .btn-danger {
            background-color: transparent;
            color: var(--gojek-red);
            border: 1px solid transparent;
            width: 100%;
            justify-content: flex-start;
            padding: 12px 20px;
        }
        .btn-danger:hover {
            background-color: rgba(217, 27, 27, 0.05);
             border-color: rgba(217, 27, 27, 0.1);
             color: var(--gojek-red-dark);
        }

        .btn-disabled {
            background-color: var(--grey-medium);
            color: var(--grey-dark);
            cursor: not-allowed;
            padding: 12px 22px; 
             border-radius: var(--border-radius);
             font-size: 1em;
             font-weight: 600;
             display: inline-flex;
             align-items: center;
             box-shadow: none;
             opacity: 0.7;
        }
         .btn-disabled i {
            margin-right: 8px;
            font-size: 1.1em;
         }

        .alert {
            padding: 18px 20px; 
            margin-bottom: 25px;
            border: none;
            border-left: 5px solid; 
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            font-size: 1em;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        }
         .alert i {
            margin-right: 12px;
            font-size: 1.4em; 
         }
        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: var(--gojek-green);
            
             & i { color: var(--gojek-green); }
        }
        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: var(--gojek-red);
            & i { color: var(--gojek-red); }
        }
         .alert-info { 
             color: #0c5460;
             background-color: #d1ecf1;
             border-color: #007bff; 
             & i { color: #007bff; }
         }

        
        @media (max-width: 1200px) {
            .order-list {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }
        }
         @media (max-width: 992px) {
            .sidebar {
                 width: 70px; 
                 overflow: hidden;
             }
             .sidebar .logo span,
             .sidebar nav ul li a span,
             .sidebar .logout-section .btn span {
                 display: none; /* Hide text */
             }
              .sidebar .logo { font-size: 1.8em; } 
              .sidebar nav ul li a,
              .sidebar .logout-section .btn { justify-content: center; } /* Center icons */
              .sidebar nav ul li a i,
              .sidebar .logout-section .btn i { margin-right: 0; } /* No margin for icon */

             .main-content {
                 padding: 25px;
             }
         }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                border-right: none;
                border-bottom: 1px solid var(--grey-medium);
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding: 10px 15px;
                 position: static; 
            }
            .sidebar .logo {
                margin-bottom: 0;
                font-size: 1.5em;
                padding: 0;
                 & span { display: inline; } 
            }
             .sidebar nav { display: none; } 
            .sidebar .logout-section {
                margin-top: 0;
                 padding: 0;
            }
            .btn-danger {
                 width: auto;
                 padding: 8px 10px;
                 border: none;
                 background-color: transparent;
                 color: var(--gojek-red);
            }
             .btn-danger:hover { background-color: transparent; color: var(--gojek-red-dark); }
             .btn-danger i { margin-right: 0; font-size: 1.3em; } /* Icon only */
             .btn-danger span { display: none; }


            .main-content {
                padding: 20px;
            }
            .header h1 { font-size: 1.8em; }
            .order-list {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .order-card:hover { transform: none; } 
            .order-card--pending .order-actions .btn-primary { font-size: 0.95em; padding: 10px 18px; } /* Slightly smaller button */
             .btn-disabled { font-size: 0.95em; padding: 10px 18px; }
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-motorcycle"></i> <span>GoPartner</span>
        </div>
        <nav>
            <ul>
            <li><a href="{{ route('restaurant.dashboard') }}"><i class="fas fa-receipt"></i> <span>New Order</span></a></li> {{-- Sesuaikan route --}}
            <li><a href="{{ route('history') }}"><i class="fas fa-history"></i> <span>History</span></a></li> {{-- Tambahkan <li> dan ikon --}}

            </ul>
        </nav>
        <div class="logout-section">
             <form action="{{ route('restaurant.logout') }}" method="POST" style="margin:0;">
                 @csrf
                 <button type="submit" class="btn btn-danger">
                     <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                 </button>
             </form>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-concierge-bell"></i> Incoming Orders</h1>
            </div>

        @if (session('success'))
            <div class="alert alert-success">
                 <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                 <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        @if(isset($orders) && $orders->isNotEmpty())
            <div class="order-list">
                 
                @foreach ($orders as $order)
                    <div class="order-card {{ $order->status === 'pending' ? 'order-card--pending' : '' }}">
                        <div class="order-card-header">
                            <h3>Order #{{ $order->order_id }}</h3>
                            <span class="order-time">
                                <i class="far fa-clock"></i> {{ $order->order_time->format('H:i') }} </span>
                        </div>
                        <div class="order-card-body">
                             <p><i class="fas fa-user"></i> <strong>Customer:</strong> {{ $order->user->name ?? 'Tamu' }}</p>
                             
                             
                             <p><i class="fas fa-money-bill-wave"></i> <strong>Total:</strong> Rp {{ number_format($order->payment_total, 0, ',', '.') }}</p>

                             <div class="item-list">
                                 <p class="item-title"><i class="fas fa-shopping-basket"></i> Order Item:</p>
                                 <ul>
                                     @foreach ($order->items as $item)
                                         <li>
                                             <span class="item-name"><span>{{ $item->quantity }}x</span> {{ $item->menu->name ?? 'Item is unknown' }}</span>
                                             <span class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                         </li>
                                     @endforeach
                                 </ul>
                             </div>
                        </div>
                         <div class="order-card-footer">
                          
                            <div class="status status-{{ strtolower(str_replace(' ', '', $order->status)) }}">
                                @if($order->status === 'pending')
                                    <i class="fas fa-bell"></i> @elseif($order->status === 'processing')
                                     <i class="fas fa-spinner fa-spin"></i>
                                @else
                                     <i class="fas fa-info-circle"></i>
                                @endif
                                {{ $order->status === 'pending' ? 'NEW' : $order->status }} </div>

                             {{-- Action Button --}}
                             <div class="order-actions">
                                 @if ($order->status === 'pending')
                                     <form action="{{ route('order.process', ['order' => $order->order_id]) }}" method="POST" style="margin:0;">
                                         @csrf
                                         <button type="submit" class="btn btn-primary">
                                             <i class="fas fa-check-circle"></i> Accept Order
                                         </button>
                                     </form>
                                 @else
                                     <button class="btn-disabled" disabled>
                                         <i class="fas fa-hourglass-half"></i> Processing
                                     </button>
                                 @endif
                             </div>
                         </div>
                    </div>
                @endforeach
            </div>
        @else
             <div class="alert alert-info"> <i class="fas fa-coffee"></i> Currently, there are no new orders. It's time to relax for a moment!
             </div>
        @endif
    </div>

</body>
</html>