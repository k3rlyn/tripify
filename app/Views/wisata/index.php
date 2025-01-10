<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2>Rekomendasi Tempat Wisata di Bandung</h2>
    
    <div class="row mt-4">
        <?php foreach ($wisata as $tempat): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= $tempat['namaWisata'] ?></h5>
                    <p class="card-text">
                        <i class="fas fa-map-marker-alt text-primary"></i> <?= $tempat['lokasi'] ?>
                    </p>
                    <p class="card-text">
                        <i class="fas fa-ticket-alt text-success"></i> Rp <?= number_format($tempat['hargaTiket'], 0, ',', '.') ?>
                    </p>
                    <div class="mb-3">
                        <span class="badge bg-primary">
                            <?= number_format($tempat['wisataRating'], 1) ?> <i class="fas fa-star text-warning"></i>
                        </span>
                        <small class="text-muted">(<?= $tempat['totalReview'] ?> reviews)</small>
                    </div>
                    <a href="<?= base_url('kerlyn/wisata/rate/' . $tempat['wisataId']) ?>" 
                       class="btn btn-success">
                        <i class="fas fa-star"></i> Beri Rating
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>