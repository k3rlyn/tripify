<?php

namespace App\Models;

use CodeIgniter\Model;

class TripDetailModel extends Model
{
    protected $table = 'trip_details';
    protected $primaryKey = 'detailId';
    protected $allowedFields = ['tripId', 'wisataId', 'visit_date', 'durasi', 'visit_order', 'equipment'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Dapatkan detail trip dengan info wisata
    public function getDetailsByTrip($tripId)
    {
        return $this->select('trip_details.*, wisata.namaWisata')
                    ->join('wisata', 'wisata.wisataId = trip_details.wisataId')
                    ->where('trip_details.tripId', $tripId)
                    ->orderBy('trip_details.visit_date', 'ASC')
                    ->orderBy('trip_details.visit_order', 'ASC')
                    ->findAll();
    }

    // Hapus semua detail untuk trip tertentu
    public function deleteByTripId($tripId)
    {
        return $this->where('tripId', $tripId)->delete();
    }
}