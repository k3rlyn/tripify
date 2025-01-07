<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TRIPIFY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background: #1a237e !important;
            padding: 1rem 1.5rem;
        }
        .navbar-brand {
            color: white !important;
            font-family: 'Shrikhand', cursive;
            font-size: 2rem;
        }
        .nav-link {
            color: white !important;
            font-size: 1.2rem;
            padding: 0.5rem 0;
            display: block;
        }
        .welcome-text {
            color: white !important;
            font-size: 1.1rem;
            margin-right: 1rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            background: rgba(255, 255, 255, 0.95);
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-success {
            background: #1a237e;
            border: none;
        }
        .btn-success:hover {
            background: #0d1757;
        }
        .btn-logout {
            background-color: white;
            color: #1a237e;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
        }
        .navbar-toggler {
            border: 2px solid rgba(255,255,255,0.7);
            padding: 0.5rem;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar > .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-collapse {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1a237e;
            padding: 1rem;
            display: none;
        }
        .navbar-collapse.show {
            display: block;
        }
        .nav-content {
            display: flex;
            align-items: center;
        }
        .main-content {
            transition: margin-top 0.3s ease-in-out;
            padding-top: 1rem;
        }
        .main-content.shifted {
            margin-top: 120px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="#">Tripify</a>
            
            <!-- Welcome text and Hamburger -->
            <div class="nav-content">
                <span class="welcome-text">Welcome, <?= session()->get('nama') ?>!</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <a class="nav-link" href="<?= base_url(session()->get('role') == 'admin' ? 'admin/wisata' : 'wisata') ?>">Daftar Wisata</a>
                <a class="nav-link" href="<?= base_url('analytics') ?>">Analytics</a>
                <a href="<?= base_url('logout') ?>" class="btn-logout mt-3">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-content" id="mainContent">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarCollapse = document.getElementById('navbarContent');
            const mainContent = document.getElementById('mainContent');
            
            // Listen for Bootstrap collapse events
            navbarCollapse.addEventListener('show.bs.collapse', function () {
                mainContent.classList.add('shifted');
            });
            
            navbarCollapse.addEventListener('hide.bs.collapse', function () {
                mainContent.classList.remove('shifted');
            });
        });
    </script>
</body>
</html>