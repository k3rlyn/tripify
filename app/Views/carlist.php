<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sewa Mobil - Tripify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Fungsi untuk memfilter daftar mobil berdasarkan input pencarian
        function filterCars() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const carCards = document.querySelectorAll('.car-card');

            carCards.forEach(card => {
                const merk = card.getAttribute('data-merk').toLowerCase();
                const jenis = card.getAttribute('data-jenis').toLowerCase();

                if (merk.includes(searchInput) || jenis.includes(searchInput)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">Tripify</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="/">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/rent-cars">Daftar Mobil</a></li>
                    <li class="nav-item"><a class="nav-link" href="/vendors">Vendor</a></li>
                    <li class="nav-item"><a class="nav-link" href="/recommendations">Rekomendasi Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center">Daftar Sewa Mobil</h1>

        <div class="row mt-4">
            <div class="col-12">
                <input 
                    type="text" 
                    id="searchInput" 
                    class="form-control" 
                    placeholder="Cari mobil berdasarkan merk atau jenis..." 
                    onkeyup="filterCars()"
                >
            </div>
        </div>


        <div class="row mt-4">
            <?php foreach ($cars as $car): ?>
                <div class="col-md-4 car-card" data-merk="<?= $car['merk'] ?>" data-jenis="<?= $car['jenis'] ?>">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= $car['merk'] ?> - <?= $car['jenis'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Rp <?= number_format($car['harga'], 0, ',', '.') ?> / Hari</h6>
                            <p class="card-text">
                                <strong>Kapasitas:</strong> <?= $car['kapasitas'] ?> orang<br>
                                <strong>Vendor:</strong> <?= $car['vendor'] ?><br>
                                <strong>Nomor Telepon:</strong> <?= $car['nomor_telepon'] ?>
                            </p>
                            <p class="card-text"><?= $car['deskripsi'] ?></p>
                            <a href="https://wa.me/62<?= preg_replace('/\D/', '', $car['nomor_telepon']) ?>" class="btn btn-primary" target="_blank">Sewa Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
