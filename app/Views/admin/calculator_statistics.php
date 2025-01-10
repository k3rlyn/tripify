<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistik Penggunaan Kalkulator</h4>
                    <div class="mb-3">
                        <h5>Total Penggunaan: <span id="totalUsage"></span></h5>
                    </div>
                    <div class="mb-3">
                        <h5>Destinasi Terpopuler:</h5>
                        <ul id="popularDestinations"></ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Grafik Penggunaan</h4>
                    <canvas id="usageChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ringkasan Bulanan</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Jumlah Perhitungan</th>
                                <th>Total Rencana Tersimpan</th>
                            </tr>
                        </thead>
                        <tbody id="monthlySummary">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>