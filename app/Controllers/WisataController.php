<?php

namespace App\Controllers;

use App\Models\WisataModel;
use App\Models\RatingModel;

class WisataController extends BaseController
{
    protected $wisataModel;
    protected $ratingModel;

    public function __construct()
    {
        $this->wisataModel = new WisataModel();
        $this->ratingModel = new RatingModel();
         // Menambahkan validasi form untuk store dan update
        $this->validation = \Config\Services::validation();
    }

    // Halaman untuk user biasa
    public function index()
    {
        $data['wisata'] = $this->wisataModel->getWisataWithRating();
        return view('wisata/index', $data);
    }

    public function rate($wisataId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }
        $data['wisata'] = $this->wisataModel->find($wisataId);
        return view('wisata/rate', $data);
    }

    public function submitRating()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }

        $wisataId = $this->request->getPost('wisataId');
        $rating = $this->request->getPost('rating');
        $userId = session()->get('userId');

        // Simpan rating
        $this->ratingModel->insert([
            'userId' => $userId,
            'wisataId' => $wisataId,
            'rating' => $rating
        ]);

        // Update rata-rata rating wisata
        $averageRating = $this->ratingModel->calculateAverageRating($wisataId);
        $totalReview = $this->ratingModel->getTotalReviews($wisataId);
        
        $this->wisataModel->updateRating($wisataId, $averageRating, $totalReview);

        return redirect()->to('/kerlyn/wisata')->with('message', 'Rating berhasil diberikan');

        // validasi rating
        if (!$this->validate([
            'rating' => 'required|numeric|greater_than[0]|less_than[6]'
        ])) {
            return redirect()->back()->with('error', 'Rating harus antara 1-5');
        }
    }

    // Halaman untuk admin
    public function admin()
    {
        $data['wisata'] = $this->wisataModel->findAll();
        return view('admin/wisata', $data);
    }

    public function create()
    {
        return view('admin/wisata/create');
    }

    public function store()
    {   
        // menambahkan validasi
        $rules = [
            'namaWisata' => 'required|min_length[3]',
            'lokasi' => 'required|min_length[5]',
            'hargaTiket' => 'required|numeric|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'namaWisata' => $this->request->getPost('namaWisata'),
            'lokasi' => $this->request->getPost('lokasi'),
            'hargaTiket' => $this->request->getPost('hargaTiket'),
            'wisataRating' => 0,
            'totalReview' => 0
        ];

        $this->wisataModel->insert($data);
        return redirect()->to('/kerlyn/admin/wisata')->with('message', 'Wisata berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['wisata'] = $this->wisataModel->find($id);
        return view('admin/wisata/edit', $data);
    }

    public function update($id)
    {   
        // Menambahkan validasi
        $rules = [
            'namaWisata' => 'required|min_length[3]',
            'lokasi' => 'required|min_length[5]',
            'hargaTiket' => 'required|numeric|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'namaWisata' => $this->request->getPost('namaWisata'),
            'lokasi' => $this->request->getPost('lokasi'),
            'hargaTiket' => $this->request->getPost('hargaTiket')
        ];

        $this->wisataModel->update($id, $data);
        return redirect()->to('/kerlyn/admin/wisata')->with('message', 'Wisata berhasil diupdate');
    }

    public function delete($id)
    {
        $this->wisataModel->delete($id);
        return redirect()->to('/kerlyn/admin/wisata')->with('message', 'Wisata berhasil dihapus');
    }
}