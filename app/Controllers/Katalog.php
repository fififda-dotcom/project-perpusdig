<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Katalog extends BaseController
{
  public function index()
{
    $model = new \App\Models\BukuModel();

    $keyword = $this->request->getGet('keyword');

    if ($keyword) {
        $model->groupStart()
              ->like('judul', $keyword)
              ->orLike('penulis', $keyword)
              ->groupEnd();
    }

    $data['keyword'] = $keyword;
    $data['buku'] = $model->findAll();

    return view('katalog', $data);
}
}