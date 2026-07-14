<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Supply Chain Risk Intelligence</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #271a0c;
            --bg-card: rgba(61, 43, 20, 0.7);
            --primary-accent: #f59e0b;
            --text-main: #ffffff;
            --text-muted: #e4e4e7;
            --glass-border: rgba(255, 255, 255, 0.25);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            background-image: radial-gradient(circle at top right, rgba(245, 158, 11, 0.15), transparent 40%),
                              radial-gradient(circle at bottom left, rgba(180, 83, 9, 0.15), transparent 40%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(39, 26, 12, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            padding: 2rem 1rem;
            z-index: 1000;
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, #fcd34d, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
            display: block;
            text-align: center;
        }

        .nav-link {
            color: var(--text-muted);
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff;
            background: rgba(245, 158, 11, 0.15);
            border-left: 4px solid var(--primary-accent);
        }

        .nav-link i {
            width: 24px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
        }

        /* Dashboard Metrics */
        .metric-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .metric-label {
            color: var(--text-muted);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .text-success { color: #10b981 !important; }
        .text-danger { color: #ef4444 !important; }
        .text-warning { color: #f59e0b !important; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* Map Containers */
        #weatherMap, #portMap {
            height: 400px;
            border-radius: 12px;
            z-index: 1;
        }

        /* Loading Overlay */
        #loader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(39, 26, 12, 0.9);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            transition: opacity 0.5s;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div id="loader">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="sidebar">
        <a href="#" class="sidebar-brand text-decoration-none">
            <i class="fa-solid fa-earth-americas me-2"></i>SCRI Platform
        </a>
        <div class="nav flex-column">
            <a href="#dashboard" class="nav-link active" data-bs-toggle="tab">
                <i class="fa-solid fa-chart-line"></i> Global Dashboard
            </a>
            <a href="#weather" class="nav-link" data-bs-toggle="tab">
                <i class="fa-solid fa-cloud-bolt"></i> Weather Risk
            </a>
            <a href="#currency" class="nav-link" data-bs-toggle="tab">
                <i class="fa-solid fa-coins"></i> Currency Impact
            </a>
            <a href="#news" class="nav-link" data-bs-toggle="tab">
                <i class="fa-solid fa-newspaper"></i> News Intelligence
            </a>
            <a href="#ports" class="nav-link" data-bs-toggle="tab">
                <i class="fa-solid fa-anchor"></i> Port Locations
            </a>
            <a href="#compare" class="nav-link" data-bs-toggle="tab">
                <i class="fa-solid fa-code-compare"></i> Compare Countries
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Remove loader on page load
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader');
            loader.style.opacity = '0';
            setTimeout(() => loader.style.display = 'none', 500);
        });
    </script>
    @stack('scripts')
</body>
</html>
