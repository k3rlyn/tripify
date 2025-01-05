<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kelola Data Wisata</h2>
        <a href="<?= base_url('admin/wisata/create') ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Wisata
        </a>
    </div>

    <?php if(session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($wisata as $tempat): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= $tempat['namaWisata'] ?></h5>
                    <p class="card-text">
                        <i class="fas fa-map-marker-alt text-primary"></i> <?= $tempat['lokasi'] ?>
                    </p>
                    <div class="mb-3">
                        <span class="badge bg-primary">
                            <?= number_format($tempat['wisataRating'], 1) ?> <i class="fas fa-star text-warning"></i>
                        </span>
                        <small class="text-muted">(<?= $tempat['totalReview'] ?> reviews)</small>
                    </div>
                    <div class="btn-group">
                        <a href="<?= base_url('admin/wisata/edit/' . $tempat['wisataId']) ?>" 
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('admin/wisata/delete/' . $tempat['wisataId']) ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus data ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>