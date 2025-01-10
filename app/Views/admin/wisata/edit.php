<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Wisata</h4>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('kerlyn/admin/wisata/update/' . $wisata['wisataId']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Wisata</label>
                            <input type="text" class="form-control" name="namaWisata" 
                                   value="<?= old('namaWisata', $wisata['namaWisata']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <textarea class="form-control" name="lokasi" rows="3" 
                                      required><?= old('lokasi', $wisata['lokasi']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="hargaTiket" class="form-label">Harga Tiket</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="hargaTiket" name="hargaTiket" 
                                       value="<?= old('hargaTiket') ?>" 
                                       min="0" step="1000" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="<?= base_url('kerlyn/admin/wisata') ?>" class="btn btn-light">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>