<?php

namespace App\Controllers;

class About extends BaseController
{
    public function indexA()
    {
        if (session()->get('num_user') == '') {
            return redirect()->to('A');
        }            
        return view('header').view('menu').view('about').view('footer');
    }
}