<?php
require_once 'auth_check.php';
require_once 'koneksi.php';
$active_menu = 'dashboard';
$page_name   = 'Dashboard';

// Ambil total berita dipublikasi
$res_berita = $conn->query("SELECT COUNT(*) as total FROM berita WHERE status='publish'");
$total_berita = $res_berita->fetch_assoc()['total'];

// Ambil aspirasi belum dibalas (status = baru atau dibaca)
$res_aspirasi = $conn->query("SELECT COUNT(*) as total FROM aspirasi WHERE status != 'dibalas'");
$total_aspirasi = $res_aspirasi->fetch_assoc()['total'];

// Pengunjung minggu ini
$res_pengunjung = $conn->query("SELECT SUM(jumlah) as total FROM pengunjung WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$total_pengunjung = $res_pengunjung->fetch_assoc()['total'] ?? 0;

// Rata-rata / Hari minggu ini
$rata_rata = $total_pengunjung > 0 ? round($total_pengunjung / 7) : 0;

// Pengunjung tertinggi
$res_tertinggi = $conn->query("SELECT MAX(jumlah) as tertinggi FROM pengunjung WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$pengunjung_tertinggi = $res_tertinggi->fetch_assoc()['tertinggi'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin SMP PGRI Ciomas</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">

<?php include 'components/sidebar.php'; ?>

<div class="admin-main">
<?php include 'components/topbar.php'; ?>

<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-heading">Dashboard</div>
            <div class="page-subheading">Selamat datang kembali, Admin! Berikut ringkasan hari ini.</div>
        </div>
        <div class="page-header-actions">
            <a href="berita.php?action=add" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Berita
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-value"><?= number_format($total_berita, 0, ',', '.') ?></div>
                <div class="stat-label">Berita Dipublikasi</div>
                <div class="stat-change up">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                    Total keseluruhan
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-value"><?= number_format($total_aspirasi, 0, ',', '.') ?></div>
                <div class="stat-label">Aspirasi Belum Dibalas</div>
                <div class="stat-change down">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    Perlu segera ditangani
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-value"><?= number_format($total_pengunjung, 0, ',', '.') ?></div>
                <div class="stat-label">Pengunjung Minggu Ini</div>
                <div class="stat-change up">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                    Statistik 7 Hari
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="dash-grid">
        <!-- Left: Chart + Berita Terbaru -->
        <div style="display:flex;flex-direction:column;gap:20px">

            <!-- Pengunjung Chart -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Statistik Pengunjung Website</div>
                        <div class="card-subtitle">7 hari terakhir</div>
                    </div>
                    <div style="display:flex;gap:8px">
                        <button class="btn btn-sm btn-outline" style="padding:5px 12px;font-size:.75rem">Minggu</button>
                        <button class="btn btn-sm btn-primary" style="padding:5px 12px;font-size:.75rem">Bulan</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <?php
                        // Ambil 7 hari terakhir
                        $days_query = $conn->query("SELECT DATE_FORMAT(tanggal, '%a') as hari, jumlah FROM pengunjung ORDER BY tanggal ASC LIMIT 7");
                        $days = [];
                        $vals = [];
                        $map_hari = ['Sun'=>'Min','Mon'=>'Sen','Tue'=>'Sel','Wed'=>'Rab','Thu'=>'Kam','Fri'=>'Jum','Sat'=>'Sab'];
                        while($r = $days_query->fetch_assoc()){
                            $days[] = $map_hari[$r['hari']] ?? $r['hari'];
                            $vals[] = $r['jumlah'];
                        }
                        if (empty($vals)) {
                            $days = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
                            $vals = [0, 0, 0, 0, 0, 0, 0];
                        }
                        $max  = max($vals);
                        if ($max == 0) $max = 1;
                        foreach ($days as $i => $d):
                            $h = round(($vals[$i] / $max) * 160);
                            $active = $i === (count($days)-1) ? 'active' : '';
                        ?>
                        <div class="chart-bar-wrap">
                            <div class="chart-bar <?= $active ?>" style="height:<?= $h ?>px" title="<?= $vals[$i] ?> pengunjung"></div>
                            <div class="chart-label"><?= $d ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div style="display:flex;gap:24px;margin-top:16px;padding-top:16px;border-top:1px solid var(--gray-100)">
                        <div>
                            <div style="font-size:.72rem;color:var(--gray-600);font-weight:500">Total Pengunjung</div>
                            <div style="font-size:1.3rem;font-weight:800;color:var(--gray-900)"><?= number_format($total_pengunjung, 0, ',', '.') ?></div>
                        </div>
                        <div>
                            <div style="font-size:.72rem;color:var(--gray-600);font-weight:500">Rata-rata/Hari</div>
                            <div style="font-size:1.3rem;font-weight:800;color:var(--green-main)"><?= number_format($rata_rata, 0, ',', '.') ?></div>
                        </div>
                        <div>
                            <div style="font-size:.72rem;color:var(--gray-600);font-weight:500">Tertinggi</div>
                            <div style="font-size:1.3rem;font-weight:800;color:var(--yellow-dark)"><?= number_format($pengunjung_tertinggi, 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Berita Terbaru</div>
                    <a href="berita.php" class="btn btn-sm btn-outline">Lihat Semua</a>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Judul Berita</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q_berita = $conn->query("SELECT * FROM berita ORDER BY id DESC LIMIT 4");
                            while ($b = $q_berita->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="td-name"><?= htmlspecialchars(substr($b['judul'], 0, 50)) . (strlen($b['judul']) > 50 ? '...' : '') ?></div>
                                </td>
                                <td><span class="badge badge-green"><?= htmlspecialchars($b['kategori']) ?></span></td>
                                <td style="color:var(--gray-600);font-size:.8rem"><?= date('d M Y', strtotime($b['tanggal'])) ?></td>
                                <td>
                                    <?php if ($b['status'] === 'publish'): ?>
                                    <span class="badge badge-green"><span class="badge-dot"></span>Tayang</span>
                                    <?php else: ?>
                                    <span class="badge badge-gray"><span class="badge-dot"></span>Draft</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div style="display:flex;flex-direction:column;gap:20px">

            <!-- Aspirasi Terbaru -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Aspirasi Terbaru</div>
                        <div class="card-subtitle">Perlu ditindaklanjuti</div>
                    </div>
                    <?php if($total_aspirasi > 0): ?>
                    <span class="badge badge-red"><?= $total_aspirasi ?> Baru</span>
                    <?php endif; ?>
                </div>
                <div class="card-body" style="padding:0">
                    <div class="activity-list" style="padding:0 22px">
                        <?php
                        $q_asp = $conn->query("SELECT * FROM aspirasi WHERE status != 'dibalas' ORDER BY id DESC LIMIT 4");
                        while ($a = $q_asp->fetch_assoc()): 
                            $waktu = date('d M H:i', strtotime($a['created_at']));
                        ?>
                        <div class="activity-item">
                            <div class="activity-dot <?= $a['prioritas'] ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            <div>
                                <div class="activity-text">
                                    <strong><?= htmlspecialchars($a['nama']) ?></strong> — <?= htmlspecialchars(substr($a['pesan'], 0, 45)) ?>...
                                </div>
                                <div class="activity-time"><?= $waktu ?></div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="aspirasi.php" class="btn btn-sm btn-primary" style="width:100%;justify-content:center">
                        Kelola Semua Aspirasi →
                    </a>
                </div>
            </div>

            <!-- Fasilitas Quick Links -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Fasilitas Sekolah</div>
                    <a href="fasilitas.php" class="btn btn-sm btn-outline">Kelola</a>
                </div>
                <div class="card-body" style="padding:16px 22px">
                    <?php
                    $q_fas = $conn->query("SELECT * FROM fasilitas LIMIT 5");
                    while ($f = $q_fas->fetch_assoc()): ?>
                    <div class="info-row">
                        <span class="info-row-label"><?= htmlspecialchars($f['nama_fasilitas']) ?></span>
                        <span class="badge badge-green" style="font-size:.68rem"><?= htmlspecialchars($f['kategori']) ?></span>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Info Sekolah -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Info Sekolah</div>
                    <a href="pengaturan.php" class="btn btn-sm btn-outline">Edit</a>
                </div>
                <div class="card-body" style="padding:16px 22px">
                    <?php
                    $q_info = $conn->query("SELECT * FROM pengaturan LIMIT 1");
                    $i = $q_info->fetch_assoc();
                    if($i): ?>
                    <div class="info-row">
                        <span class="info-row-label">NPSN</span>
                        <span class="info-row-value"><?= htmlspecialchars($i['npsn']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Akreditasi</span>
                        <span class="info-row-value"><?= htmlspecialchars($i['akreditasi']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Tahun Berdiri</span>
                        <span class="info-row-value"><?= htmlspecialchars($i['tahun_berdiri']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Kepala Sekolah</span>
                        <span class="info-row-value"><?= htmlspecialchars($i['kepala_sekolah']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Telp</span>
                        <span class="info-row-value"><?= htmlspecialchars($i['telp']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div><!-- /dash-grid -->

</div><!-- /page-content -->
</div><!-- /admin-main -->
</div><!-- /admin-layout -->
</body>
</html>
