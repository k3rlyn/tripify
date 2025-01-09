<?php

namespace App\Models;

use CodeIgniter\Model;

class RentCar extends Model
{
    protected $table = 'rentcar';
    protected $primaryKey = 'car_id';
    protected $allowedFields = ['merk', 'jenis', 'harga', 'kapasitas', 'vendor_id'];
}
