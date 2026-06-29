<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        return view('admin');
    }

    public function pengaturan_berita()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth');
        }

        $filePath = WRITEPATH . 'news_settings.json';
        $settings = [
            'cnn_enabled' => true,
            'cnbc_enabled' => true,
            'detik_enabled' => true,
            'antara_enabled' => true,
            'news_keyword' => ''
        ];

        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            $json = json_decode($content, true);
            if (is_array($json)) {
                $settings = array_merge($settings, $json);
            }
        }

        $data['settings'] = $settings;
        $data['role'] = 'admin';

        return view('pengaturan_berita', $data);
    }

    public function simpan_pengaturan_berita()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth');
        }

        $cnnEnabled = $this->request->getPost('cnn_enabled') === '1';
        $cnbcEnabled = $this->request->getPost('cnbc_enabled') === '1';
        $detikEnabled = $this->request->getPost('detik_enabled') === '1';
        $antaraEnabled = $this->request->getPost('antara_enabled') === '1';
        $newsKeyword = trim((string)$this->request->getPost('news_keyword'));

        $settings = [
            'cnn_enabled' => $cnnEnabled,
            'cnbc_enabled' => $cnbcEnabled,
            'detik_enabled' => $detikEnabled,
            'antara_enabled' => $antaraEnabled,
            'news_keyword' => $newsKeyword
        ];

        $filePath = WRITEPATH . 'news_settings.json';
        
        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        file_put_contents($filePath, json_encode($settings, JSON_PRETTY_PRINT));

        session()->setFlashdata('success', 'Pengaturan filter berita berhasil disimpan!');
        return redirect()->to('/admin/pengaturan_berita');
    }
}