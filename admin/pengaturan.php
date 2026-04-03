<?php
session_start();
require_once 'auth_check.php';
require_once 'koneksi.php';
$active_menu = 'pengaturan';
$page_name   = 'Pengaturan';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'update_umum') {
        $npsn = $_POST['npsn'];
        $akreditasi = $_POST['akreditasi'];
        $tahun = $_POST['tahun_berdiri'];
        $kepsek = $_POST['kepala_sekolah'];
        $telp = $_POST['telp'];
        
        $q = $conn->query("SELECT id FROM pengaturan LIMIT 1");
        if($q->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE pengaturan SET npsn=?, akreditasi=?, tahun_berdiri=?, kepala_sekolah=?, telp=? WHERE id=1");
            $stmt->bind_param("sssss", $npsn, $akreditasi, $tahun, $kepsek, $telp);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("INSERT INTO pengaturan (id, npsn, akreditasi, tahun_berdiri, kepala_sekolah, telp) VALUES (1, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $npsn, $akreditasi, $tahun, $kepsek, $telp);
            $stmt->execute();
        }
        $saved = true;
    }
}

// Fetch settings
$q_info = $conn->query("SELECT * FROM pengaturan LIMIT 1");
$info = $q_info->fetch_assoc();

if(!$info) {
    $info = [
        'npsn' => '', 'akreditasi' => '', 'tahun_berdiri' => '', 
        'kepala_sekolah' => '', 'telp' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Admin SMP PGRI Ciomas</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        .setting-tabs {
            display: flex; gap: 4px;
            background: var(--gray-100); border-radius: 10px;
            padding: 4px; width: fit-content; margin-bottom: 24px;
        }
        .setting-tab {
            padding: 8px 20px; border-radius: 8px;
            font-size: .84rem; font-weight: 600; color: var(--gray-600);
            cursor: pointer; border: none; background: none;
            transition: all var(--transition); font-family: var(--font);
        }
        .setting-tab.active { background: white; color: var(--gray-900); box-shadow: var(--shadow-sm); }
        .setting-panel { display: none; }
        .setting-panel.active { display: block; }
        .logo-preview {
            width: 80px; height: 80px; border-radius: 16px;
            object-fit: cover; border: 2px solid var(--gray-200);
            background: var(--green-light);
        }
        .color-swatch {
            width: 36px; height: 36px; border-radius: 8px; border: 2px solid var(--gray-200); cursor: pointer;
        }
    </style>
</head>
<body>
<div class="admin-layout">
<?php include 'components/sidebar.php'; ?>
<div class="admin-main">
<?php include 'components/topbar.php'; ?>
<div class="page-content">

    <div class="page-header">
        <div class="page-header-left">
            <div class="page-heading">Pengaturan</div>
            <div class="page-subheading">Konfigurasi website dan data umum sekolah</div>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('form-umum').submit()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Simpan Semua Perubahan
        </button>
    </div>
    
    <?php if(isset($saved)): ?>
    <div style="padding:12px;background:#e2f5ec;color:#0a7361;border-radius:8px;margin-bottom:20px;border:1px solid #a7dfc9">
        Pengaturan berhasil disimpan!
    </div>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="setting-tabs">
        <button class="setting-tab active" onclick="switchTab('umum', this)">Umum</button>
        <button class="setting-tab" onclick="switchTab('tampilan', this)">Tampilan</button>
        <button class="setting-tab" onclick="switchTab('kontak', this)">Kontak & Sosmed</button>
        <button class="setting-tab" onclick="switchTab('akun', this)">Akun Admin</button>
    </div>

    <!-- ============ TAB UMUM ============ -->
    <div class="setting-panel active" id="panel-umum">
        <form method="POST" id="form-umum">
        <input type="hidden" name="action" value="update_umum">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start">

            <div class="card">
                <div class="card-header"><div class="card-title">Identitas Sekolah</div></div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group form-full">
                            <label class="form-label">Nama Sekolah <span>*</span></label>
                            <input type="text" class="form-control" value="SMP PGRI Ciomas">
                        </div>
                        <div class="form-group">
                            <label class="form-label">NPSN</label>
                            <input type="text" class="form-control" name="npsn" value="<?= htmlspecialchars($info['npsn']) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">NSS</label>
                            <input type="text" class="form-control" value="201021803035">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Akreditasi</label>
                            <div class="select-wrap">
                                <select class="form-control" name="akreditasi">
                                    <option <?= $info['akreditasi'] == 'A (Sangat Baik)' ? 'selected' : '' ?>>A (Sangat Baik)</option>
                                    <option <?= $info['akreditasi'] == 'B (Baik)' ? 'selected' : '' ?>>B (Baik)</option>
                                    <option <?= $info['akreditasi'] == 'C (Cukup)' ? 'selected' : '' ?>>C (Cukup)</option>
                                </select>
                                <svg class="select-arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tahun Berdiri</label>
                            <input type="text" class="form-control" name="tahun_berdiri" value="<?= htmlspecialchars($info['tahun_berdiri']) ?>">
                        </div>
                        <div class="form-group form-full">
                            <label class="form-label">Kepala Sekolah</label>
                            <input type="text" class="form-control" name="kepala_sekolah" value="<?= htmlspecialchars($info['kepala_sekolah']) ?>">
                        </div>
                        <div class="form-group form-full">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="telp" value="<?= htmlspecialchars($info['telp']) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:20px">
                <div class="card">
                    <div class="card-header"><div class="card-title">SEO Website</div></div>
                    <div class="card-body">
                        <div class="form-group" style="margin-bottom:14px">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" value="SMP PGRI Ciomas - Sekolah Terbaik di Ciomas">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Meta Deskripsi</label>
                            <textarea class="form-control" rows="3">SMP PGRI Ciomas - Membangun generasi cerdas, berkarakter, dan siap menghadapi tantangan masa depan dengan landasan iman dan takwa.</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </form>
    </div>

    <!-- ============ TAB TAMPILAN (Static for now) ============ -->
    <div class="setting-panel" id="panel-tampilan">
        <div class="card"><div class="card-body">Fitur ini belum aktif.</div></div>
    </div>
    <div class="setting-panel" id="panel-kontak">
        <div class="card"><div class="card-body">Fitur ini belum aktif.</div></div>
    </div>
    <div class="setting-panel" id="panel-akun">
        <div class="card"><div class="card-body">Gunakan phpMyAdmin untuk mengubah password admin.</div></div>
    </div>

</div>
</div>
</div>

<script>
function switchTab(name, btn) {
    document.querySelectorAll('.setting-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.setting-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>
</body>
</html>
