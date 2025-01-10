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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk memuat riwayat perhitungan
    function loadTripHistory() {
        fetch('<?= base_url('kerlyn/trip_calculator/history') ?>')
            .then(response => response.json())
            .then(result => {
                const historyDiv = document.getElementById('tripHistory');
                historyDiv.innerHTML = '';
                
                if (result.data && result.data.length > 0) {
                    result.data.forEach(trip => {
                        historyDiv.innerHTML += `
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        ${new Date(trip.tanggalPerjalanan).toLocaleDateString('id-ID')}
                                    </h6>
                                    <p class="mb-1">${trip.wisata}</p>
                                    <p class="mb-1">${trip.mobilSewa}</p>
                                    <p class="mb-1">${trip.jumlahOrang} orang</p>
                                    <p class="mb-0">Total: Rp ${new Intl.NumberFormat('id-ID').format(trip.totalBiaya)}</p>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    historyDiv.innerHTML = '<p class="text-muted">Belum ada riwayat perhitungan</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('tripHistory').innerHTML = 
                    '<p class="text-danger">Gagal memuat riwayat perhitungan</p>';
            });
    }

    // Memuat data mobil saat halaman dimuat
    fetch('http://147.93.31.194:8443/ammar/api/cars')
        .then(response => response.json())
        .then(result => {
            const carSelect = document.getElementById('carSelect');
            carSelect.innerHTML = '<option value="">Pilih Mobil</option>';
            
            if (result.data) {
                result.data.forEach(car => {
                    carSelect.innerHTML += `
                        <option value="${car.id}">
                            ${car.merk} ${car.jenis} - Kapasitas ${car.kapasitas} orang - Rp ${new Intl.NumberFormat('id-ID').format(car.harga)}/hari
                        </option>
                    `;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('carSelect').innerHTML = 
                '<option value="">Gagal memuat data mobil</option>';
        });

    // Handle form submission untuk kalkulasi
    document.getElementById('calculatorForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        fetch('<?= base_url('kerlyn/trip_calculator/calculate') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                document.getElementById('result').classList.remove('d-none');
                document.getElementById('wisataName').textContent = result.data.wisata;
                document.getElementById('jumlahOrang').textContent = result.data.jumlahOrang;
                document.getElementById('mobilSewa').textContent = result.data.mobilSewa;
                document.getElementById('totalTiket').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(result.data.totalTiket);
                document.getElementById('totalSewa').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(result.data.totalSewa);
                document.getElementById('totalBiaya').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(result.data.totalBiaya);
            } else {
                alert(result.message || 'Gagal melakukan perhitungan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghitung biaya');
        });
    });

    // Handle save trip button
    document.getElementById('saveTrip').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('calculatorForm'));
        // Tambahkan data total dari hasil perhitungan
        formData.append('totalTiket', document.getElementById('totalTiket').textContent.replace(/[^\d]/g, ''));
        formData.append('totalSewa', document.getElementById('totalSewa').textContent.replace(/[^\d]/g, ''));
        formData.append('totalBiaya', document.getElementById('totalBiaya').textContent.replace(/[^\d]/g, ''));

        fetch('<?= base_url('kerlyn/trip_calculator/save') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                alert('Rencana perjalanan berhasil disimpan');
                // Reload riwayat perhitungan
                loadTripHistory();
            } else {
                alert(result.message || 'Gagal menyimpan rencana perjalanan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan rencana perjalanan');
        });
    });

    // Load riwayat perhitungan saat halaman dimuat
    loadTripHistory();
});
</script>

<?= $this->endSection() ?>