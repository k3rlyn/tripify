<?php

namespace App\Models;

use CodeIgniter\Model;

class TripCalculatorModel extends Model
{
    protected $table = 'trip_calculations';  // Nama tabel di database
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;  // Menggunakan created_at dan updated_at
    
    protected $allowedFields = [
        'userId',
        'wisataId', 
        'carId',
        'carMerk',
        'carJenis',
        'carKapasitas',
        'carHarga',
        'jumlahOrang',
        'tanggalPerjalanan',
        'totalTiket',
        'totalSewa',
        'totalBiaya',
        'status' // Tracking status rencana
    ];

    // Untuk mendapatkan total perhitungan yang dilakukan
    public function countAll()
    {
        return $this->builder()->countAll();
    }

    // Untuk mendapatkan destinasi wisata terpopuler
    public function getPopularDestinations()
    {
        return $this->select('wisataId, COUNT(*) as total')
                    ->join('wisata', 'wisata.wisataId = trip_calculations.wisataId')
                    ->groupBy('wisataId')
                    ->orderBy('total', 'DESC')
                    ->limit(5)
                    ->find();
    }

    // Untuk mendapatkan statistik bulanan
    public function getMonthlyStatistics()
    {
        return $this->select('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                    ->groupBy('month')
                    ->orderBy('month', 'DESC')
                    ->find();
    }

    // Untuk mendapatkan riwayat perhitungan user tertentu
    public function getUserCalculations($userId)
    {
        return $this->where('userId', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->find();
    }
}