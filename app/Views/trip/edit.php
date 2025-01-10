<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Edit Trip</h2>

            <?php if(session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach(session('errors') as $error): ?>
                        <?= $error ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?= form_open('kerlyn/trip/update/' . $trip['tripId']) ?>
                <div class="mb-3">
                    <label class="form-label">Nama Trip</label>
                    <input type="text" class="form-control" name="namaTrip" 
                           value="<?= old('namaTrip', $trip['namaTrip']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" 
                                   value="<?= old('start_date', $trip['start_date']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date" 
                                   value="<?= old('end_date', $trip['end_date']) ?>" required>
                        </div>
                    </div>
                </div>

                <div id="destinationList">
                    <?php foreach($details as $index => $detail): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>Destinasi <?= $index + 1 ?></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Pilih Wisata</label>
                                            <select class="form-select" name="wisataId[]" required>
                                                <?php foreach($wisata as $w): ?>
                                                    <option value="<?= $w['wisataId'] ?>" 
                                                            <?= ($w['wisataId'] == $detail['wisataId']) ? 'selected' : '' ?>>
                                                        <?= $w['namaWisata'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Kunjungan</label>
                                            <input type="date" class="form-control" name="visit_date[]" 
                                                   value="<?= $detail['visit_date'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Durasi (jam)</label>
                                            <input type="number" class="form-control" name="durasi[]" 
                                                   value="<?= $detail['durasi'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Urutan Kunjungan</label>
                                            <input type="number" class="form-control" name="visit_order[]" 
                                                   value="<?= $detail['visit_order'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Perlengkapan</label>
                                            <input type="text" class="form-control" name="equipment[]" 
                                                   value="<?= $detail['equipment'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if($index > 0): ?>
                                <button type="button" class="btn btn-danger btn-sm remove-destination">
                                    <i class="fas fa-trash"></i> Hapus Destinasi
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="btn btn-success mb-3" id="addDestination">
                    <i class="fas fa-plus"></i> Tambah Destinasi
                </button>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= base_url('kerlyn/trip') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle add destination
    document.getElementById('addDestination').addEventListener('click', function() {
        const destinationList = document.getElementById('destinationList');
        const index = destinationList.children.length;
        
        // Create destination template
        const template = `
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Destinasi Baru</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pilih Wisata</label>
                                <select class="form-select" name="wisataId[]" required>
                                    <?php foreach($wisata as $w): ?>
                                        <option value="<?= $w['wisataId'] ?>"><?= $w['namaWisata'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kunjungan</label>
                                <input type="date" class="form-control" name="visit_date[]" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Durasi (jam)</label>
                                <input type="number" class="form-control" name="durasi[]" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Urutan Kunjungan</label>
                                <input type="number" class="form-control" name="visit_order[]" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Perlengkapan</label>
                                <input type="text" class="form-control" name="equipment[]">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-destination">
                        <i class="fas fa-trash"></i> Hapus Destinasi
                    </button>
                </div>
            </div>`;
            
        destinationList.insertAdjacentHTML('beforeend', template);
    });

    // Handle remove destination
    document.querySelectorAll('.remove-destination').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.card').remove();
        });
    });
});
</script>
<?= $this->endSection() ?>