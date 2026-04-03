<?php
require_once 'admin/koneksi.php';
$current_page = 'aspirasi';

// Handle form submission
$success_msg = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $peran  = isset($_POST['peran']) ? trim($_POST['peran']) : 'Masyarakat';
    $pesan  = isset($_POST['pesan']) ? trim($_POST['pesan']) : '';
    $anonim = isset($_POST['anonim']) ? true : false;

    if ($anonim) {
        $nama = 'Hamba Allah (Anonim)';
    } elseif (empty($nama)) {
        $nama = 'Tanpa Nama';
    }

    if (empty($pesan)) {
        $error_msg = 'Pesan aspirasi tidak boleh kosong.';
    } else {
        $stmt = $conn->prepare("INSERT INTO aspirasi (nama, peran, pesan) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $peran, $pesan);
        if ($stmt->execute()) {
            $success_msg = 'Aspirasi Anda telah berhasil dikirim! Terima kasih atas kontribusi Anda.';
            $_POST = []; // Clear form data
        } else {
            $error_msg = 'Gagal mengirim aspirasi, silahkan coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspirasi - SMP PGRI Ciomas</title>
    <meta name="description" content="Portal Aspirasi Digital SMP PGRI Ciomas. Sampaikan saran, keluhan, dan harapan Anda untuk meningkatkan kualitas pendidikan.">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/aspirasi.css">
</head>

<body>

    <?php include 'components/navbar.php'; ?>

    <!-- ==========================================
     HERO - ASPIRASI
     ========================================== -->
    <section class="aspirasi-hero">
        <div class="aspirasi-hero-inner container">
            <div class="aspirasi-hero-left">
                <div class="badge-strip aspirasi-badge">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    PORTAL ASPIRASI DIGITAL
                </div>
                <h1 class="aspirasi-hero-title">
                    Suara Anda,<br>
                    <em>Masa Depan</em> Kita
                </h1>
                <p class="aspirasi-hero-desc">
                    Setiap saran, keluhan, dan harapan Anda adalah kompas bagi kami untuk terus berinovasi dan memberikan kualitas pendidikan terbaik di SMP PGRI Ciomas.
                </p>
                <div class="aspirasi-avatars">
                    <div class="aspiras-avatar-stack">
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <img class="avatar-stack-item" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaxgOvtactjrARqi6h63bzeZEUDDt4-UJrLz600ywV4aUNxrWikzvQV9ywe2SJRlI77z723OWdg32sIgJKlOfh_JQMB-dZc00W5Q0PoUvig-rtP8M5y3w1NWvmO07hQHp5-0Nx1T9AggdAEYFYnHeUcYbaZcH_iAYOAEb9oLuexUyi0RUYdvUkLX8uMi8qW6K4xIht9WYKCppW5RTcuQto-_CLPYWV5MLpP5oG0RuuCV1NfL8PyDClQKfecaslD9WpvX-o3dlIGvQl" alt="Avatar">
                        <?php endfor; ?>
                    </div>
                    <span>Bergabung dengan <strong>500+</strong> pemberi aspirasi bulan ini</span>
                </div>
            </div>
            <div class="aspirasi-hero-right">
                <img class="aspirasi-hero-img" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbtvEycatQkDoKZ-8CeqZEtpCSleFgQIAsP2eQ5MSH-lUcQgitwnbE_EfTlTb15eiy7w_V3ih-mbhcuDjHxWCqSZutYowy4Y93XqVG3FSbfcxDRGsOlvJ6nryT5QfHDrhrzceXE-HVnDtFrMmnYUktOiN92NJgCBCPOk0u6DHZeG44Ua3UDqWayuk9X2DeVCtnVGoxNN5ko4WCzvopT7cLfb3cGG2XzPE2UJMuBBhM1HHuaRkhKujN2dGZJ5hU2NNwoX3ntakRv2KM" alt="Siswa Berdiskusi">
                <div class="aspirasi-quote-float">
                    <p>"Kritik yang membangun adalah kunci kemajuan kita bersama."</p>
                    <span>— Kepala Sekolah</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
     FORM SECTION
     ========================================== -->
    <section class="section aspirasi-form-section">
        <div class="container aspirasi-form-wrap">

            <!-- Left: Info cards -->
            <div class="aspirasi-info-col">
                <div class="aspiras-info-card active">
                    <div class="aspiras-info-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </div>
                    <div>
                        <h3>Privasi Terjamin</h3>
                        <p>Semua data yang Anda kirimkan akan dienkripsi dan hanya dapat diakses oleh tim manajemen sekolah yang berwenang.</p>
                    </div>
                </div>
                <div class="aspiras-info-card">
                    <div class="aspiras-info-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <div>
                        <h3>Respon Cepat</h3>
                        <p>Kami berkomitmen untuk meninjau setiap aspirasi dalam waktu maksimal 2x24 jam hari kerja.</p>
                    </div>
                </div>
            </div>

            <!-- Right: Form -->
            <div class="aspirasi-form-col">
                <?php if ($success_msg): ?>
                    <div class="aspirasi-alert aspirasi-alert-success">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        <?= htmlspecialchars($success_msg) ?>
                    </div>
                <?php endif; ?>
                <?php if ($error_msg): ?>
                    <div class="aspirasi-alert aspirasi-alert-error">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <?= htmlspecialchars($error_msg) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="aspirasi.php" class="aspirasi-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap (Opsional)</label>
                            <input type="text" id="nama" name="nama" placeholder="Contoh: Budi Santoso"
                                value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="peran">Peran Anda</label>
                            <div class="select-wrap">
                                <select id="peran" name="peran">
                                    <option value="" disabled <?= empty($_POST['peran'] ?? '') ? 'selected' : '' ?>>Pilih Peran</option>
                                    <option value="siswa" <?= ($_POST['peran'] ?? '') === 'siswa' ? 'selected' : '' ?>>Siswa</option>
                                    <option value="orang_tua" <?= ($_POST['peran'] ?? '') === 'orang_tua' ? 'selected' : '' ?>>Orang Tua / Wali</option>
                                    <option value="guru" <?= ($_POST['peran'] ?? '') === 'guru' ? 'selected' : '' ?>>Guru / Staff</option>
                                    <option value="alumni" <?= ($_POST['peran'] ?? '') === 'alumni' ? 'selected' : '' ?>>Alumni</option>
                                    <option value="masyarakat" <?= ($_POST['peran'] ?? '') === 'masyarakat' ? 'selected' : '' ?>>Masyarakat Umum</option>
                                </select>
                                <svg class="select-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan Aspirasi</label>
                        <textarea id="pesan" name="pesan" rows="6"
                            placeholder="Tuliskan harapan, saran, atau masukan Anda di sini..."><?= htmlspecialchars($_POST['pesan'] ?? '') ?></textarea>
                    </div>

                    <div class="form-checkbox">
                        <label class="checkbox-label">
                            <input type="checkbox" name="anonim" id="anonim" <?= isset($_POST['anonim']) ? 'checked' : '' ?>>
                            <span class="checkbox-custom"></span>
                            <span>Kirim secara anonim <em>(Identitas Anda tidak akan ditampilkan)</em></span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary aspirasi-submit" id="btn-kirim">
                        Kirim Aspirasi Sekarang
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                    </button>

                    <p class="form-note">
                        Dengan menekan tombol kirim, Anda menyetujui
                        <a href="#">Syarat & Ketentuan</a> layanan aspirasi kami.
                    </p>
                </form>
            </div>
        </div>
    </section>

    <!-- ==========================================
     PETA LOKASI
     ========================================== -->
    <section class="section" style="padding-top: 20px;">
        <div class="container">
            <h2 class="section-title" style="text-align: center; margin-bottom: 30px;">Temukan Kami di Sini</h2>
            <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.377584536875!2d106.75605647317352!3d-6.599909364513378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c51018a4b819%3A0x5e17ca5c6f515830!2sSMP%20PGRI%20CIOMAS!5e0!3m2!1sid!2sid!4v1775217859411!5m2!1sid!2sid" 
                    width="100%" 
                    height="450" 
                    style="border:0; display:block;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- ==========================================
     STATS
     ========================================== -->
    <div class="stats-bar">
        <div class="container">
            <div class="stat-item">
                <div class="stat-number">1.2k+</div>
                <div class="stat-label">Aspirasi Terproses</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">98%</div>
                <div class="stat-label">Tingkat Kepuasan</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">48 Jam</div>
                <div class="stat-label">Rata-rata Respon</div>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

</body>

</html>