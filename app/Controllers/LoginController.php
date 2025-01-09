<?php
namespace App\Controllers;
use App\Models\Login;
class LoginController extends BaseController{
    public function indexA(){
        return view('loginA', ['error' => session()->getFlashdata('error')]);
    }
    public function login_actionA(){
        $model = model(Login::class);
        $username = $this->request->getPost('username');
        $password = md5($this->request->getPost('password'));
        $cek = $model->getDataUsers($username, $password);
        if ($cek == 1){
            session()->set('num_user', $cek);
            return redirect()->to('/');
        } else {
            return redirect()->to('/ammar/loginA')->with('error', 'Invalid username or password.');
        }
    }
    public function logout() {
        session()->destroy();
        return redirect()->to('/ammar/loginA')->with('error', 'You have been logged out.');
    }
}
