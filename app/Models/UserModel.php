<?php
namespace App\Models; 
use CodeIgniter\Model; 

class UserModel extends Model 
{
    protected $table = 'users'; // Model ini menangani tabel users dalam database
    protected $primaryKey = 'userId'; // Primary key tabel adalah kolom username
    protected $allowedFields = ['username', 'nama', 'password', 'role']; // Field yang diizinkan untuk dimodifikasi: username, nama, password, dan role
    
    protected $useTimestamps = false;
    protected $returnType = 'array';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = md5($data['data']['password']);
        }
        return $data;
    }

    public function getAllUser() {
        return $this->findAll();
    }

    public function getUserById(int $userId) {
        return $this->find($userId);
    }

    public function getUserByUsername(string $username) {
        return $this->where('username', $username)->first();
    }

    public function createUser(string $username, string $nama, string $password) {
        return $this->insert([
            'username' => $username,
            'nama' => $nama,
            'password' => $password,
            'role' => 'user' // Default role untuk user baru
        ]);
    }

    public function validatePassword(string $username, string $password) {
        $user = $this->getUserByUsername($username);
        return $user ? ($user['password'] === md5($password)) : false;
    }
    
    // untuk memvalidasi kredensial pengguna
    public function checkUser($username, $password) 
    {
        return $this->where([
            'username' => $username,
            'password' => md5($password)
        ])->first(); // fungsi first dalam codeigniter4 digunakan untuk mengambil record/baris (data) pertama dari hasil query
    }
}