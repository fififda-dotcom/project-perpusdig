<?php

namespace App\Controllers;

use App\Models\NotifikasiModel;

class Notifikasi extends BaseController
{
    public function baca($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $model = new NotifikasiModel();
        $notif = $model->find($id);

        if ($notif) {
            // Verify ownership
            $role = session()->get('role');
            $userId = session()->get('anggota_id');
            
            $isAuthorized = false;
            if ($role === 'admin' && $notif['role'] === 'admin') {
                $isAuthorized = true;
            } elseif ($role === 'anggota' && $notif['role'] === 'anggota' && (int)$notif['user_id'] === (int)$userId) {
                $isAuthorized = true;
            }

            if ($isAuthorized) {
                $model->update($id, ['status' => 'dibaca']);
                if (!empty($notif['link'])) {
                    return redirect()->to($notif['link']);
                }
            }
        }

        return redirect()->back();
    }

    public function baca_semua()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        $userId = session()->get('anggota_id');

        $model = new NotifikasiModel();
        
        $builder = $model->where('status', 'belum_dibaca');
        if ($role === 'admin') {
            $builder->where('role', 'admin');
        } else {
            $builder->where('role', 'anggota')->where('user_id', $userId);
        }

        $builder->set(['status' => 'dibaca'])->update();

        return redirect()->back();
    }
}
