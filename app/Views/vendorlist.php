<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - Tripify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function filterVendors() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const vendors = document.querySelectorAll(".list-group-item");

            vendors.forEach(vendor => {
                const namaVendor = vendor.getAttribute("data-nama-vendor");
                if (namaVendor.includes(input)) {
                    vendor.style.display = "";
                } else {
                    vendor.style.display = "none";
                }
            });
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/ammar/">Tripify</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="/">DashboardA</a></li>
                    <li class="nav-item"><a class="nav-link" href="/rent-cars">Daftar Mobil</a></li>
                    <li class="nav-item"><a class="nav-link" href="/vendors">Vendor</a></li>
                    <li class="nav-item"><a class="nav-link" href="/recommendations">Rekomendasi Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center">Vendor</h1>
        
        <!-- Input Pencarian -->
        <div class="mt-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nama vendor..." onkeyup="filterVendors()">
        </div>

        <div class="list-group mt-4">
            <?php foreach ($vendors as $vendor): ?>
                <div class="list-group-item" data-nama-vendor="<?= strtolower($vendor['nama_vendor']) ?>">
                    <h4 class="mb-1"><?= $vendor['nama_vendor'] ?></h4>
                    <h6 class="mb-1"><?= $vendor['deskripsi'] ?></h6>
                    <p class="mb-1">
                        <strong>Alamat:</strong> <?= $vendor['alamat'] ?><br>
                        <strong>Nomor Telepon:</strong> <?= $vendor['nomor_telepon'] ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
