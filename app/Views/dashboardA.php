<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TripWalk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .call-to-action {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-top: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .call-to-action img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .cta-btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
        }
        .cta-btn:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="dashboardA">TripWalk</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="dashboardA">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="rent-cars">Daftar Mobil</a></li>
                    <li class="nav-item"><a class="nav-link" href="vendors">Vendor</a></li>
                    <li class="nav-item"><a class="nav-link" href="recommendationsA">Rekomendasi Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center">Selamat Datang di TripWalk</h1>
        <p class="text-center">Platform sewa mobil terbaik untuk menjelajahi keindahan Bandung!</p>

        <div class="call-to-action">
            <h3>Jelajahi Keindahan Bandung dengan Sewa Mobil!</h3>
            <p>
                Dengan menyewa mobil, Anda dapat menikmati kebebasan menjelajahi destinasi wisata tanpa batasan waktu. 
                Nikmati kenyamanan, hemat biaya transportasi, dan ciptakan momen tak terlupakan bersama keluarga atau teman. 
                Jangan lewatkan kesempatan untuk berwisata dengan cara yang lebih praktis dan efisien!
            </p>
            <button class="cta-btn" onclick="window.location.href='rent-cars';">Sewa Mobil Sekarang!</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
