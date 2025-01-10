<?php

namespace App\Controllers;

use App\Models\TripModel;
use App\Models\TripDetailModel;
use App\Models\WisataModel;

class TripController extends BaseController
{
    protected $tripModel;
    protected $tripDetailModel;
    protected $wisataModel;

    public function __construct()
    {
        $this->tripModel = new TripModel();
        $this->tripDetailModel = new TripDetailModel();
        $this->wisataModel = new WisataModel();
        $this->validation = \Config\Services::validation();
        
    }
    
    public $helpers = ['form'];
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }

        $data['trips'] = $this->tripModel->getTripsByUser(session()->get('userId'));
        return view('trip/index', $data);
    }

    public function show($tripId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }
    
        $data['trip'] = $this->tripModel->find($tripId);
        
        if (!$data['trip'] || !$this->tripModel->isOwnedByUser($tripId, session()->get('userId'))) {
            return redirect()->to('/kerlyn/trip')->with('error', 'Trip tidak ditemukan');
        }
    
        // Tambahkan logging untuk debug
        $data['details'] = $this->tripDetailModel->getDetailsByTrip($tripId);
        log_message('debug', 'Trip Details: ' . json_encode($data['details']));
    
        return view('trip/show', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }

        $data['wisata'] = $this->wisataModel->findAll();
        return view('trip/create', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }

        try {
            // Validation rules
            $rules = [
                'namaTrip' => [
                    'rules' => 'required|min_length[3]',
                    'errors' => [
                        'required' => 'Nama trip harus diisi',
                        'min_length' => 'Nama trip minimal 3 karakter'
                    ]
                ],
                'start_date' => [
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => 'Tanggal mulai harus diisi',
                        'valid_date' => 'Format tanggal mulai tidak valid'
                    ]
                ],
                'end_date' => [
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => 'Tanggal selesai harus diisi',
                        'valid_date' => 'Format tanggal selesai tidak valid'
                    ]
                ],
                'wisataId.*' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Wisata harus dipilih',
                        'numeric' => 'ID wisata tidak valid'
                    ]
                ],
                'visit_date.*' => [
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => 'Tanggal kunjungan harus diisi',
                        'valid_date' => 'Format tanggal tidak valid'
                    ]
                ],
                'durasi.*' => [
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => 'Durasi harus diisi',
                        'numeric' => 'Durasi harus berupa angka',
                        'greater_than' => 'Durasi harus lebih dari 0'
                    ]
                ],
                'visit_order.*' => [
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => 'Urutan kunjungan harus diisi',
                        'numeric' => 'Urutan harus berupa angka',
                        'greater_than' => 'Urutan harus lebih dari 0'
                    ]
                ]
            ];

            // Run validation
            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            // Get post data
            $namaTrip = $this->request->getPost('namaTrip');
            $startDate = $this->request->getPost('start_date');
            $endDate = $this->request->getPost('end_date');
            $wisataIds = $this->request->getPost('wisataId');
            $visitDates = $this->request->getPost('visit_date');
            $durasi = $this->request->getPost('durasi');
            $visitOrders = $this->request->getPost('visit_order');
            $equipments = $this->request->getPost('equipment');

            // Validate date range
            if (strtotime($endDate) < strtotime($startDate)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Tanggal selesai harus setelah tanggal mulai');
            }

            // Validate wisata details
            if (!is_array($wisataIds) || empty($wisataIds)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Minimal harus ada satu destinasi wisata');
            }

            // Start database transaction
            $db = \Config\Database::connect();
            $db->transStart();

            try {
                // Insert main trip data
                $tripData = [
                    'userId' => session()->get('userId'),
                    'namaTrip' => $namaTrip,
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ];

                $tripId = $this->tripModel->insert($tripData);
                if (!$tripId) {
                    throw new \Exception('Gagal menyimpan data trip utama');
                }

                // Insert trip details
                foreach ($wisataIds as $key => $wisataId) {
                    // Validate all required array keys exist
                    if (!isset($visitDates[$key]) || !isset($durasi[$key]) || !isset($visitOrders[$key])) {
                        throw new \Exception('Data detail perjalanan tidak lengkap');
                    }

                    // Validate wisata exists
                    if (!$this->wisataModel->isExists($wisataId)) {
                        throw new \Exception('Data wisata tidak valid');
                    }

                    // Validate visit date is within trip date range
                    $visitDate = strtotime($visitDates[$key]);
                    if ($visitDate < strtotime($startDate) || $visitDate > strtotime($endDate)) {
                        throw new \Exception('Tanggal kunjungan harus dalam rentang tanggal trip');
                    }

                    // Insert trip detail
                    $detailData = [
                        'tripId' => $tripId,
                        'wisataId' => $wisataId,
                        'visit_date' => $visitDates[$key],
                        'durasi' => $durasi[$key],
                        'visit_order' => $visitOrders[$key],
                        'equipment' => $equipments[$key] ?? null
                    ];

                    $detailResult = $this->tripDetailModel->insert($detailData);
                    if (!$detailResult) {
                        throw new \Exception('Gagal menyimpan detail perjalanan');
                    }
                }

                // Commit transaction
                if ($db->transStatus() === false) {
                    throw new \Exception('Terjadi kesalahan dalam transaksi database');
                }
                
                $db->transComplete();

                // Success redirect
                return redirect()->to('/kerlyn/trip')
                    ->with('message', 'Trip berhasil dibuat');

            } catch (\Exception $e) {
                // Rollback transaction
                $db->transRollback();
                
                log_message('error', '[Trip Store] Error: ' . $e->getMessage());
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            log_message('error', '[Trip Store] Outer Error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function edit($tripId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }

        if (!$this->tripModel->isOwnedByUser($tripId, session()->get('userId'))) {
            return redirect()->to('/kerlyn/trip')->with('error', 'Trip tidak ditemukan');
        }
        // Ambil data trip
        $data['trip'] = $this->tripModel->find($tripId);
        $data['details'] = $this->tripDetailModel->getDetailsByTrip($tripId);
        $data['wisata'] = $this->wisataModel->findAll();
        
        return view('trip/edit', $data);
    }

    public function update($tripId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }

        if (!$this->tripModel->isOwnedByUser($tripId, session()->get('userId'))) {
            return redirect()->to('/kerlyn/trip')->with('error', 'Trip tidak ditemukan');
        }

        $rules = [
            'namaTrip' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama trip harus diisi',
                    'min_length' => 'Nama trip minimal 3 karakter'
                ]
            ],
            'start_date' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal mulai harus diisi',
                    'valid_date' => 'Format tanggal mulai tidak valid'
                ]
            ],
            'end_date' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal selesai harus diisi',
                    'valid_date' => 'Format tanggal selesai tidak valid'
                ]
            ],
            'wisataId.*' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Wisata harus dipilih',
                    'numeric' => 'ID wisata tidak valid'
                ]
            ],
            'visit_date.*' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal kunjungan harus diisi',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ],
            'durasi.*' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Durasi harus diisi',
                    'numeric' => 'Durasi harus berupa angka',
                    'greater_than' => 'Durasi harus lebih dari 0'
                ]
            ],
            'visit_order.*' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Urutan kunjungan harus diisi',
                    'numeric' => 'Urutan harus berupa angka',
                    'greater_than' => 'Urutan harus lebih dari 0'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Cek tanggal end_date harus >= start_date
        if (strtotime($this->request->getPost('end_date')) < strtotime($this->request->getPost('start_date'))) {
            return redirect()->back()->withInput()->with('error', 'Tanggal selesai harus setelah tanggal mulai');
        }

        // Update trip utama
        $this->tripModel->update($tripId, [
            'namaTrip' => $this->request->getPost('namaTrip'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date')
        ]);

        // Hapus detail lama
        $this->tripDetailModel->deleteByTripId($tripId);

        // Simpan detail baru
        $wisataIds = $this->request->getPost('wisataId');
        $visitDates = $this->request->getPost('visit_date');
        $durasi = $this->request->getPost('durasi');
        $visitOrders = $this->request->getPost('visit_order');
        $equipments = $this->request->getPost('equipment');

        if (is_array($wisataIds)) {
            foreach ($wisataIds as $key => $wisataId) {
                if ($this->wisataModel->isExists($wisataId)) {
                    if (strtotime($visitDates[$key]) >= strtotime($this->request->getPost('start_date')) && 
                        strtotime($visitDates[$key]) <= strtotime($this->request->getPost('end_date'))) {
                        
                        $this->tripDetailModel->insert([
                            'tripId' => $tripId,
                            'wisataId' => $wisataId,
                            'visit_date' => $visitDates[$key],
                            'durasi' => $durasi[$key],
                            'visit_order' => $visitOrders[$key],
                            'equipment' => $equipments[$key] ?? null
                        ]);
                    }
                }
            }
        }

        return redirect()->to('/kerlyn/trip')->with('message', 'Trip berhasil diupdate');
    }

    public function delete($tripId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }

        if (!$this->tripModel->isOwnedByUser($tripId, session()->get('userId'))) {
            return redirect()->to('/kerlyn/trip')->with('error', 'Trip tidak ditemukan');
        }

        // Hapus detail trip terlebih dahulu
        $this->tripDetailModel->deleteByTripId($tripId);
        
        // Hapus trip utama
        $this->tripModel->delete($tripId);

        return redirect()->to('/kerlyn/trip')->with('message', 'Trip berhasil dihapus');
    }

    public function adminIndex()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/kerlyn/login');
        }

        // Admin bisa lihat semua trip
        $data['trips'] = $this->tripModel->findAll();
        return view('admin/trip/index', $data);
    }

    public function adminShow($tripId)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/kerlyn/login');
        }

        $data['trip'] = $this->tripModel->find($tripId);
        if (!$data['trip']) {
            return redirect()->to('/kerlyn/admin/trip')->with('error', 'Trip tidak ditemukan');
        }

        $data['details'] = $this->tripDetailModel->getDetailsByTrip($tripId);
        return view('admin/trip/show', $data);
    }
}