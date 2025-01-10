<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Kalkulator Biaya Perjalanan</h3>
                    
                    <form id="calculatorForm">
                        <div class="mb-3">
                            <label class="form-label">Pilih Tempat Wisata</label>
                            <select class="form-select" name="wisataId" required>
                                <?php foreach ($wisata as $w): ?>
                                <option value="<?= $w['wisataId'] ?>">
                                    <?= $w['namaWisata'] ?> - Rp <?= number_format($w['hargaTiket'], 0, ',', '.') ?>/orang
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Orang</label>
                            <input type="number" class="form-control" name="jumlahOrang" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Mobil</label>
                            <select class="form-select" name="carId" id="carSelect" required>
                                <option value="">Memuat data mobil...</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Rencana Perjalanan</label>
                            <input type="date" class="form-control" name="tanggalPerjalanan" required>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-calculator"></i> Hitung Biaya
                        </button>
                    </form>

                    <div id="result" class="mt-4 d-none">
                        <h4>Rincian Biaya:</h4>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200">Tempat Wisata</td>
                                <td id="wisataName"></td>
                            </tr>
                            <tr>
                                <td>Jumlah Orang</td>
                                <td id="jumlahOrang"></td>
                            </tr>
                            <tr>
                                <td>Mobil Sewa</td>
                                <td id="mobilSewa"></td>
                            </tr>
                            <tr>
                                <td>Total Tiket Masuk</td>
                                <td id="totalTiket"></td>
                            </tr>
                            <tr>
                                <td>Biaya Sewa Mobil</td>
                                <td id="totalSewa"></td>
                            </tr>
                            <tr class="table-primary">
                                <td><strong>Total Biaya</strong></td>
                                <td><strong id="totalBiaya"></strong></td>
                            </tr>
                        </table>
                        
                        <button id="saveTrip" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Rencana Perjalanan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Riwayat Perhitungan</h4>
                    <div id="tripHistory">
                        <!-- Riwayat perhitungan akan ditampilkan di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script sama seperti sebelumnya dengan tambahan fungsi save -->
<?= $this->endSection() ?>