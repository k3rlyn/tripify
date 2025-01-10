<?php
namespace App\Controllers;
use App\Models\RentCar;

class RentCarController extends BaseController 
{
    protected $rentCarModel;

    public function __construct()
    {
        $this->rentCarModel = new RentCar();
    }
    public function indexA()
    {
        $data['cars'] = $this->rentCarModel->findAll();
        return view('carlist', $data);
    }
<<<<<<< Updated upstream
    public function getCarData($id = null)
    {
        try {
            $db = \Config\Database::connect('secondary');
            
            if ($id !== null) {
                $car = $db->table('rentcar')->where('car_id', $id)->get()->getRowArray();
                if ($car) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data' => $car
                    ]);
                }
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Mobil tidak ditemukan'
                ])->setStatusCode(404);
            }

            // Get all cars
            $cars = $db->table('rentcar')
                      ->select('car_id, merk, jenis, harga, kapasitas')
                      ->get()
                      ->getResultArray();

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $cars
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting car data: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengambil data mobil: ' . $e->getMessage()
=======

    // Tambahkan method baru untuk API
    public function getCars()
    {
        $client = \Config\Services::curlrequest();
        try {
            // Update the URL to point to your getCarData endpoint
            $response = $client->get(base_url('kerlyn/api/cars'));  // Adjust the path to match your route
            return $this->response->setJSON(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengambil data mobil'
>>>>>>> Stashed changes
            ])->setStatusCode(500);
        }
    }
}