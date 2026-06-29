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

        if ($username == 'admin' && $password == 'admin123') {

            $session->set([
                'logged_in' => true,
                'role'      => 'admin',
                'username'  => 'admin'
            ]);

            return redirect()->to('/');
        }

  
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

            return redirect()->to('/');
        }

        $session->setFlashdata('error', 'Username atau Password salah!');
        return redirect()->to('/auth');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/auth');
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        return view('register');
    }

    public function register_process()
    {
        $session = session();
        $model = new AnggotaModel();

        // Ambil data input
        $nama = $this->request->getPost('nama');
        $nomor = $this->request->getPost('nomor');
        $gmail = $this->request->getPost('gmail');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek jika username sudah ada
        $existing = $model->where('username', $username)->first();
        if ($existing) {
            $session->setFlashdata('error', 'Username sudah terdaftar!');
            return redirect()->to('/auth/register')->withInput();
        }

        // Cek jika email sudah ada
        $existingEmail = $model->where('gmail', $gmail)->first();
        if ($existingEmail) {
            $session->setFlashdata('error', 'Email sudah terdaftar!');
            return redirect()->to('/auth/register')->withInput();
        }

        // Generate kode_anggota unik
        $last = $model->orderBy('id', 'DESC')->first();
        if ($last && !empty($last['kode_anggota'])) {
            $num = (int) substr($last['kode_anggota'], 3) + 1;
        } else {
            $num = 1;
        }
        $kode = 'AGT' . str_pad($num, 3, '0', STR_PAD_LEFT);

        // Simpan data
        $model->save([
            'kode_anggota' => $kode,
            'nama'         => $nama,
            'nomor'        => $nomor,
            'gmail'        => $gmail,
            'username'     => $username,
            'password'     => $password
        ]);

        // Cari data yang baru dimasukkan untuk login
        $anggota = $model->where('username', $username)->first();
        if ($anggota) {
            $session->set([
                'logged_in' => true,
                'role'       => 'anggota',
                'anggota_id' => $anggota['id'],
                'nama'       => $anggota['nama'],
                'username'   => $anggota['username']
            ]);

            return redirect()->to('/')->with('success', 'Pendaftaran berhasil! Selamat datang di PawLib 🐾');
        }

        return redirect()->to('/auth')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}