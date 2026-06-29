<!DOCTYPE html>
<html>
<head>
<!-- Menggunakan Font Awesome versi 6 (sesuai bawaan proyek Anda) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<title>PawLib</title>

<style>
body{
margin:0;
font-family:Arial;
background:#FFF8EE;
display:flex;
}

.sidebar{
width:250px;
height:100vh;
background:#FFFDF9;
box-shadow:4px 0 15px rgba(0,0,0,0.05);
padding:20px;
position:fixed;
box-sizing: border-box;
z-index: 999; /* Biar sidebar gak tertutup banner */
}

.sidebar h2{
color:#E69C62;
}

.sidebar a{
display:flex;
align-items:center;
gap:12px;
padding:14px;
text-decoration:none;
color:#444;
border-radius:14px;
margin-bottom:10px;
font-weight:bold;
}

.sidebar a i{
width:20px;
}

.sidebar a:hover{
background:#FBE7D4;
}

.main{
margin-left:250px;
width:calc(100% - 250px);
display:flex;
flex-direction:column;
min-height:100vh;
}

.topbar{
background:white;
padding:15px 25px;
box-shadow:0 4px 10px rgba(0,0,0,0.05);
font-weight:bold;
display: flex;
justify-content: space-between;
align-items: center;
box-sizing: border-box;
width: 100%;
}

.topbar-left {
display: flex;
align-items: center;
}

.content{
padding:40px;
box-sizing:border-box;
flex: 1 0 auto;
}

.footer{
background:white;
padding:20px;
text-align:center;
}

#toggle-btn{
background:none;
border:none;
font-size:24px;
cursor:pointer;
margin-right:15px;
}

body.hide-sidebar .sidebar{
transform:translateX(-100%);
}

body.hide-sidebar .main{
margin-left:0;
width:100%;
}

.sidebar{
transition:.3s;
}

.main{
transition:.3s;
}

/* ======================================================= */
/* STYLE KUSTOM DROPDOWN USER PROFILE PAWLIB (BARU & ELEGAN) */
/* ======================================================= */
.paw-dropdown {
    position: relative;
    display: inline-block;
}

.paw-dropdown-btn {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 12px;
    border-radius: 12px;
    font-weight: bold;
    font-family: Arial, sans-serif;
    color: #444;
    transition: background 0.2s;
}

.paw-dropdown-btn:hover {
    background: #FBE7D4;
}

.paw-avatar-mini {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #FFFDF9;
    border: 2px solid #E69C62;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #E69C62;
    overflow: hidden;
}

.paw-avatar-mini img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.paw-username-text {
    font-size: 0.95rem;
    color: #444;
}

.paw-dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 45px;
    background-color: white;
    min-width: 210px;
    box-shadow: 0 8px 24px rgba(74, 60, 49, 0.12);
    border-radius: 16px;
    border: 2px solid #f2e7dd;
    z-index: 1000;
    overflow: hidden;
    padding: 8px 0;
    text-align: left;
}

.paw-dropdown-content.show {
    display: block;
}

.paw-dropdown-content a {
    color: #444;
    padding: 10px 18px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: bold;
    font-size: 0.9rem;
    transition: background 0.2s;
}

.paw-dropdown-content a:hover {
    background-color: #FBE7D4;
    color: #444;
}

.paw-dropdown-header {
    padding: 8px 18px 12px 18px;
    border-bottom: 1px solid #f2e7dd;
    font-size: 0.8rem;
    color: #888;
    margin-bottom: 8px;
}

.paw-role-tag {
    background: #E69C62;
    color: white;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: bold;
    display: inline-block;
    margin-left: 5px;
}

.paw-dropdown-divider {
    height: 1px;
    background-color: #f2e7dd;
    margin: 8px 0;
}

.logout-link {
    color: #EF4444 !important;
}

/* Style Notifikasi */
.paw-notif-item {
    display: block; 
    padding: 12px 18px; 
    border-bottom: 1px solid #f2e7dd; 
    text-decoration: none !important; 
    color: #4a3c31 !important; 
    font-size: 0.8rem;
    font-weight: normal;
    transition: background 0.2s;
    box-sizing: border-box;
}
.paw-notif-item:hover {
    background-color: #fffbf7;
}
.paw-notif-badge {
    position: absolute;
    top: -2px;
    right: -2px;
    background: #EF4444;
    color: white;
    font-size: 0.7rem;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 10px;
    border: 2px solid white;
    line-height: 1;
}

.btn-login-header {
    background: #E69C62;
    color: white !important;
    padding: 8px 18px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s;
}

.btn-login-header:hover {
    background: #c8814a;
}

/* Custom Grid System Fallback (Bootstrap style) */
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -12px;
    margin-left: -12px;
}
.col-md-4, .col-md-6, .col-md-8 {
    padding-right: 12px;
    padding-left: 12px;
    box-sizing: border-box;
}
.col-md-4 {
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
}
.col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
}
.col-md-8 {
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
}
@media (max-width: 992px) {
    .col-md-4, .col-md-6, .col-md-8 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>

</head>
<body id="body">

<div class="main">
    
    <div class="topbar">
        <!-- Sisi Kiri Topbar -->
        <div class="topbar-left">
            <button id="toggle-btn"><i class="fa fa-bars"></i></button>
            <span>PawLib Dashboard</span>
        </div>

        <!-- Sisi Kanan Topbar: Dropdown User 👤 (BARU) -->
        <div class="topbar-right" style="display: flex; align-items: center; gap: 10px;">
            <?php if (session()->get('logged_in')) : ?>
                <!-- Notification Bell 🔔 -->
                <div class="paw-dropdown">
                    <button class="paw-dropdown-btn" id="notifDropdownBtn" style="position: relative; padding: 10px; display: flex; align-items: center; justify-content: center; background: none; border-radius: 50%;">
                        <i class="fas fa-bell" style="font-size: 1.2rem; color: #E69C62;"></i>
                        <?php 
                        $db = \Config\Database::connect();
                        $userId = session()->get('anggota_id');
                        $role = session()->get('role');
                        
                        $dynamicNotifCount = 0;
                        $dueLoans = [];
                        if ($role == 'anggota' && $userId) {
                            $dueLoans = $db->table('peminjaman')
                                           ->select('peminjaman.*, buku.judul')
                                           ->join('buku', 'buku.id = peminjaman.buku_id')
                                           ->where('peminjaman.anggota_id', $userId)
                                           ->where('peminjaman.status', 'Dipinjam')
                                           ->get()
                                           ->getResultArray();
                            
                            $today = strtotime(date('Y-m-d'));
                            foreach ($dueLoans as $loan) {
                                $tanggalKembali = strtotime($loan['tanggal_kembali']);
                                if ($tanggalKembali > 0) {
                                    if ($today > $tanggalKembali) {
                                        $dynamicNotifCount++;
                                    } elseif ($tanggalKembali - $today <= 2 * 24 * 60 * 60) {
                                        $dynamicNotifCount++;
                                    }
                                }
                            }
                        }

                        $dbNotifCountQuery = $db->table('notifikasi')
                                                ->where('status', 'belum_dibaca');
                        if ($role == 'admin') {
                            $dbNotifCountQuery->where('role', 'admin');
                        } else {
                            $dbNotifCountQuery->where('role', 'anggota')->where('user_id', $userId);
                        }
                        $dbNotifCount = $dbNotifCountQuery->countAllResults();
                        $totalUnreadNotif = $dbNotifCount + $dynamicNotifCount;
                        ?>
                        <?php if ($totalUnreadNotif > 0): ?>
                            <span class="paw-notif-badge"><?= $totalUnreadNotif ?></span>
                        <?php endif; ?>
                    </button>
                    
                    <div class="paw-dropdown-content" id="notifDropdownContent" style="min-width: 320px; right: 0;">
                        <div class="paw-dropdown-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f2e7dd; padding-bottom: 8px;">
                            <span>Notifikasi Saya</span>
                            <?php if ($dbNotifCount > 0): ?>
                                <a href="/notifikasi/baca_semua" style="font-size: 0.75rem; color: #E69C62; padding: 0; display: inline; font-weight: normal; background: none;">Tandai semua dibaca</a>
                            <?php endif; ?>
                        </div>
                        
                        <div style="max-height: 300px; overflow-y: auto;">
                            <?php 
                            $hasNotif = false;
                            if (!empty($dueLoans)) {
                                $today = strtotime(date('Y-m-d'));
                                foreach ($dueLoans as $loan) {
                                    $tanggalKembali = strtotime($loan['tanggal_kembali']);
                                    if ($tanggalKembali > 0) {
                                        if ($today > $tanggalKembali) {
                                            $hasNotif = true;
                                            $selisihDetik = $today - $tanggalKembali;
                                            $selisihHari = floor($selisihDetik / (60 * 60 * 24));
                                            $dendaEstimasi = $selisihHari * 2000;
                                            ?>
                                            <div style="padding: 12px 18px; border-bottom: 1px solid #f2e7dd; background: #fff5f5; text-align: left;">
                                                <div style="font-weight: bold; color: #EF4444; font-size: 0.85rem;"><i class="fas fa-exclamation-triangle"></i> Terlambat Mengembalikan!</div>
                                                <div style="font-size: 0.8rem; color: #4a3c31; margin-top: 4px; line-height: 1.4;">
                                                    Buku "<strong><?= esc($loan['judul']) ?></strong>" sudah melewati batas waktu (<?= date('d M Y', $tanggalKembali) ?>). Estimasi denda: <strong>Rp <?= number_format($dendaEstimasi, 0, ',', '.') ?></strong>.
                                                </div>
                                                <a href="/profile/riwayat" style="padding: 4px 0 0 0; font-size: 0.75rem; color: #E69C62; font-weight: bold; display: block; background: none; text-decoration: none;">Ajukan Pengembalian</a>
                                            </div>
                                            <?php
                                        } elseif ($tanggalKembali - $today <= 2 * 24 * 60 * 60) {
                                            $hasNotif = true;
                                            $sisaHari = ceil(($tanggalKembali - $today) / (24 * 60 * 60));
                                            $sisaHariText = $sisaHari == 0 ? "hari ini" : ($sisaHari == 1 ? "besok" : "$sisaHari hari lagi");
                                            ?>
                                            <div style="padding: 12px 18px; border-bottom: 1px solid #f2e7dd; background: #fffdf5; text-align: left;">
                                                <div style="font-weight: bold; color: #E69C62; font-size: 0.85rem;"><i class="fas fa-clock"></i> Batas Waktu Mendekati</div>
                                                <div style="font-size: 0.8rem; color: #4a3c31; margin-top: 4px; line-height: 1.4;">
                                                    Buku "<strong><?= esc($loan['judul']) ?></strong>" harus dikembalikan <?= $sisaHariText ?> (<?= date('d M Y', $tanggalKembali) ?>).
                                                </div>
                                                <a href="/profile/riwayat" style="padding: 4px 0 0 0; font-size: 0.75rem; color: #E69C62; font-weight: bold; display: block; background: none; text-decoration: none;">Ajukan Pengembalian</a>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }
                            
                            $dbNotifsQuery = $db->table('notifikasi');
                            if ($role == 'admin') {
                                $dbNotifsQuery->where('role', 'admin');
                            } else {
                                $dbNotifsQuery->where('role', 'anggota')->where('user_id', $userId);
                            }
                            $dbNotifs = $dbNotifsQuery->orderBy('id', 'DESC')->limit(8)->get()->getResultArray();
                            
                            foreach ($dbNotifs as $n) {
                                $hasNotif = true;
                                $nStyle = $n['status'] == 'belum_dibaca' ? 'background: #fffaf5;' : '';
                                $icon = '<i class="fas fa-info-circle" style="color: #E69C62;"></i>';
                                if (strpos(strtolower($n['judul']), 'pengajuan') !== false) {
                                    $icon = '<i class="fas fa-file-invoice" style="color: #3498db;"></i>';
                                } elseif (strpos(strtolower($n['judul']), 'berhasil') !== false || strpos(strtolower($n['judul']), 'sukses') !== false) {
                                    $icon = '<i class="fas fa-check-circle" style="color: #2ecc71;"></i>';
                                }
                                ?>
                                <a href="/notifikasi/baca/<?= $n['id'] ?>" class="paw-notif-item" style="<?= $nStyle ?>">
                                    <div style="font-weight: bold; margin-bottom: 2px; text-align: left;"><?= $icon ?> <?= esc($n['judul']) ?></div>
                                    <div style="color: #666; font-size: 0.75rem; text-align: left; line-height: 1.4;"><?= esc($n['pesan']) ?></div>
                                    <div style="font-size: 0.65rem; color: #aaa; margin-top: 4px; text-align: left;"><?= date('d M Y H:i', strtotime($n['created_at'])) ?></div>
                                </a>
                                <?php
                            }
                            
                            if (!$hasNotif) {
                                ?>
                                <div style="padding: 30px; text-align: center; color: #aaa; font-size: 0.9rem;">
                                    <i class="fas fa-bell-slash" style="font-size: 2rem; color: #ebd5c5; margin-bottom: 10px; display: block;"></i>
                                    Tidak ada notifikasi baru
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="paw-dropdown">
                    <!-- Tombol Pemicu Dropdown -->
                    <button class="paw-dropdown-btn" id="profileDropdownBtn">
                        <div class="paw-avatar-mini">
                            <!-- Cek jika ada foto profil anggota -->
                            <?php if (session()->get('role') == 'anggota' && !empty($anggota['foto'])): ?>
                                <img src="/uploads/profile/<?= $anggota['foto'] ?>" alt="Foto">
                            <?php else: ?>
                                <i class="fas fa-paw"></i>
                            <?php endif; ?>
                        </div>
                        <span class="paw-username-text"><?= session()->get('nama') ?? session()->get('username') ?></span>
                        <i class="fas fa-chevron-down" style="font-size: 0.75rem; opacity: 0.7;"></i>
                    </button>
                    
                    <!-- Isi Menu Dropdown -->
                    <div class="paw-dropdown-content" id="profileDropdownContent">
                        <div class="paw-dropdown-header">
                            Akses: <span class="paw-role-tag"><?= strtoupper(session()->get('role')) ?></span>
                        </div>
                        
                        <a href="/profile"><i class="fas fa-user-circle" style="color: #E69C62;"></i> Profil Saya</a>
                        
                        <?php if (session()->get('role') == 'anggota') : ?>
                            <a href="/profile/ulasan"><i class="far fa-comment-dots" style="color: #E69C62;"></i> Ulasan Saya</a>
                            <!-- Mengarah ke riwayat peminjaman di profil -->
                            <a href="/profile/riwayat"><i class="fas fa-history"></i> Riwayat Pinjam</a>
                        <?php endif; ?>
                        
                        <div class="paw-dropdown-divider"></div>
                        
                        <a href="/auth/logout" class="logout-link" onclick="return confirm('Yakin ingin keluar dari PawLib?')">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            <?php else : ?>
                <!-- Tombol Login jika belum masuk -->
                <a href="/auth" class="btn-login-header">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="content">

<!-- Script JS Vanilla agar Dropdown Interaktif Tanpa Bergantung ke Bootstrap JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtn = document.getElementById('profileDropdownBtn');
    const dropdownContent = document.getElementById('profileDropdownContent');
    const notifBtn = document.getElementById('notifDropdownBtn');
    const notifContent = document.getElementById('notifDropdownContent');

    if (dropdownBtn && dropdownContent) {
        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (notifContent) notifContent.classList.remove('show');
            dropdownContent.classList.toggle('show');
        });
    }

    if (notifBtn && notifContent) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (dropdownContent) dropdownContent.classList.remove('show');
            notifContent.classList.toggle('show');
        });
    }

    document.addEventListener('click', function(e) {
        if (dropdownBtn && !dropdownBtn.contains(e.target) && dropdownContent && !dropdownContent.contains(e.target)) {
            dropdownContent.classList.remove('show');
        }
        if (notifBtn && !notifBtn.contains(e.target) && notifContent && !notifContent.contains(e.target)) {
            notifContent.classList.remove('show');
        }
    });
});
</script>