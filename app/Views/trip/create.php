<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Buat Trip Baru</h4>

                    <?php if(session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('kerlyn/trip/store') ?>" method="post" id="tripForm">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Trip</label>
                            <input type="text" class="form-control" name="namaTrip" value="<?= old('namaTrip') ?>" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="start_date" value="<?= old('start_date') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="end_date" value="<?= old('end_date') ?>" required>
                            </div>
                        </div>

                        <div id="wisataContainer">
                            <div class="card mb-3 wisata-item">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Tempat Wisata</label>
                                            <select name="wisataId[]" class="form-control" required>
                                                <?php foreach($wisata as $w): ?>
                                                <option value="<?= $w['wisataId'] ?>"><?= $w['namaWisata'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Kunjungan</label>
                                            <input type="date" class="form-control" name="visit_date[]" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Durasi (jam)</label>
                                            <input type="number" class="form-control" name="durasi[]" min="1" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Urutan Kunjungan</label>
                                            <input type="number" class="form-control" name="visit_order[]" min="1" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Perlengkapan</label>
                                            <input type="text" class="form-control" name="equipment[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-3" onclick="addWisata()">
                            <i class="fas fa-plus"></i> Tambah Tempat Wisata
                        </button>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Trip
                            </button>
                            <a href="<?= base_url('kerlyn/trip') ?>" class="btn btn-light">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addWisata() {
    const container = document.getElementById('wisataContainer');
    const template = container.querySelector('.wisata-item').cloneNode(true);
    
    // Reset values
    template.querySelectorAll('input').forEach(input => {
        input.value = '';
    });
    
    container.appendChild(template);
}
</script>
<?= $this->endSection() ?>