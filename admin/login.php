<?php
session_start();
require_once 'koneksi.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Handle simple login logic if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nama'] = $user['nama'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error_msg = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMP PGRI Ciomas Admin Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-primary: #0a7361;
            /* Updated to match screenshot teal/green */
            --green-dark: #075043;
            --green-light: #e5f1ef;
            --yellow-btn: #f5c400;
            --yellow-btn-hover: #e0b300;
            --bg-right: #f2f5f4;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --border-light: #e2e8f0;
            --font-main: 'Poppins', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-main);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #ffffff;
        }

        /* HEADER */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 40px;
            background: #ffffff;
            height: 72px;
            position: relative;
            z-index: 10;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--green-primary);
            text-decoration: none;
        }

        .header-nav {
            display: flex;
            gap: 32px;
        }

        .header-nav a {
            text-decoration: none;
            color: var(--text-gray);
            font-weight: 600;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .header-nav a:hover {
            color: var(--green-primary);
        }

        .header-btn {
            background: var(--green-primary);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .header-btn:hover {
            background: var(--green-dark);
        }

        /* MAIN LAYOUT */
        .main-content {
            display: flex;
            flex: 1;
        }

        /* LEFT SIDE */
        .split-left {
            flex: 1;
            position: relative;
            background-color: var(--green-primary);
            /* A local image or external URL for classroom */
            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBhSavxoGNf6N1QTFR7_jUX94GR-w1ihetT3jJvXARtVl3kGbMLE4gVqGbV3gPgh9H3OoiiLi30PQzePXu7qU0M19-yKBFquDVDUFaQ6KHJgydtY5KzGGDZa1P_GZaYuMrqTBAJ_uFHvNmXmnWyfPDm4YJ2DtwhydAyQCurAjN4PWaGwix2zQdsXxYXF9RIBGfGSzXK6KW3b2n1X3s7DkG4AMtEDwlmgwABFiX7b1qXIwU5w2I2RDx3NPo0Y-1fRSkoDf3tf6UoHeqI');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
        }

        .left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(10, 115, 97, 0.95), rgba(10, 115, 97, 0.85));
            z-index: 1;
        }

        .left-content {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 600px;
        }

        .quote-icon {
            width: 72px;
            height: 72px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
        }

        .quote-icon svg {
            width: 36px;
            height: 36px;
            color: var(--yellow-btn);
        }

        .quote-text {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -1px;
        }

        .quote-author {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 400;
            margin-bottom: 40px;
        }

        .quote-author::before {
            content: '';
            display: block;
            width: 4px;
            height: 20px;
            background: var(--yellow-btn);
            margin-right: 16px;
        }

        .archive-tag {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 40px;
        }

        .archive-tag::before {
            content: '';
            display: inline-block;
            width: 40px;
            height: 3px;
            background: var(--yellow-btn);
            margin-right: 16px;
        }

        /* RIGHT SIDE */
        .split-right {
            flex: 1;
            background-color: var(--bg-right);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-card {
            background: white;
            padding: 48px;
            border-radius: 16px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
            position: relative;
        }

        .portal-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--green-primary);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .portal-label::before {
            content: '';
            display: block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green-primary);
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: #eef2f1;
            border-radius: 6px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px;
            padding-right: 40px;
            background: transparent;
            border: 2px solid transparent;
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-dark);
            outline: none;
            transition: all 0.2s;
        }

        .input-wrapper input:focus {
            border-color: var(--green-primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(10, 115, 97, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            color: #94a3b8;
            pointer-events: none;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
            margin-bottom: 32px;
            font-size: 0.85rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-weight: 500;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            accent-color: var(--green-primary);
            cursor: pointer;
            border: 1px solid var(--border-light);
            border-radius: 4px;
        }

        .forgot-pass {
            color: var(--green-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .btn-submit {
            width: 100%;
            background: var(--yellow-btn);
            color: var(--text-dark);
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform 0.2s, background 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(245, 196, 0, 0.3);
        }

        .btn-submit:hover {
            background: var(--yellow-btn-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(245, 196, 0, 0.4);
        }

        .help-text {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-light);
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        .help-text a {
            color: var(--green-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .alert {
            padding: 12px 16px;
            background: #fef2f2;
            color: #b91c1c;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid rgba(185, 28, 28, 0.2);
        }

        .security-badge {
            margin-top: 32px;
            background: var(--green-light);
            color: var(--green-primary);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .security-badge::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green-primary);
        }

        /* FOOTER */
        .footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 40px;
            background: #ffffff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.75rem;
            color: var(--text-gray);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-links {
            display: flex;
            gap: 24px;
        }

        .footer-links a {
            color: var(--text-gray);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--green-primary);
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .split-left {
                display: none;
            }

            .header {
                padding: 16px 20px;
            }

            .footer {
                flex-direction: column;
                gap: 16px;
                text-align: center;
                padding: 20px;
            }

            .login-card {
                padding: 32px;
            }
        }

        @media (max-width: 600px) {

            .header-nav,
            .header-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="header">
        <a href="../index.php" class="header-logo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
            </svg>
            SMP PGRI Ciomas
        </a>
        <nav class="header-nav">
            <a href="../index.php">Portal</a>
            <a href="#">Support</a>
            <a href="#">Security</a>
        </nav>
        <a href="#" class="header-btn">Staff Access</a>
    </header>

    <!-- Main Layout -->
    <main class="main-content">
        <!-- Left Side -->
        <div class="split-left">
            <div class="left-overlay"></div>
            <div class="left-content">
                <div class="quote-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
                        <path d="M8 11h8" />
                        <path d="M8 7h6" />
                    </svg>
                </div>
                <h1 class="quote-text">Pendidikan adalah kunci untuk membuka pintu emas kebebasan.</h1>
                <div class="quote-author">— George Washington Carver</div>

                <div class="archive-tag">THE LIVING ARCHIVE</div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="split-right">
            <div class="login-card">
                <div class="portal-label">ADMIN PORTAL</div>
                <h2 class="login-title">Masuk ke Dashboard</h2>
                <p class="login-subtitle">Silakan masukkan kredensial Anda untuk mengakses portal administrasi.</p>

                <?php if (isset($error_msg)): ?>
                    <div class="alert">
                        <?= htmlspecialchars($error_msg) ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">Username atau Email</label>
                        <div class="input-wrapper">
                            <input type="text" name="username" placeholder="contoh: admin_ciomas" required>
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kata Sandi</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" placeholder="•••••••••" required>
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Ingat Saya</span>
                        </label>
                        <a href="#" class="forgot-pass">Lupa Kata Sandi?</a>
                    </div>

                    <button type="submit" class="btn-submit">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        Masuk ke Dashboard
                    </button>
                </form>

                <div class="help-text">
                    Butuh bantuan akses? <a href="#">Hubungi Tim IT Support</a>
                </div>
            </div>

            <div class="security-badge">
                SISTEM AKTIF & AMAN
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div>© 2024 SMP PGRI CIOMAS - THE LIVING ARCHIVE. SECURE ADMIN PORTAL.</div>
        <div class="footer-links">
            <a href="#">PRIVACY POLICY</a>
            <a href="#">TERMS OF SERVICE</a>
            <a href="#">HELP DESK</a>
        </div>
    </footer>

</body>

</html>