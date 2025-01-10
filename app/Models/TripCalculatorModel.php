<?php

namespace App\Models;

use CodeIgniter\Model;

class TripCalculatorModel extends Model
{
    protected $table = 'trip_calculations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['userId', 'wisataId', 'carId', 'carMerk', 'carJenis', 
                              'carKapasitas', 'carHarga', 'jumlahOrang', 'tanggalPerjalanan', 
                              'totalTiket', 'totalSewa', 'totalBiaya', 'status'];

    // Untuk mendapatkan total perhitungan yang dilakukan
    public function countAll()
    {
        return $this->builder()->countAll();
    }

    // Untuk mendapatkan destinasi wisata terpopuler
    public function getPopularDestinations()
    {
        return $this->select('trip_calculations.wisataId, wisata.namaWisata, COUNT(*) as total')
                    ->join('wisata', 'wisata.wisataId = trip_calculations.wisataId')
                    ->groupBy('trip_calculations.wisataId, wisata.namaWisata')
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