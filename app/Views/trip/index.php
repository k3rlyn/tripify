<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Trip Saya</h2>
        <a href="<?= base_url('kerlyn/trip/create') ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Buat Trip Baru
        </a>
    </div>

    <?php if(session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($trips as $trip): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= $trip['namaTrip'] ?></h5>
                    <p class="card-text">
                        <i class="fas fa-calendar text-primary"></i> 
                        <?= date('d M Y', strtotime($trip['start_date'])) ?> - 
                        <?= date('d M Y', strtotime($trip['end_date'])) ?>
                    </p>
                    <div class="btn-group">
                        <a href="<?= base_url('kerlyn/trip/' . $trip['tripId']) ?>" 
                           class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="<?= base_url('kerlyn/trip/edit/' . $trip['tripId']) ?>" 
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('kerlyn/trip/delete/' . $trip['tripId']) ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin ingin menghapus trip ini?')">
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