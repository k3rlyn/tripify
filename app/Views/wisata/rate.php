<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Berikan penilaianmu terhadap <?= $wisata['namaWisata'] ?> jika pernah mengunjunginya</h4>
                    <p class="text-muted mb-4">
                        <i class="fas fa-map-marker-alt"></i> <?= $wisata['lokasi'] ?>
                    </p>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('wisata/submit-rating') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="wisataId" value="<?= $wisata['wisataId'] ?>">
                        
                        <div class="mb-4">
                            <label class="form-label mb-3">Pilih Rating</label>
                            <div class="rating text-center">
                                <input type="radio" name="rating" value="5" id="star5">
                                <label for="star5"><i class="far fa-star fa-2x"></i></label>
                                
                                <input type="radio" name="rating" value="4" id="star4">
                                <label for="star4"><i class="far fa-star fa-2x"></i></label>
                                
                                <input type="radio" name="rating" value="3" id="star3">
                                <label for="star3"><i class="far fa-star fa-2x"></i></label>
                                
                                <input type="radio" name="rating" value="2" id="star2">
                                <label for="star2"><i class="far fa-star fa-2x"></i></label>
                                
                                <input type="radio" name="rating" value="1" id="star1">
                                <label for="star1"><i class="far fa-star fa-2x"></i></label>
                            </div>
                            <div id="rating-text" class="text-center mt-2 text-muted"></div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-star"></i> Submit Rating
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    padding: 15px;
}

.rating input {
    display: none;
}

.rating label {
    cursor: pointer;
    padding: 5px;
    color: #d1d1d1;
}

.rating:hover label i {
    color: #d1d1d1;
}

.rating input:checked ~ label i,
.rating:hover label:hover i,
.rating:hover label:hover ~ label i {
    color: #ffd700;
}

.rating label:hover i:before,
.rating input:checked ~ label i:before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    content: "\f005";
}

#rating-text {
    font-size: 0.9rem;
    min-height: 20px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingInputs = document.querySelectorAll('.rating input');
    const ratingText = document.getElementById('rating-text');
    
    const ratingDescriptions = {
        1: 'Sangat Buruk',
        2: 'Buruk',
        3: 'Cukup',
        4: 'Bagus',
        5: 'Sangat Bagus'
    };

    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            const rating = this.value;
            ratingText.textContent = ratingDescriptions[rating];
        });
    });

    // Menampilkan teks rating saat hover
    const ratingLabels = document.querySelectorAll('.rating label');
    ratingLabels.forEach(label => {
        label.addEventListener('mouseover', function() {
            const rating = this.previousElementSibling.value;
            ratingText.textContent = ratingDescriptions[rating];
        });

        label.addEventListener('mouseout', function() {
            const checkedInput = document.querySelector('.rating input:checked');
            ratingText.textContent = checkedInput ? ratingDescriptions[checkedInput.value] : '';
        });
    });
});
</script>
<?= $this->endSection() ?>