<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title"><?= $trip['namaTrip'] ?></h2>
            <p class="card-text">
                <i class="fas fa-user text-primary"></i> <?= $trip['namaTrip'] ?> <!-- Nama user -->
            </p>
            <p class="card-text">
                <i class="fas fa-calendar"></i> 
                <?= date('d M Y', strtotime($trip['start_date'])) ?> - 
                <?= date('d M Y', strtotime($trip['end_date'])) ?>
            </p>
        </div>
    </div>

    <?php 
    $groupedDetails = [];
    foreach ($details as $detail) {
        $groupedDetails[date('Y-m-d', strtotime($detail['visit_date']))][] = $detail;
    }
    sort($groupedDetails);
    ?>

    <?php foreach ($groupedDetails as $date => $dayDetails): ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-calendar-day"></i> 
                <?= date('d M Y', strtotime($date)) ?>
            </h4>
        </div>
        <div class="card-body">
            <?php foreach ($dayDetails as $detail): ?>
            <div class="border-bottom pb-3 mb-3">
                <h5>
                    <i class="fas fa-map-marker-alt text-primary"></i>
                    <?= $detail['namaWisata'] ?>
                </h5>
                <div class="row">
                    <div class="col-md-4">
                        <i class="fas fa-clock text-muted"></i> 
                        Durasi: <?= $detail['durasi'] ?> jam
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-sort-numeric-down text-muted"></i>
                        Urutan: #<?= $detail['visit_order'] ?>
                    </div>
                    <?php if(!empty($detail['equipment'])): ?>
                    <div class="col-md-4">
                        <i class="fas fa-toolbox text-muted"></i>
                        Perlengkapan: <?= $detail['equipment'] ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="text-center mt-4">
        <a href="<?= base_url('kerlyn/admin/trip') ?>" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Trip
        </a>
    </div>
</div>
<?= $this->endSection() ?>