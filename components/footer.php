<?php $current_page = $current_page ?? ''; ?>
<footer class="footer" id="hubungi">
    <div class="footer-container">
        <div class="footer-brand">
            <div class="footer-logo">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <rect width="32" height="32" rx="6" fill="#1a6b4a"/>
                    <text x="50%" y="58%" dominant-baseline="middle" text-anchor="middle" fill="white" font-size="14" font-weight="bold" font-family="Georgia">S</text>
                </svg>
                <span>SMP PGRI Ciomas</span>
            </div>
            <p>Membangun generasi cerdas, berkarakter, dan siap menghadapi tantangan masa depan dengan landasan iman dan takwa.</p>
            <div class="footer-social">
                <a href="#" class="social-icon" title="Instagram">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                </a>
                <a href="#" class="social-icon" title="Facebook">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="#" class="social-icon" title="YouTube">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-1.96C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.4 19.54C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor" stroke="none"/></svg>
                </a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Informasi Kontak</h4>
            <ul>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Jl. Raya Ciomas No.1, Bogor
                </li>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 6.37 2 2 0 0 1 6.68 4h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L10.91 11a16 16 0 0 0 6.09 6.09l1.05-1.06a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    (0251) 123456
                </li>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    info@smppgriciomas.sch.id
                </li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Tautan Cepat</h4>
            <div class="footer-links-grid">
                <div>
                    <ul>
                        <li><a href="profil.php#visi">Visi & Misi</a></li>
                        <li><a href="profil.php#akademik">Akademik</a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><a href="#">Ekstrakurikuler</a></li>
                        <li><a href="berita.php">Berita</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2024 SMP PGRI Ciomas. All Rights Reserved.</p>
    </div>
</footer>

<script>
// ---- Hamburger menu ----
const hamburger = document.getElementById('hamburger');
const navLinks  = document.getElementById('navLinks');

if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
        const isOpen = navLinks.classList.toggle('open');
        hamburger.classList.toggle('active', isOpen);
        hamburger.setAttribute('aria-expanded', isOpen);
    });

    // Close menu when a link is clicked
    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('open');
            hamburger.classList.remove('active');
            hamburger.setAttribute('aria-expanded', 'false');
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
            navLinks.classList.remove('open');
            hamburger.classList.remove('active');
            hamburger.setAttribute('aria-expanded', 'false');
        }
    });
}

// ---- Navbar scroll shadow ----
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (navbar) {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    }
}, { passive: true });
</script>
