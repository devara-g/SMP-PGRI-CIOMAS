<?php
session_start();
require_once 'auth_check.php';
require_once 'koneksi.php';
$active_menu = 'aspirasi';
$page_name   = 'Aspirasi';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM aspirasi WHERE id = $id");
    header("Location: aspirasi.php"); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reply') {
    $id = (int)$_POST['id'];
    $conn->query("UPDATE aspirasi SET status = 'dibalas' WHERE id = $id");
    header("Location: aspirasi.php"); exit;
}

$q_total   = $conn->query("SELECT COUNT(*) as c FROM aspirasi"); $total_asp = $q_total->fetch_assoc()['c'];
$q_belum   = $conn->query("SELECT COUNT(*) as c FROM aspirasi WHERE status != 'dibalas'"); $belum = $q_belum->fetch_assoc()['c'];
$q_sudah   = $conn->query("SELECT COUNT(*) as c FROM aspirasi WHERE status = 'dibalas'"); $sudah = $q_sudah->fetch_assoc()['c'];
$q_bulan   = $conn->query("SELECT COUNT(*) as c FROM aspirasi WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())"); $bulan_ini = $q_bulan->fetch_assoc()['c'];

$aspirasi_data = [];
$q_data = $conn->query("SELECT * FROM aspirasi ORDER BY id DESC");
while ($r = $q_data->fetch_assoc()) $aspirasi_data[] = $r;

function time_since($dt) {
    $diff = time() - strtotime($dt);
    if ($diff < 3600)    return floor($diff/60)  .' menit lalu';
    if ($diff < 86400)   return floor($diff/3600).' jam lalu';
    if ($diff < 604800)  return floor($diff/86400).' hari lalu';
    return floor($diff/604800).' minggu lalu';
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

    <!-- Header -->
    <div class="page-header">
        <div>
            <div style="font-size:.7rem;font-weight:700;color:var(--ap-green);text-transform:uppercase;letter-spacing:.8px;display:flex;align-items:center;gap:6px;margin-bottom:6px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Communication Hub
            </div>
            <div class="page-heading">Aspirasi &amp; Umpan Balik</div>
            <div class="page-subheading">Kelola suara dari komunitas SMP PGRI Ciomas. Setiap pesan adalah langkah menuju peningkatan kualitas pendidikan kita.</div>
        </div>
        <div class="page-header-actions">
            <button class="btn btn-outline">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
                Filter
            </button>
            <button class="btn btn-primary">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Laporan
            </button>
        </div>
    </div>

    <!-- 2-column layout -->
    <div style="display:grid;grid-template-columns:260px 1fr;gap:20px;align-items:start">

        <!-- Left sidebar -->
        <div style="display:flex;flex-direction:column;gap:16px">
            <!-- Total card -->
            <div style="background:var(--ap-dark);border-radius:var(--radius-md);padding:24px 22px;color:white">
                <div style="font-size:.75rem;font-weight:600;color:rgba(255,255,255,.55);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px">Total Aspirasi Bulan Ini</div>
                <div style="font-size:3rem;font-weight:900;color:white;line-height:1"><?= $bulan_ini ?></div>
                <div style="font-size:.78rem;color:rgba(255,255,255,.55);margin-top:8px;display:flex;align-items:center;gap:4px">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                    12% lebih tinggi dari bulan lalu
                </div>
            </div>

            <!-- Penting highlight -->
            <?php
            $q_penting = $conn->query("SELECT * FROM aspirasi WHERE prioritas='red' AND status != 'dibalas' ORDER BY id DESC LIMIT 1");
            $penting = $q_penting ? $q_penting->fetch_assoc() : null;
            if ($penting):
            ?>
            <div style="background:var(--ap-yellow-lt);border:1px solid rgba(240,192,64,.3);border-radius:var(--radius-md);padding:20px">
                <span class="badge badge-yellow" style="font-size:.62rem;letter-spacing:.5px">PENTING</span>
                <div style="margin-top:10px;font-weight:700;color:var(--gray-900);font-size:.9rem;line-height:1.4"><?= htmlspecialchars(substr($penting['pesan'],0,60)) ?>…</div>
                <div style="font-size:.75rem;color:var(--gray-500);margin-top:6px;font-style:italic">"Paling sering disuarakan minggu ini"</div>
                <button class="btn btn-outline" style="margin-top:12px;width:100%;justify-content:center;font-size:.78rem" onclick="openReply(<?= $penting['id'] ?>)">Buat Tanggapan Kolektif</button>
            </div>
            <?php else: ?>
            <div class="card">
                <div class="card-body" style="text-align:center;padding:20px;color:var(--gray-400);font-size:.85rem">
                    Belum ada aspirasi prioritas tinggi.
                </div>
            </div>
            <?php endif; ?>

            <!-- Mini stats -->
            <?php
            $minis = [[$total_asp,'Total','green'],[$belum,'Belum Dibalas','red'],[$sudah,'Sudah Dibalas','blue']];
            foreach ($minis as $m):
            ?>
            <div class="card" style="padding:14px 18px;display:flex;align-items:center;gap:12px">
                <div style="font-size:1.4rem;font-weight:800;color:var(--gray-900);min-width:40px"><?= $m[0] ?></div>
                <div style="font-size:.78rem;font-weight:600;color:var(--gray-500)"><?= $m[1] ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Right: List -->
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Riwayat Aspirasi</div>
                    <div style="display:flex;gap:8px">
                        <button class="btn btn-sm" style="background:var(--gray-900);color:white;border-radius:7px;padding:5px 14px;font-size:.75rem">Semua</button>
                        <button class="btn btn-sm btn-outline" style="font-size:.75rem">Siswa</button>
                        <button class="btn btn-sm btn-outline" style="font-size:.75rem">Wali Murid</button>
                    </div>
                </div>
                <div style="padding:0">
                    <?php foreach ($aspirasi_data as $a):
                        $role_badge = ['Siswa'=>'badge-green','Orang Tua'=>'badge-blue','Wali Murid'=>'badge-blue','Alumni'=>'badge-yellow','Masyarakat'=>'badge-gray','Guru/Staff'=>'badge-teal'];
                        $peran = $a['peran'] ?? 'Masyarakat';
                        $rb = $role_badge[$peran] ?? 'badge-gray';
                        $tgl = date('d M Y, H:i', strtotime($a['created_at']));
                    ?>
                    <div class="aspirasi-card" style="border-radius:0;border-left:none;border-right:none;border-top:none;margin-bottom:0;border-bottom:1px solid var(--gray-100);padding:18px 22px">
                        <div class="aspirasi-card-header">
                            <div style="display:flex;align-items:center;gap:10px">
                                <span class="badge <?= $rb ?>" style="font-size:.65rem;letter-spacing:.4px;text-transform:uppercase"><?= htmlspecialchars($peran) ?></span>
                                <span style="font-size:.75rem;color:var(--gray-400)"><?= $tgl ?></span>
                            </div>
                            <?php if ($a['status'] === 'dibalas'): ?>
                            <span class="badge badge-green" style="font-size:.68rem"><span class="badge-dot"></span>Ditanggapi</span>
                            <?php else: ?>
                            <span class="badge badge-yellow" style="font-size:.68rem"><span class="badge-dot"></span>Dilihat</span>
                            <?php endif; ?>
                        </div>
                        <div class="aspirasi-card-name" style="margin-top:8px"><?= htmlspecialchars($a['nama']) ?></div>
                        <div class="aspirasi-card-body"><?= htmlspecialchars(substr($a['pesan'],0,100)) ?>…</div>
                        <div class="aspirasi-card-footer">
                            <button class="btn btn-sm btn-outline" style="font-size:.75rem" onclick="openReply(<?= $a['id'] ?>)">
                                Tanggapi
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </button>
                            <a href="aspirasi.php?delete=<?= $a['id'] ?>" onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger btn-icon">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php if (empty($aspirasi_data)): ?>
                    <div style="text-align:center;padding:48px;color:var(--gray-400)">Belum ada aspirasi masuk.</div>
                    <?php endif; ?>
                    <div style="padding:16px 22px">
                        <button class="btn btn-outline" style="width:100%;justify-content:center">Tampilkan Lebih Banyak</button>
                    </div>
                </div>
            </div>
        </div><!-- /right -->
    </div><!-- /2-col -->

    <!-- CTA Info Banner -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;border-radius:var(--radius-md);overflow:hidden;margin-top:24px;background:white;border:1px solid var(--gray-100);box-shadow:var(--shadow-sm)">
        <div style="background:var(--gray-100);min-height:220px;overflow:hidden">
            <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&q=80" alt="Perpustakaan" style="width:100%;height:100%;object-fit:cover;display:block">
        </div>
        <div style="padding:32px">
            <div style="width:44px;height:44px;background:var(--ap-teal-lt);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:14px">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--ap-teal)" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
            </div>
            <div style="font-size:1.2rem;font-weight:800;color:var(--gray-900);margin-bottom:10px;line-height:1.3">Kanal Aspirasi Digital:<br>Transparansi &amp; Kepercayaan</div>
            <div style="font-size:.84rem;color:var(--gray-600);line-height:1.7;margin-bottom:18px">Dengan sistem ini, setiap keluhan dan masukan terdokumentasi dengan baik. Orang tua dapat melihat progres dari aspirasi yang mereka sampaikan.</div>
            <div style="display:flex;gap:24px">
                <div><div style="font-size:1.4rem;font-weight:800;color:var(--ap-green)">85%</div><div style="font-size:.68rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px">Tingkat Respon</div></div>
                <div><div style="font-size:1.4rem;font-weight:800;color:var(--ap-green)">24 Jam</div><div style="font-size:.68rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.5px">Rata-rata Waktu</div></div>
            </div>
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
                <div class="modal-title">Tandai Sudah Ditanggapi</div>
                <button type="button" class="modal-close" onclick="closeReply()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <p style="font-size:.88rem;color:var(--gray-600);line-height:1.65">Apakah Anda sudah menindaklanjuti atau membalas aspirasi ini? Klik tandai agar statusnya berubah menjadi "Ditanggapi".</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeReply()">Batal</button>
                <button type="submit" class="btn btn-green">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Tandai Selesai
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function openReply(id) { document.getElementById('reply-id').value = id; document.getElementById('reply-modal').classList.add('open'); }
function closeReply() { document.getElementById('reply-modal').classList.remove('open'); }
</script>
</body>
</html>
