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
            ])->setStatusCode(500);
        }
    }
}