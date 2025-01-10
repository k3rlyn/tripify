<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Tempat Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <li class="nav-item"><a class="nav-link" href="dashboardA">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="rent-cars">Daftar Mobil</a></li>
                    <li class="nav-item"><a class="nav-link" href="vendors">Vendor</a></li>
                    <li class="nav-item"><a class="nav-link active" href="recommendationsA">Rekomendasi Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Rekomendasi Tempat Wisata di Bandung</h1>
        <p>Berikut adalah daftar tempat wisata Bandung yang direkomendasikan berdasarkan data analitik.</p>
        
        <!-- Top Rated Places -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">5 Tempat Wisata dengan Rating Tertinggi</h5>
                <ul id="topRatedPlaces" class="list-group"></ul>
            </div>
        </div>

        <!-- Most Reviewed Places -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">5 Tempat Wisata Terpopuler (Berdasarkan Total Review)</h5>
                <ul id="mostReviewedPlaces" class="list-group"></ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const response = await fetch('/kerlyn/analytics/getAnalyticsData');
                const data = await response.json();

                const topRatedPlaces = document.getElementById('topRatedPlaces');
                const mostReviewedPlaces = document.getElementById('mostReviewedPlaces');

                // Render Top Rated Places
                data.topRated.forEach(place => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.innerHTML = `
                        <span>${place.namaWisata}</span>
                        <span class="badge bg-primary">${place.wisataRating.toFixed(1)}</span>
                    `;
                    topRatedPlaces.appendChild(li);
                });

                // Render Most Reviewed Places
                data.mostReviewed.forEach(place => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.innerHTML = `
                        <span>${place.namaWisata}</span>
                        <span class="badge bg-success">${place.totalReview} Reviews</span>
                    `;
                    mostReviewedPlaces.appendChild(li);
                });

            } catch (error) {
                console.error('Error fetching recommendations:', error);
                const container = document.querySelector('.container');
                container.innerHTML += `
                    <div class="alert alert-danger mt-3">
                        Gagal memuat data rekomendasi. Silakan coba lagi nanti.
                    </div>
                `;
            }
        });
    </script>

    <style>
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            background: rgba(255, 255, 255, 0.95);
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            color: #1a237e;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .list-group-item {
            border: none;
            background: rgba(245, 245, 245, 0.9);
        }

        .list-group-item .badge {
            font-size: 0.9rem;
        }
    </style>
</body>
</html>
