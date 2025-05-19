<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Login - GoFood Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/login_styles.css') }}"> 
    <style>
        
        .login-container h2 {
            color:#fff; 
        }
        .login-container button {
             background-color:rgb(255, 255, 255); 
        }
         .login-container button:hover {
             background-color:rgb(204, 222, 204); 
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Log in as a Driver</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        
        <form method="POST" action="{{ route('driver.login') }}"> 
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

    
    <input type="hidden" name="guard" value="driver">

    <button type="submit">
        Login as Driver
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
                Don't have a driver account? <a href="{{ route('driver.register.process') }}">Register now</a> {{-- Atau tautan ke form registrasi driver --}}
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