<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SCRI Platform</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #271a0c;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at center, rgba(245, 158, 11, 0.15), transparent 60%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-card {
            background: rgba(39, 26, 12, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
        }
        .form-control {
            background-color: rgba(0,0,0,0.3) !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
            color: white !important;
            border-radius: 10px;
            padding: 12px 15px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25);
            border-color: #f59e0b !important;
        }
        .btn-glow {
            background: linear-gradient(90deg, #f59e0b, #d97706);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        }
    </style>
</head>
<body>

    <div class="glass-card text-white">
        <div class="text-center mb-4">
            <i class="fa-solid fa-shield-halved fa-3x text-warning mb-3"></i>
            <h3 class="fw-bold">Admin Portal</h3>
            <p class="text-muted">Secure Access Only</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220,53,69,0.5); color: #ffb3b3;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label text-muted small text-uppercase fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', 'admin@example.com') }}" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted small text-uppercase fw-bold">Password</label>
                <input type="password" name="password" class="form-control" value="password" required>
            </div>
            <button type="submit" class="btn btn-glow w-100 text-white mb-3">Login to System</button>
            
            <div class="text-center">
                <a href="{{ route('register') }}" class="text-warning text-decoration-none small">Don't have an account? Register here</a>
            </div>
        </form>
        
        <div class="text-center mt-4">
            <a href="/" class="text-muted text-decoration-none small"><i class="fa-solid fa-arrow-left me-1"></i> Back to Home</a>
        </div>
    </div>

</body>
</html>
