<?php

namespace App\Models;

use CodeIgniter\Model;

class TripModel extends Model
{
    protected $table = 'trips';
    protected $primaryKey = 'tripId';
    protected $allowedFields = ['userId', 'namaTrip', 'start_date', 'end_date'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Dapatkan semua trip untuk user tertentu
    public function getTripsByUser($userId)
    {
        return $this->where('userId', $userId)
                    ->orderBy('start_date', 'DESC')
                    ->findAll();
    }

    // Cek kepemilikan trip
    public function isOwnedByUser($tripId, $userId)
    {
        return $this->where([
            'tripId' => $tripId,
            'userId' => $userId
        ])->first() !== null;
    }
}
