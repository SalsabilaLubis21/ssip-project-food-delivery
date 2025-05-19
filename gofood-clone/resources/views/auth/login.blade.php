<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoFood Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login_styles.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>Log in to the GoFood Clone</h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
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
                Login
            </button>
        </form>

        @if($errors->any())
            <p class="error">{{ $errors->first('login') }}</p>
        @endif

        <div class="links-container">
            <div class="forgot-link">
                <a href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            </div>
            
            <div class="register-link">
                Don't have an account? <a href="{{ route('user.register.process') }}">Register now</a>
            </div>
        </div>
    </div>
</body>
</html>
