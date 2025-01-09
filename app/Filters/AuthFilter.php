<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

// untuk mengontrol akses umum (memastikan user sudah login)

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/kerlyn/login');
        }
        
        // Arahkan ke halaman sesuai role jika mencoba akses halaman login/register saat sudah login
        $currentPath = $request->getUri()->getPath();

        if ($currentPath == 'login' || $currentPath == 'register') {
            if (session()->get('role') == 'admin') {
                return redirect()->to('/kerlyn/admin/wisata');
            } else {
                return redirect()->to('/kerlyn/wisata');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}