<?php
require_once 'auth_check.php';
require_once 'koneksi.php';
$active_menu = 'dashboard';
$page_name   = 'Dashboard';

$res_berita     = $conn->query("SELECT COUNT(*) as total FROM berita WHERE status='publish'");
$total_berita   = $res_berita->fetch_assoc()['total'];

$res_berita_all = $conn->query("SELECT COUNT(*) as total FROM berita");
$total_berita_all = $res_berita_all->fetch_assoc()['total'];

$res_fasilitas  = $conn->query("SELECT COUNT(*) as total FROM fasilitas");
$total_fasilitas = $res_fasilitas->fetch_assoc()['total'];

$res_aspirasi   = $conn->query("SELECT COUNT(*) as total FROM aspirasi WHERE status != 'dibalas'");
$total_aspirasi = $res_aspirasi->fetch_assoc()['total'];

$res_pengunjung = $conn->query("SELECT SUM(jumlah) as total FROM pengunjung WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$total_pengunjung = $res_pengunjung->fetch_assoc()['total'] ?? 0;
$rata_rata = $total_pengunjung > 0 ? round($total_pengunjung / 7) : 0;
$res_tertinggi  = $conn->query("SELECT MAX(jumlah) as t FROM pengunjung WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$pengunjung_tertinggi = $res_tertinggi->fetch_assoc()['t'] ?? 0;
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

    <!-- Header -->
    <div class="page-header">
        <div>
            <div class="page-heading">Ringkasan Dashboard</div>
            <div class="page-subheading">Selamat datang kembali di <strong style="color:var(--ap-green)">The Academic Pulse</strong>. Berikut adalah rangkuman aktivitas sekolah hari ini.</div>
        </div>
        <div class="page-header-actions">
            <span style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:9px;border:1.5px solid var(--gray-200);background:white;font-size:.82rem;color:var(--gray-600);font-weight:500">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <?= date('M Y') ?>
            </span>
            <a href="berita.php?action=add" class="btn btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Berita Baru
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Berita</div>
                <div class="stat-value"><?= number_format($total_berita_all, 0, ',', '.') ?></div>
                <div class="stat-change up">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                    +12% &nbsp;<span style="color:var(--gray-400);font-weight:400">Diterbitkan bulan ini</span>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Fasilitas</div>
                <div class="stat-value"><?= number_format($total_fasilitas) ?></div>
                <div class="stat-change neutral">
                    <span class="stat-change-tag tetap">Tetap</span> &nbsp;Update terakhir 2 hari lalu
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Aspirasi Baru</div>
                <div class="stat-value"><?= number_format($total_aspirasi) ?></div>
                <div class="stat-change down">
                    <span class="stat-change-tag penting">Penting</span>&nbsp;
                    <span style="color:var(--gray-400);font-weight:400">Menunggu tanggapan admin</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="dash-grid">
        <!-- Left: Chart -->
        <div>
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <div>
                        <div class="card-title">Volume Aspirasi Bulanan</div>
                        <div class="card-subtitle">Data kumulatif aspirasi siswa dan guru</div>
                    </div>
                    <div style="display:flex;gap:6px">
                        <button class="btn btn-sm btn-outline" style="padding:5px 12px;font-size:.75rem">Weekly</button>
                        <button class="btn btn-sm" style="padding:5px 12px;font-size:.75rem;background:var(--gray-800);color:white;border-radius:7px">Monthly</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <?php
                        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'];
                        $month_nums = [1,2,3,4,5,6,7];
                        $vals = [];
                        foreach ($month_nums as $m) {
                            $r = $conn->query("SELECT COUNT(*) as c FROM aspirasi WHERE MONTH(created_at) = $m AND YEAR(created_at) = YEAR(CURDATE())");
                            $vals[] = $r ? ($r->fetch_assoc()['c'] ?? 0) : 0;
                        }
                        $max = max($vals) ?: 1;
                        foreach ($months as $i => $m):
                            $h = max(8, round(($vals[$i] / $max) * 160));
                            $isLast = ($i === count($months) - 1);
                        ?>
                        <div class="chart-bar-wrap">
                            <div class="chart-bar <?= $isLast ? 'active' : '' ?>" style="height:<?= $h ?>px" title="<?= $vals[$i] ?> aspirasi"></div>
                            <div class="chart-label"><?= $m ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div style="display:flex;gap:28px;margin-top:18px;padding-top:16px;border-top:1px solid var(--gray-100)">
                        <div>
                            <div style="font-size:.7rem;color:var(--gray-500);font-weight:600;text-transform:uppercase;letter-spacing:.3px">Total Pengunjung</div>
                            <div style="font-size:1.4rem;font-weight:800;color:var(--gray-900)"><?= number_format($total_pengunjung, 0, ',', '.') ?></div>
                        </div>
                        <div>
                            <div style="font-size:.7rem;color:var(--gray-500);font-weight:600;text-transform:uppercase;letter-spacing:.3px">Rata-rata/Hari</div>
                            <div style="font-size:1.4rem;font-weight:800;color:var(--ap-green)"><?= number_format($rata_rata) ?></div>
                        </div>
                        <div>
                            <div style="font-size:.7rem;color:var(--gray-500);font-weight:600;text-transform:uppercase;letter-spacing:.3px">Tertinggi</div>
                            <div style="font-size:1.4rem;font-weight:800;color:var(--ap-yellow-dk)"><?= number_format($pengunjung_tertinggi) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Activity -->
        <div>
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Aktivitas Terkini</div>
                    </div>
                </div>
                <div class="card-body" style="padding:0 22px">
                    <div class="activity-list">
                        <?php
                        $q_b = $conn->query("SELECT judul, tanggal FROM berita ORDER BY id DESC LIMIT 1");
                        if ($b = $q_b->fetch_assoc()):
                        ?>
                        <div class="activity-item">
                            <div class="activity-dot green">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1a6b4a" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/></svg>
                            </div>
                            <div>
                                <div class="activity-text"><strong>Berita Diupdate</strong><br>"<?= htmlspecialchars(substr($b['judul'],0,40)) ?>…"</div>
                                <div class="activity-time"><?= date('d M Y', strtotime($b['tanggal'])) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php
                        $q_a = $conn->query("SELECT nama, pesan, created_at FROM aspirasi ORDER BY id DESC LIMIT 2");
                        while ($a = $q_a->fetch_assoc()):
                        ?>
                        <div class="activity-item">
                            <div class="activity-dot yellow">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d4a820" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            <div>
                                <div class="activity-text"><strong>Aspirasi Masuk</strong><br><?= htmlspecialchars(substr($a['pesan'],0,50)) ?>…</div>
                                <div class="activity-time"><?= date('d M, H:i', strtotime($a['created_at'])) ?></div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php
                        $q_f = $conn->query("SELECT nama_fasilitas FROM fasilitas ORDER BY id DESC LIMIT 1");
                        if ($f = $q_f->fetch_assoc()):
                        ?>
                        <div class="activity-item">
                            <div class="activity-dot blue">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                            </div>
                            <div>
                                <div class="activity-text"><strong>Fasilitas Baru Ditambahkan</strong><br><?= htmlspecialchars($f['nama_fasilitas']) ?> telah ditambahkan ke database.</div>
                                <div class="activity-time">Data terbaru</div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="activity-item">
                            <div class="activity-dot" style="background:var(--gray-100)">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            </div>
                            <div>
                                <div class="activity-text"><strong>Login Terdeteksi</strong><br>Admin masuk ke sistem.</div>
                                <div class="activity-time">Sesi ini</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="aspirasi.php" class="btn btn-outline" style="width:100%;justify-content:center">
                        Lihat Semua Aktivitas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Spotlight Card -->
    <?php
    $q_best = $conn->query("SELECT judul FROM berita WHERE status='publish' ORDER BY id DESC LIMIT 1");
    $best = $q_best ? $q_best->fetch_assoc() : null;
    ?>
    <div class="spotlight-card">
        <div class="spotlight-img-box">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(0,0,0,0.2)" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div style="flex:1">
            <span class="spotlight-badge">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Prestasi Siswa Bulan Ini
            </span>
            <div class="spotlight-title">
                <?= $best ? htmlspecialchars(substr($best['judul'], 0, 60)) : 'Belum ada data Berita Terbaru' ?>
            </div>
            <div class="spotlight-desc">
                Tim media sekolah disarankan untuk segera merilis artikel profil lengkap mengenai prestasi terbaru sekolah.
            </div>
            <div class="spotlight-actions">
                <a href="berita.php?action=add" class="btn btn-green" style="padding:9px 20px;font-size:.83rem">Draft Berita</a>
                <a href="berita.php" class="btn btn-outline" style="padding:9px 20px;font-size:.83rem">
                    Lihat Detail →
                </a>
            </div>
        </div>
        <svg style="position:absolute;right:28px;top:50%;transform:translateY(-50%);opacity:.08" width="160" height="160" viewBox="0 0 24 24" fill="#d4a820"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
    </div>

</div><!-- /page-content -->
</div><!-- /admin-main -->
</div><!-- /admin-layout -->
</body>
</html>
