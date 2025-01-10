<?php
namespace App\Controllers;
use App\Models\WisataModel;
use App\Models\TripCalculatorModel;

class TripCalculatorController extends BaseController
{
    protected $wisataModel;
    protected $tripCalculatorModel;

    public function __construct()
    {
        $this->wisataModel = new WisataModel();
        $this->tripCalculatorModel = new TripCalculatorModel();
    }

    public function index()
    {
        $data['wisata'] = $this->wisataModel->findAll();
        return view('trip_calculator/index', $data);  
    }

    public function calculate()
    {
        $wisataId = $this->request->getPost('wisataId');
        $jumlahOrang = $this->request->getPost('jumlahOrang');
        $carId = $this->request->getPost('carId');
        
        // Ambil data wisata
        $wisata = $this->wisataModel->find($wisataId);
        
        // Fetch data mobil dari TripWalk API
        $client = \Config\Services::curlrequest();
        try {
            $response = $client->get('http://localhost:8080/ammar/api/cars/' . $carId);
            $result = json_decode($response->getBody(), true);
            $car = $result['data'];
            
            // Hitung total biaya
            $totalTiket = $wisata['hargaTiket'] * $jumlahOrang;
            $totalSewa = $car['harga'];  // harga sewa per hari
            $totalBiaya = $totalTiket + $totalSewa;

            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'wisata' => $wisata['namaWisata'],
                    'jumlahOrang' => $jumlahOrang,
                    'mobilSewa' => $car['merk'] . ' ' . $car['jenis'],
                    'totalTiket' => $totalTiket,
                    'totalSewa' => $totalSewa,
                    'totalBiaya' => $totalBiaya,
                    'wisataId' => $wisataId,  // Tambahkan untuk keperluan save
                    'carId' => $carId         // Tambahkan untuk keperluan save
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengambil data mobil'
            ])->setStatusCode(500);
        }
    }

    public function saveCalculation() 
    {
        $userId = session()->get('userId');
        
        // Ambil data mobil dari API TripWalk
        $client = \Config\Services::curlrequest();
        $carId = $this->request->getPost('carId');
        
        try {
            $response = $client->get('http://localhost:8080/ammar/api/cars/' . $carId);
            $result = json_decode($response->getBody(), true);
            $car = $result['data'];

            $data = [
                'userId' => $userId,
                'wisataId' => $this->request->getPost('wisataId'),
                'carId' => $carId,
                'carMerk' => $car['merk'],
                'carJenis' => $car['jenis'],
                'carKapasitas' => $car['kapasitas'],
                'carHarga' => $car['harga'],
                'jumlahOrang' => $this->request->getPost('jumlahOrang'),
                'tanggalPerjalanan' => $this->request->getPost('tanggalPerjalanan'),
                'totalTiket' => $this->request->getPost('totalTiket'),
                'totalSewa' => $this->request->getPost('totalSewa'),
                'totalBiaya' => $this->request->getPost('totalBiaya'),
                'status' => 'planned'
            ];
        
            $this->tripCalculatorModel->insert($data);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Rencana perjalanan berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan rencana perjalanan'
            ])->setStatusCode(500);
        }
    }

    // Menampilkan riwayat perhitungan untuk user
    public function history()
    {
        $userId = session()->get('userId');
        $data['calculations'] = $this->tripCalculatorModel->getUserCalculations($userId);
        return view('trip_calculator/history', $data);
    }

    // Untuk admin
    public function statistics() 
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/kerlyn/admin/trip_statistics/');
        }

        $data['totalCalculations'] = $this->tripCalculatorModel->countAll();
        $data['popularDestinations'] = $this->tripCalculatorModel->getPopularDestinations();
        $data['monthlyStats'] = $this->tripCalculatorModel->getMonthlyStatistics();
        
        return view('admin/calculator_statistics', $data);
    }
}