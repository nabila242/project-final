<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Supply Chain Risk Intelligence</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #271a0c;
            --primary-accent: #f59e0b;
            --text-main: #ffffff;
            --glass-bg: rgba(61, 43, 20, 0.6);
            --glass-border: rgba(255, 255, 255, 0.15);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            background-image: 
                radial-gradient(circle at top left, rgba(245, 158, 11, 0.2), transparent 40%),
                radial-gradient(circle at bottom right, rgba(180, 83, 9, 0.2), transparent 40%),
                url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .glass-nav {
            background: rgba(39, 26, 12, 0.8);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--glass-border);
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.2;
            background: linear-gradient(90deg, #fcd34d, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 300;
            color: #e4e4e7;
            margin-bottom: 2.5rem;
        }

        .btn-glow {
            background: linear-gradient(90deg, #f59e0b, #d97706);
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.6);
            color: #fff;
        }

        .feature-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            transition: transform 0.4s ease, border-color 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-accent);
            margin-bottom: 1.5rem;
        }
        
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg glass-nav fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="/">
                <i class="fa-solid fa-earth-americas text-warning me-2"></i> SCRI Platform
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 z-1">
                    <h1 class="hero-title">Global Supply Chain Risk Intelligence</h1>
                    <p class="hero-subtitle mx-auto" style="max-width: 700px;">
                        Platform untuk memantau risiko rantai pasok global dengan mengintegrasikan data cuaca, ekonomi, kurs mata uang, berita, dan pelabuhan dalam satu dashboard.
                    </p>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="/login" class="btn btn-glow rounded-pill px-5">
                            Masuk ke Sistem (Login) <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 text-center">
        <a href="{{ route('login') }}" class="text-muted text-decoration-none small"><i class="fa-solid fa-lock me-1"></i> Admin Access</a>
    </footer>

</body>
</html>
