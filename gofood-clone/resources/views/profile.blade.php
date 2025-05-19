<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - GoFood Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f7f8f9;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .navbar {
            background-color: #00AA13;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .navbar-brand {
            color: white;
            font-size: 22px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand span {
            margin-left: 8px;
        }
        
        .navbar-nav {
            display: flex;
            list-style: none;
            gap: 20px;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
            font-size: 14px;
            padding: 8px 15px;
            border-radius: 20px;
        }
        
        .nav-link:hover {
            opacity: 0.9;
            background-color: rgba(255,255,255,0.1);
        }
        
        .nav-link.active {
            background-color: rgba(255,255,255,0.2);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: #555;
            text-decoration: none;
            margin-top: 20px;
            margin-bottom: 20px;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        .back-link:hover {
            color: #00AA13;
        }
        
        .back-link svg {
            margin-right: 8px;
        }
        
        .profile-header {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            background-color: #00AA13;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            color: white;
            flex-shrink: 0;
        }
        
        .profile-info h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #333;
        }
        
        .profile-info p {
            color: #666;
            font-size: 14px;
        }
        
        .profile-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .card-tabs {
            display: flex;
            border-bottom: 1px solid #eee;
        }
        
        .card-tab {
            flex: 1;
            text-align: center;
            padding: 15px;
            font-weight: 500;
            color: #555;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .card-tab.active {
            color: #00AA13;
            font-weight: 600;
        }
        
        .card-tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #00AA13;
        }
        
        .tab-content {
            display: none;
            padding: 25px;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #00AA13;
            box-shadow: 0 0 0 3px rgba(0,170,19,0.1);
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-col {
            flex: 1;
            min-width: 250px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #00AA13;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .btn:hover {
            background-color: #008f10;
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .password-strength {
            margin-top: 8px;
            display: flex;
            gap: 5px;
        }
        
        .strength-segment {
            flex: 1;
            height: 5px;
            background-color: #eee;
            border-radius: 3px;
        }
        
        .strength-text {
            font-size: 12px;
            margin-top: 5px;
            color: #777;
        }
        
        footer {
            background-color: #333;
            color: #ddd;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .navbar-nav {
                gap: 10px;
            }
            
            .nav-link {
                padding: 6px 10px;
                font-size: 13px;
            }
            
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .container {
                padding: 10px;
            }

            .delete-account-section {
    background-color: #fff3f3;
    border: 1px solid #ffd0d0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.delete-account-section h3 {
    color: #dc3545;
    margin-bottom: 15px;
}
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="/" class="navbar-brand">
                <span>GoFood Clone 🍽</span>
            </a>
            <ul class="navbar-nav">
                <li><a href="/restaurants" class="nav-link">Restaurant</a></li>
                <li><a href="/orders" class="nav-link">Order</a></li>
                <li><a href="/profile" class="nav-link active">Profile</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5"></path>
                <path d="M12 19l-7-7 7-7"></path>
            </svg>
            Back to Dashboard
        </a>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0 0 0 15px; padding: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="profile-header">
            <div class="profile-avatar">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="profile-info">
                <h1>{{ Auth::user()->name }}</h1>
                <p>{{ Auth::user()->email }}</p>
            </div>
        </div>
        
        <div class="profile-card">
            <div class="card-tabs">
                <div class="card-tab active" data-tab="info">Profile Information</div>
                <div class="card-tab" data-tab="password">Change Password</div>
            </div>
            
            <div class="tab-content active" id="info-tab">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" placeholder="Enter your full name">
                            </div>
                        </div>
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="email@example.com">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}" placeholder="08xxxxxxxxxx">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your full address">{{ Auth::user()->address }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-block">Save Changes</button>
                </form>
            </div>
            
            <div class="tab-content" id="password-tab">
                <form action="{{ route('profile.update.password') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" onkeyup="checkPasswordStrength()">
                        
                        <div class="password-strength">
                            <div class="strength-segment" id="segment1"></div>
                            <div class="strength-segment" id="segment2"></div>
                            <div class="strength-segment" id="segment3"></div>
                            <div class="strength-segment" id="segment4"></div>
                        </div>
                        <div class="strength-text" id="strength-text">Password strength</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">confirm new Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter new password again">
                    </div>
                    
                    <button type="submit" class="btn btn-block">Update Password</button>
                </form>
            </div>

            <div class="tab-content" id="delete-tab">
    <div class="delete-account-section">
        <h3 class="text-danger mb-3">Delete Account</h3>
        <p class="text-muted">Warning: This action cannot be undone. All your data will be permanently removed.</p>
        
        <form action="{{ route('profile.delete') }}" method="POST" id="delete-account-form">
            @csrf
            @method('DELETE')
            
            <div class="form-group">
                <label class="form-label" for="delete_confirmation">Type "DELETE" to confirm</label>
                <input type="text" class="form-control" id="delete_confirmation" name="delete_confirmation" placeholder="Type DELETE to confirm">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="current_password_delete">Current Password</label>
                <input type="password" class="form-control" id="current_password_delete" name="current_password_delete" placeholder="Enter your current password">
            </div>
            
            <button type="submit" class="btn btn-danger btn-block mt-3" id="delete-account-btn" disabled>
                Permanently Delete My Account
            </button>
        </form>
    </div>
</div>
        </div>
    </div>
    
    <footer>
        <div class="container">
        <p>🚀 GoFood Clone - Laravel Blade | &copy; {{ date('Y') }}</p>
        </div>
    </footer>

 <script>
    document.addEventListener('DOMContentLoaded', function() {

        
        window.checkPasswordStrength = function() {
            const password = document.getElementById('password').value;
            const strengthText = document.getElementById('strength-text');
            const segments = [
                document.getElementById('segment1'),
                document.getElementById('segment2'),
                document.getElementById('segment3'),
                document.getElementById('segment4')
            ];

            segments.forEach(segment => {
                segment.style.backgroundColor = '#eee';
            });

            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            const strengthColor = [
                '#f44336',
                '#ff9800', 
                '#4caf50', 
                '#2196f3'  
            ];

            const strengthLabel = ['Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];

            if (password.length > 0) {
                for (let i = 0; i < strength; i++) {
                    segments[i].style.backgroundColor = strengthColor[strength - 1];
                }
                strengthText.textContent = strengthLabel[strength - 1];
                strengthText.style.color = strengthColor[strength - 1];
            } else {
                strengthText.textContent = 'Kekuatan password';
                strengthText.style.color = '#777';
            }
        };
        


        const deleteConfirmationInput = document.getElementById('delete_confirmation');
        const deleteAccountBtn = document.getElementById('delete-account-btn');

        
        const cardTabs = document.querySelector('.card-tabs');
        const deleteTab = document.createElement('div');
        deleteTab.classList.add('card-tab');
        deleteTab.setAttribute('data-tab', 'delete');
        deleteTab.textContent = 'Delete Account';
        cardTabs.appendChild(deleteTab);

        

        
        if (deleteConfirmationInput && deleteAccountBtn) { // Tambahkan cek null untuk keamanan
            deleteConfirmationInput.addEventListener('input', function() {
                deleteAccountBtn.disabled = this.value.toUpperCase() !== 'DELETE';
            });
        }

        
         const deleteAccountForm = document.getElementById('delete-account-form');
        if (deleteAccountForm) {
            deleteAccountForm.addEventListener('submit', function(e) {
                const confirmDelete = confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.');
                if (!confirmDelete) {
                    e.preventDefault();
                }
            });
        }
       
        const tabs = document.querySelectorAll('.card-tab'); 
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const tabName = this.getAttribute('data-tab');

                tabContents.forEach(content => {
                    content.classList.remove('active');
                });

                const targetTabContent = document.getElementById(tabName + '-tab');
                if (targetTabContent) { 
                    targetTabContent.classList.add('active');
                }
            });
        });

        
        const activeTab = document.querySelector('.card-tab.active');
        const activeContent = document.querySelector('.tab-content.active');

        if (!activeTab && tabs.length > 0) {
             
             tabs[0].classList.add('active');
             const firstTabName = tabs[0].getAttribute('data-tab');
             const firstTabContent = document.getElementById(firstTabName + '-tab');
             if(firstTabContent) {
                 firstTabContent.classList.add('active');
             }
        } else if (activeTab && activeContent) {
          
             const activeTabName = activeTab.getAttribute('data-tab');
             const expectedContentId = activeTabName + '-tab';
             if (activeContent.id !== expectedContentId) {
                 activeContent.classList.remove('active');
                 const correctActiveContent = document.getElementById(expectedContentId);
                 if(correctActiveContent) {
                     correctActiveContent.classList.add('active');
                 }
             }
        } else if (activeTab && !activeContent) {
            
             const activeTabName = activeTab.getAttribute('data-tab');
             const correctActiveContent = document.getElementById(activeTabName + '-tab');
             if(correctActiveContent) {
                 correctActiveContent.classList.add('active');
             }
        }
         


    }); 
</script>
</body>
</html> 