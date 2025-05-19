<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - GoFood Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/forgot-password_styles.css') }}">
    
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        <p>"Enter your email and new password to reset your account."</p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.reset.direct') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your registered email" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">New password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password" required onkeyup="checkPasswordStrength()">
                
                <div class="password-strength">
                    <div class="strength-segment" id="segment1"></div>
                    <div class="strength-segment" id="segment2"></div>
                    <div class="strength-segment" id="segment3"></div>
                    <div class="strength-segment" id="segment4"></div>
                </div>
                <div class="strength-text" id="strength-text">Password strength</div>
                
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirm new password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter new password" required>
                @error('password_confirmation')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit">Reset Password</button>
        </form>

        <div class="back-to-login">
            <a href="{{ route('login') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"></path><path d="M12 19l-7-7 7-7"></path>
                </svg>
                Go back to the login page
            </a>
        </div>
    </div>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthText = document.getElementById('strength-text');
            const segments = [
                document.getElementById('segment1'),
                document.getElementById('segment2'),
                document.getElementById('segment3'),
                document.getElementById('segment4')
            ];
            
            // Reset all segments
            segments.forEach(segment => {
                segment.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
            });
            
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            const strengthColor = [
                'rgba(255, 87, 87, 0.7)', 
                'rgba(255, 193, 7, 0.7)',  
                'rgba(76, 175, 80, 0.7)',
                'rgba(33, 150, 243, 0.7)'  
            ];
            
            const strengthLabel = ['Weak', 'Medium', 'Strong', 'Very Strong'];
            
            if (password.length > 0) {
                for (let i = 0; i < strength; i++) {
                    segments[i].style.backgroundColor = strengthColor[strength - 1];
                }
                strengthText.textContent = strengthLabel[strength - 1];
            } else {
                strengthText.textContent = 'Kekuatan password';
            }
        }
    </script>
</body>
</html>
