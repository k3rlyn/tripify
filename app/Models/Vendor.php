<?php

namespace App\Models;

use CodeIgniter\Model;

class Vendor extends Model
{
    protected $DBGroup = 'secondary';
    protected $table = 'vendor';
    protected $primaryKey = 'vendor_id';
    protected $allowedFields = ['nama_vendor', 'alamat', 'nomor_telepon'];
}
