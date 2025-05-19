<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - GoFood Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register_styles.css') }}">
</head>
<body>
    <div class="register-container">
        <div class="header">
            <h2>Sign up for an account</h2>
            <p>Please fill out the form below to sign up</p>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('driver.register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
    <label for="vehicle_plate">Vehicle Plate</label>
    <input type="text" id="vehicle_plate" name="vehicle_plate" value="{{ old('vehicle_plate') }}" required>
    @error('vehicle_plate')
        <div class="error">{{ $message }}</div>
    @enderror
</div>


            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <form action="{{ route('driver.register') }}" method="POST">
    @csrf
    <button type="submit">Register Now</button>
</form>


        <div class="login-link">
        Already have an account? <a href="{{ route('driver.login') }}">Login Here</a>
        </div>
    </div>
</body>
</html> 