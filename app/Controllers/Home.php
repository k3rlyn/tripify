<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function landingPage()
    {
        return view('landing_page');
    }
}