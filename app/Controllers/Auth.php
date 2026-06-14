<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        return view('login');
    }

    public function login()
    {
        $session = session();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Login sebagai admin
        if ($username == 'admin' && $password == 'admin123') {

            $session->set([
                'logged_in' => true,
                'role'      => 'admin',
                'username'  => 'admin'
            ]);

            return redirect()->to('/');
        }

        // Login sebagai anggota
        $anggotaModel = new AnggotaModel();

        $anggota = $anggotaModel
            ->where('username', $username)
            ->where('password', $password)
            ->first();

        if ($anggota) {

            $session->set([
                'logged_in' => true,
                'role'       => 'anggota',
                'anggota_id' => $anggota['id'],
                'nama'       => $anggota['nama'],
                'username'   => $anggota['username']
            ]);

            return redirect()->to('/katalog');
        }

        $session->setFlashdata('error', 'Username atau Password salah!');
        return redirect()->to('/auth');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/auth');
    }
}

