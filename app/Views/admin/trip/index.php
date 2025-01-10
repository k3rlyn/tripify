<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2 class="mb-4">Daftar Semua Trip</h2>

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
                        <i class="fas fa-user text-primary"></i> 
                        <?= $trip['nama'] ?> <!-- Nama user -->
                    </p>
                    <p class="card-text">
                        <i class="fas fa-calendar text-primary"></i> 
                        <?= date('d M Y', strtotime($trip['start_date'])) ?> - 
                        <?= date('d M Y', strtotime($trip['end_date'])) ?>
                    </p>
                    <a href="<?= base_url('kerlyn/admin/trip/' . $trip['tripId']) ?>" 
                       class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>