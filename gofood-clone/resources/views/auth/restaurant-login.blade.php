<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Login - GoFood Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- Asumsikan styling login_styles.css cocok juga untuk form ini --}}
    <link rel="stylesheet" href="{{ asset('css/login_styles.css') }}">
     <style>
        /* Optional: Tambahkan styling spesifik untuk membedakan jika perlu */
         .login-container h2 {
            color:#fff; /* Warna hijau Gojek/GoFood */
        }
         .login-container button {
             background-color:rgb(241, 255, 243); /* Warna hijau */
        }
         .login-container button:hover {
             background-color:rgb(166, 193, 166); /* Warna hijau lebih gelap saat hover */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Log in as Restaurant Admin</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('restaurant.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                 
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">
                Login as Restaurant
            </button>
        </form>

        @if($errors->any())
            
             @if(!$errors->has('email') && !$errors->has('password'))
                <p class="error">{{ $errors->first() }}</p>
             @endif
        @endif

        <div class="links-container">
           
            <div class="forgot-link">
                <a href="{{ route('password.request') }}">
                    Forgot password? 
                </a>
            </div>

            
            <div class="register-link">
                Don't have a restaurant account? <a href="{{ route('restaurant.register') }}">Register now</a> {{-- Atau tautan ke form registrasi restaurant --}}
            </div>
             
             <div class="register-link">
                <a href="{{ route('select.role') }}">
                    Select another role
                </a>
            </div>
        </div>
    </div>
</body>
</html>