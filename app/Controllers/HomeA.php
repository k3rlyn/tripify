<?php
namespace App\Controllers;
class HomeA extends BaseController
{
    public function index()
    {               
        if (session()->get('num_user') == '') {
            return redirect()->to('/ammar/loginA');
        }     
        return view('dashboardA');
    }
}