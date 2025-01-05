<?php

namespace App\Controllers;

use App\Models\WisataModel;

class AnalyticsController extends BaseController
{
    protected $wisataModel;

    public function __construct()
    {
        $this->wisataModel = new WisataModel();
    }

    public function index()
    {
        return view('analytics/index');
    }

    public function getAnalyticsData()
    {
        $topRated = $this->wisataModel->getTopRated();
        $mostReviewed = $this->wisataModel->getMostReviewed();

        return $this->response->setJSON([
            'topRated' => $topRated,
            'mostReviewed' => $mostReviewed
        ]);
    }
}