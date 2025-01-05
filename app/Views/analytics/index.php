<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-2xl font-bold mb-6">Dashboard Analytics Rekomendasi Wisata di Bandung</h1>
    
    <!-- Top Rated Places Chart -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">5 Tempat Wisata Bandung dengan Rating Tertinggi</h5>
            <div class="chart-container" style="position: relative; height:400px; width:100%">
                <canvas id="topRatedChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Most Reviewed Places Chart -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">5 Tempat Wisata Bandung Terpopuler yang Paling Banyak Dikunjungi (Berdasarkan Total Review)</h5>
            <div class="chart-container" style="position: relative; height:400px; width:100%">
                <canvas id="mostReviewedChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk membuat chart
    function createChart(canvasId, data, label, maxValue = null) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.namaWisata),
                datasets: [{
                    label: label,
                    data: data.map(item => label === 'Rating' ? item.wisataRating : item.totalReview),
                    backgroundColor: label === 'Rating' ? '#8884d8' : '#82ca9d',
                    borderColor: label === 'Rating' ? '#7771d4' : '#6fc694',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: maxValue,
                        title: {
                            display: true,
                            text: label
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    }

    // Fungsi untuk memuat data
    async function loadData() {
        try {
            const response = await fetch('/analytics/getAnalyticsData');
            const data = await response.json();
            
            // Buat chart untuk top rated places
            createChart('topRatedChart', data.topRated, 'Rating', 5);
            
            // Buat chart untuk most reviewed places
            createChart('mostReviewedChart', data.mostReviewed, 'Total Review');
            
        } catch (error) {
            console.error('Error loading data:', error);
            // Tampilkan pesan error ke user
            document.querySelector('.container').innerHTML += `
                <div class="alert alert-danger mt-3">
                    Failed to load analytics data. Please try again later.
                </div>
            `;
        }
    }

    // Load data saat halaman dimuat
    loadData();
});
</script>

<style>
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s;
    background: rgba(255, 255, 255, 0.95);
    margin-bottom: 2rem;
}

.card:hover {
    transform: translateY(-5px);
}

.card-title {
    color: #1a237e;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.chart-container {
    padding: 1rem;
}
</style>
<?= $this->endSection() ?>