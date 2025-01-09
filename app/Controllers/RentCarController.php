<?php

namespace App\Controllers;

use App\Models\RentCar;

class RentCarController extends BaseController
{
    public function indexA()
    {
        $model = new RentCar();
        $data['cars'] = $model->findAll();
        return view('carlist', $data);
    }
}
