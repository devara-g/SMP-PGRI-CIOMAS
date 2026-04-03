<?php
session_start();
require_once 'auth_check.php';
require_once 'koneksi.php';
$active_menu = 'aspirasi';
$page_name   = 'Manajemen Aspirasi';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM aspirasi WHERE id = $id");
    header("Location: aspirasi.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reply') {
    $id = (int)$_POST['id'];
    $conn->query("UPDATE aspirasi SET status = 'dibalas' WHERE id = $id");
    header("Location: aspirasi.php");
    exit;
}

// Statistik
$q_total = $conn->query("SELECT COUNT(*) as total FROM aspirasi");
$total_aspirasi = $q_total->fetch_assoc()['total'];

$q_belum = $conn->query("SELECT COUNT(*) as total FROM aspirasi WHERE status != 'dibalas'");
$belum_dibalas = $q_belum->fetch_assoc()['total'];

$q_sudah = $conn->query("SELECT COUNT(*) as total FROM aspirasi WHERE status = 'dibalas'");
$sudah_dibalas = $q_sudah->fetch_assoc()['total'];

$q_bulan = $conn->query("SELECT COUNT(*) as total FROM aspirasi WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())");
$masuk_bulan_ini = $q_bulan->fetch_assoc()['total'];

// Ambil data aspirasi
$aspirasi_data = [];
$q_data = $conn->query("SELECT * FROM aspirasi ORDER BY id DESC");
while($row = $q_data->fetch_assoc()) {
    $aspirasi_data[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspirasi - Admin SMP PGRI Ciomas</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
<?php include 'components/sidebar.php'; ?>
<div class="admin-main">
<?php include 'components/topbar.php'; ?>
<div class="page-content">

    <div class="page-header">
        <div class="page-header-left">
            <div class="page-heading">Manajemen Aspirasi</div>
            <div class="page-subheading">Tinjau dan tanggapi aspirasi dari siswa, orang tua, dan masyarakat</div>
        </div>
    </div>

    <!-- Stats mini -->
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
        <?php
        $mini_stats = [
            [number_format($total_aspirasi, 0, ',', '.'), 'Total Aspirasi', 'green', '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>'],
            [number_format($belum_dibalas, 0, ',', '.'), 'Belum Dibalas', 'red', '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'],
            [number_format($sudah_dibalas, 0, ',', '.'), 'Sudah Dibalas', 'blue', '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
            [number_format($masuk_bulan_ini, 0, ',', '.'), 'Masuk Bulan Ini', 'yellow', '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
        ];
        foreach ($mini_stats as $s): ?>
        <div class="card" style="padding:18px;display:flex;align-items:center;gap:14px">
            <div class="stat-icon <?= $s[2] ?>" style="width:40px;height:40px;border-radius:10px;flex-shrink:0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?= $s[3] ?></svg>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:var(--gray-900)"><?= $s[0] ?></div>
                <div style="font-size:.73rem;color:var(--gray-600);font-weight:500"><?= $s[1] ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pengirim</th>
                        <th>Isi Aspirasi</th>
                        <th>Peran</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($aspirasi_data as $a): 
                        $tanggal = date('d M Y', strtotime($a['created_at']));    
                    ?>
                    <tr>
                        <td style="color:var(--gray-400);font-size:.8rem">#<?= str_pad($a['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:32px;height:32px;border-radius:50%;background:var(--green-light);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--green-main)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                <div class="td-name" style="font-size:.84rem"><?= htmlspecialchars($a['nama']) ?></div>
                            </div>
                        </td>
                        <td style="max-width:320px">
                            <div style="font-size:.84rem;color:var(--gray-800);line-height:1.5">
                                <?= htmlspecialchars(substr($a['pesan'], 0, 70)) ?>...
                            </div>
                        </td>
                        <td>
                            <?php
                            $role_badge = ['Siswa' => 'badge-green', 'Orang Tua' => 'badge-blue', 'Alumni' => 'badge-yellow', 'Masyarakat' => 'badge-gray', 'Guru/Staff' => 'badge-red'];
                            $peran = $a['peran'] ?? 'Masyarakat';
                            $rb = $role_badge[$peran] ?? 'badge-gray';
                            ?>
                            <span class="badge <?= $rb ?>"><?= htmlspecialchars($peran) ?></span>
                        </td>
                        <td style="color:var(--gray-600);font-size:.8rem;white-space:nowrap"><?= $tanggal ?></td>
                        <td>
                            <?php if ($a['status'] !== 'dibalas'): ?>
                            <span class="badge badge-red"><span class="badge-dot"></span>Belum Dibalas</span>
                            <?php else: ?>
                            <span class="badge badge-green"><span class="badge-dot"></span>Sudah Dibalas</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="td-actions">
                                <button class="btn btn-sm btn-primary btn-icon" title="Balas" onclick="openReply(<?= $a['id'] ?>)">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                </button>
                                <a href="aspirasi.php?delete=<?= $a['id'] ?>" onclick="return confirm('Yakin ingin menghapus ini?')" class="btn btn-sm btn-danger btn-icon" title="Hapus">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
</div>

<!-- Reply Modal -->
<div class="modal-backdrop" id="reply-modal">
    <div class="modal">
        <form method="POST">
            <input type="hidden" name="action" value="reply">
            <input type="hidden" name="id" id="reply-id">
            <div class="modal-header">
                <div class="modal-title">Tandai Sudah Dibalas</div>
                <button type="button" class="modal-close" onclick="closeReply()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Apakah Anda sudah menindaklanjuti atau membalas aspirasi ini? Klik tandai agar statusnya berubah.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeReply()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Tandai Selesai
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openReply(id) {
    document.getElementById('reply-id').value = id;
    document.getElementById('reply-modal').classList.add('open');
}
function closeReply() {
    document.getElementById('reply-modal').classList.remove('open');
}
</script>
</body>
</html>
