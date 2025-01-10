<?php

namespace App\Models;

use CodeIgniter\Model;

class WisataModel extends Model
{
    protected $table = 'wisata';
    protected $primaryKey = 'wisataId';
    protected $allowedFields = ['namaWisata', 'lokasi', 'wisataRating', 'totalReview', 'hargaTiket'];

    public function getWisataWithRating()
    {
        return $this->orderBy('wisataRating', 'DESC')->findAll();
    }

    public function updateRating($wisataId, $newRating, $totalReview)
    {
        return $this->update($wisataId, [
            'wisataRating' => $newRating,
            'totalReview' => $totalReview
        ]);
    }

    // untuk cek eksistensi wisata
    public function isExists($wisataId)
    {
        return $this->find($wisataId) !== null;
    }

    public function getTopRated()
    {
        return $this->orderBy('wisataRating', 'DESC')
                    ->limit(5)
                    ->find();
    }

    public function getMostReviewed()
    {
        return $this->orderBy('totalReview', 'DESC')
                    ->limit(5)
                    ->find();
    }
}