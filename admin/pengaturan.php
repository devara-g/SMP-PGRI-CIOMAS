<?php
session_start();
require_once 'auth_check.php';
require_once 'koneksi.php';
$active_menu = 'pengaturan';
$page_name   = 'Pengaturan';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_umum') {
    $npsn   = $_POST['npsn'];
    $akred  = $_POST['akreditasi'];
    $tahun  = $_POST['tahun_berdiri'];
    $kepsek = $_POST['kepala_sekolah'];
    $telp   = $_POST['telp'];
    $q = $conn->query("SELECT id FROM pengaturan LIMIT 1");
    if ($q->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE pengaturan SET npsn=?, akreditasi=?, tahun_berdiri=?, kepala_sekolah=?, telp=? WHERE id=1");
        $stmt->bind_param("sssss", $npsn, $akred, $tahun, $kepsek, $telp);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO pengaturan (id,npsn,akreditasi,tahun_berdiri,kepala_sekolah,telp) VALUES (1,?,?,?,?,?)");
        $stmt->bind_param("sssss", $npsn, $akred, $tahun, $kepsek, $telp);
        $stmt->execute();
    }
    $saved = true;
}

$q_info = $conn->query("SELECT * FROM pengaturan LIMIT 1");
$info   = $q_info->fetch_assoc() ?? ['npsn'=>'','akreditasi'=>'','tahun_berdiri'=>'','kepala_sekolah'=>'','telp'=>''];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Admin SMP PGRI Ciomas</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
<?php include 'components/sidebar.php'; ?>
<div class="admin-main">
<?php include 'components/topbar.php'; ?>
<div class="page-content">

    <div class="page-header">
        <div>
            <div class="page-heading">Konfigurasi Sistem</div>
            <div class="page-subheading">Kelola identitas institusi dan kredensial akses administratif Anda melalui panel kontrol terpusat.</div>
        </div>
    </div>

    <?php if (isset($saved)): ?>
    <div class="alert alert-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Pengaturan berhasil disimpan!
    </div>
    <?php endif; ?>

    <form method="POST" id="form-umum">
    <input type="hidden" name="action" value="update_umum">

    <div style="display:grid;grid-template-columns:260px 1fr;gap:20px;align-items:start">

        <!-- Left sidebar cards -->
        <div style="display:flex;flex-direction:column;gap:16px">
            <!-- Security card -->
            <div style="background:var(--ap-dark);border-radius:var(--radius-md);padding:22px;color:white;position:relative;overflow:hidden">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(255,255,255,.04);border-radius:50%"></div>
                <div style="font-size:.95rem;font-weight:800;color:white;margin-bottom:10px">Keamanan Akun</div>
                <div style="font-size:.78rem;color:rgba(255,255,255,.6);line-height:1.65;margin-bottom:14px">Pastikan kata sandi Anda diperbarui secara berkala dan gunakan kombinasi karakter yang kuat untuk melindungi data sekolah.</div>
                <div style="display:flex;align-items:center;gap:6px;font-size:.72rem;font-weight:700;color:var(--ap-yellow)">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                    Terproteksi Enkripsi AES-256
                </div>
            </div>

            <!-- Status card -->
            <div class="card">
                <div class="card-header">
                    <div style="display:flex;align-items:center;gap:6px;font-size:.82rem;font-weight:700;color:var(--gray-700)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--ap-blue)" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Status Sekolah
                    </div>
                </div>
                <div class="card-body" style="padding:16px">
                    <div style="display:flex;align-items:center;gap:8px;padding:10px 12px;background:var(--gray-50);border-radius:8px;border:1px solid var(--gray-100)">
                        <span style="width:8px;height:8px;border-radius:50%;background:var(--ap-green);flex-shrink:0"></span>
                        <span style="font-size:.82rem;font-weight:600;color:var(--gray-800)">Pendaftaran Aktif 2024/2025</span>
                    </div>
                    <div style="font-size:.72rem;color:var(--gray-400);margin-top:8px">Terakhir diubah oleh Admin</div>
                </div>
            </div>
        </div>

        <!-- Right: Forms -->
        <div style="display:flex;flex-direction:column;gap:16px">

            <!-- Profil Admin -->
            <div class="card">
                <div class="card-header">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:30px;height:30px;border-radius:8px;background:var(--ap-green-lt);display:flex;align-items:center;justify-content:center">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--ap-green)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="card-title">Profil Admin</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Admin Utama SMP PGRI" placeholder="Nama lengkap admin">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Kepend.</label>
                            <input type="email" class="form-control" value="admin@smppgriciomas.sch.id" placeholder="Email">
                        </div>
                        <div class="form-group form-full">
                            <label class="form-label">Kata Sandi Baru</label>
                            <div style="position:relative">
                                <input type="password" class="form-control" id="pw-input" placeholder="••••••••••••" style="padding-right:44px">
                                <button type="button" onclick="togglePw()" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--gray-400);cursor:pointer;padding:0">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <div style="font-size:.72rem;color:var(--gray-400);margin-top:4px">Gunakan minimal 12 karakter dengan kombinasi angka dan simbol.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Sekolah -->
            <div class="card">
                <div class="card-header">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:30px;height:30px;border-radius:8px;background:var(--ap-green-lt);display:flex;align-items:center;justify-content:center">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--ap-green)" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        </div>
                        <div class="card-title">Informasi Sekolah</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group form-full">
                            <label class="form-label">Nama Instansi</label>
                            <input type="text" class="form-control" value="SMP PGRI Ciomas" placeholder="Nama sekolah" style="background:var(--gray-50)">
                        </div>
                        <div class="form-group">
                            <label class="form-label">NPSN</label>
                            <input type="text" class="form-control" name="npsn" value="<?= htmlspecialchars($info['npsn']) ?>" placeholder="NPSN" style="background:var(--gray-50)">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Akreditasi</label>
                            <div class="select-wrap">
                                <select class="form-control" name="akreditasi" style="background:var(--gray-50)">
                                    <option <?= $info['akreditasi']=='A (Sangat Baik)'?'selected':'' ?>>A (Sangat Baik)</option>
                                    <option <?= $info['akreditasi']=='B (Baik)'?'selected':'' ?>>B (Baik)</option>
                                    <option <?= $info['akreditasi']=='C (Cukup)'?'selected':'' ?>>C (Cukup)</option>
                                </select>
                                <svg class="select-arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tahun Berdiri</label>
                            <input type="text" class="form-control" name="tahun_berdiri" value="<?= htmlspecialchars($info['tahun_berdiri']) ?>" placeholder="1998" style="background:var(--gray-50)">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kepala Sekolah</label>
                            <input type="text" class="form-control" name="kepala_sekolah" value="<?= htmlspecialchars($info['kepala_sekolah']) ?>" placeholder="Nama kepala sekolah" style="background:var(--gray-50)">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telepon / Fax</label>
                            <input type="text" class="form-control" name="telp" value="<?= htmlspecialchars($info['telp']) ?>" placeholder="(0251) XXXXXX" style="background:var(--gray-50)">
                        </div>
                        <div class="form-group form-full">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" rows="2" placeholder="Alamat sekolah" style="background:var(--gray-50)">Jl. Raya Ciomas No. 12, Ciomas Rahayu, Kec. Ciomas, Kabupaten Bogor, Jawa Barat 16610</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save actions -->
            <div style="display:flex;justify-content:flex-end;gap:10px;padding-top:4px">
                <button type="button" class="btn btn-outline" onclick="document.location.reload()">Batalkan Perubahan</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Pengaturan
                </button>
            </div>
        </div>
    </div>
    </form>

    <!-- Help footer -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:28px;padding:18px 24px;background:var(--gray-50);border-radius:var(--radius-md);border:1px solid var(--gray-100)">
        <div>
            <div style="font-size:.88rem;font-weight:700;color:var(--gray-900);margin-bottom:4px">Bantuan Teknis</div>
            <div style="font-size:.78rem;color:var(--gray-500)">Mengalami kendala pada sistem? Hubungi tim IT support melalui jalur resmi.</div>
        </div>
        <div style="text-align:right">
            <div style="font-size:.78rem;color:var(--ap-green);font-weight:600">✉ support@pulse.edu</div>
            <div style="font-size:.78rem;color:var(--ap-green);font-weight:600;margin-top:2px">☎ 0800-1-PULSE</div>
            <div style="font-size:.68rem;color:var(--gray-400);margin-top:6px">© 2024 THE ACADEMIC PULSE — Versi Build 2.4.1-Stable</div>
        </div>
    </div>

</div>
</div>
</div>
<script>
function togglePw() {
    const i = document.getElementById('pw-input');
    i.type = i.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
