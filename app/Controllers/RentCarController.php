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
    public function getCarData($id = null)
    {
        header('Content-Type: application/json');
        
        if ($id === null) {
            $cars = $this->rentCarModel->findAll();
        } else {
            $cars = $this->rentCarModel->find($id);
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $cars
        ]);
    }
}