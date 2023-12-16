<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class AuthController extends BaseController
{
    public function login()
    {
        $session = session();
        if ($session->has('user_id')){
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function processLogin(){
        $userModel = model(CustomerModel::class);

        $session = session();

        $username = $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        $userData = $userModel->where('username', $username)->first();
        if ($userData && password_verify($password, $userData['password'])) {
            $session->set('username', $userData['username']);
            $session->set('user_id', $userData['id']);
            return redirect()->to('/');
        } else {
            return redirect()->to('/login');
        };
    }

    public function processLogout(){
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function processRegister(){
        $userModel = model(CustomerModel::class);
        if ($userModel->where('username', $this->request->getPost('username'))->first()) {

            return redirect()->to('/register');
        }

        $postData = $this->request->getPost();
        $username = $postData['username'];
        $nama = $postData['nama'];
        $password = $postData['password'];

        if(empty($username) || empty($password)){
            return redirect()->to('/register');
        } else {
            $data = [
                'nama' => $nama,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]),
            ];
        }

        if($data){
            $insertID = $userModel->insert($data);
            $insertedData = $userModel->find($insertID);
            $session = session();
            $session->set('username', $insertedData['username']);
            $session->set('user_id', $insertedData['id']);
            return redirect()->to('/');
        }


    }
}
