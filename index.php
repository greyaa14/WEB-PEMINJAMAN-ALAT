<?php
// index.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SiPinjam — SMKS Ketintang Surabaya</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />

  <!-- favicon pakai logo-smk -->
  <link rel="icon" type="image/png" href="assets/img/logo-smk.png" />
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar" id="mainNav">
    <div class="container">
      <div class="navbar-inner">
        <a href="#" class="brand">
          <div class="brand-icon">
            <img src="assets/img/logo-smk.png" alt="SMK Ketintang" />
          </div>
          SiPinjam
        </a>
        <ul class="nav-links">
          <li><a href="#beranda">Home</a></li>
          <li><a href="#fitur">Fitur Unggulan</a></li>
          <li><a href="#cara-pinjam">Cara Pinjam</a></li>
          <li><a href="user/daftar_alat.php">Daftar Alat</a></li>
          <li><a href="admin/login.php" class="btn-nav-login"><i class="bi bi-shield-lock-fill"></i> Login Admin</a></li>
        </ul>
        <button class="hamburger" id="hamburger" aria-label="Menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobileMenu">
    <button class="mobile-close" id="mobileClose">&times;</button>
    <a href="#beranda"     onclick="closeMobile()">Home</a>
    <a href="#fitur"       onclick="closeMobile()">Fitur Unggulan</a>
    <a href="#cara-pinjam" onclick="closeMobile()">Cara Pinjam</a>
    <a href="admin/login.php">Login Admin</a>
  </div>

  <!-- HERO SECTION -->
  <section class="hero" id="beranda">
    <div class="hero-bg-shapes"></div>
    <div class="dots-grid"></div>

    <div class="container">
      <div class="row align-items-center gy-4">

        <!-- Left -->
        <div class="col-lg-6 hero-content">
          <div class="hero-badge">
            <i class="bi bi-building"></i>
            SMKS Ketintang Surabaya
          </div>
          <h1>
            Sistem Peminjaman<br/>
            <span class="highlight">Alat Sekolah</span><br/>
            Digital &amp; Cepat
          </h1>
          <p class="lead">
            Pinjam proyektor, kamera, speaker, dan peralatan lainnya dengan mudah.
            Tanpa antri panjang, tanpa ribet — cukup isi form, konfirmasi, dan selesai.
          </p>
          <div class="hero-btns">
            <a href="user/daftar_alat.php" class="btn-primary-hero">
              <i class="bi bi-box-seam"></i>
              Daftar Alat
            </a>
            <a href="#cara-pinjam" class="btn-outline-hero">
              <i class="bi bi-play-circle"></i>
              Cara Pinjam
            </a>
          </div>
        </div>

        <!-- Right: Visual Card -->
        <div class="col-lg-6 hero-visual">
          <div style="position:relative; max-width:380px; margin: 0 auto;">
            <div class="hero-card-main">
              <div class="hero-card-header">
                <div class="card-avatar"><i class="bi bi-camera-video-fill"></i></div>
                <div>
                  <div class="card-title">Stok Alat Tersedia</div>
                  <div class="card-sub">Update real-time</div>
                </div>
              </div>
              <div class="alat-list-preview">
                <div class="alat-row">
                  <div class="alat-name"><i class="bi bi-projector-fill"></i> Proyektor</div>
                  <span class="badge-stok">5 unit</span>
                </div>
                <div class="alat-row">
                  <div class="alat-name"><i class="bi bi-camera-fill"></i> Kamera DSLR</div>
                  <span class="badge-stok">3 unit</span>
                </div>
                <div class="alat-row">
                  <div class="alat-name"><i class="bi bi-speaker-fill"></i> Speaker</div>
                  <span class="badge-stok low">2 unit</span>
                </div>
                <div class="alat-row">
                  <div class="alat-name"><i class="bi bi-easel2-fill"></i> Tripod</div>
                  <span class="badge-stok">4 unit</span>
                </div>
              </div>
              <div class="hero-card-footer">
                <span class="footer-info"><i class="bi bi-clock"></i> Diperbarui baru saja</span>
                <button class="btn-pinjam-sm">Ajukan Pinjam</button>
              </div>
            </div>

            <!-- Floating badges -->
            <div class="float-badge float-badge-1">
              <div class="dot"></div>
              Stok tersedia
            </div>
            <div class="float-badge float-badge-2">
              <div class="dot yellow"></div>
              Konfirmasi cepat
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- FITUR SECTION -->
  <section class="section section-alt" id="fitur">
    <div class="container">
      <div class="text-center reveal">
        <div class="section-tag"><i class="bi bi-stars"></i> Fitur Unggulan</div>
        <h2 class="section-title">Kenapa Pakai SiPinjam?</h2>
        <p class="section-desc mx-auto">
          Semua kebutuhan peminjaman alat sekolah tersedia dalam satu platform yang mudah dan transparan.
        </p>
      </div>

      <div class="fitur-grid">
        <div class="fitur-card reveal">
          <div class="fitur-icon icon-blue"><i class="bi bi-search"></i></div>
          <div class="fitur-title">Cek Stok Real-time</div>
          <div class="fitur-desc">Lihat ketersediaan alat secara langsung tanpa perlu ke ruang server. Stok terupdate otomatis.</div>
        </div>
        <div class="fitur-card reveal">
          <div class="fitur-icon icon-amber"><i class="bi bi-file-earmark-text-fill"></i></div>
          <div class="fitur-title">Form Peminjaman Mudah</div>
          <div class="fitur-desc">Isi nama, kelas, alat yang dipinjam, dan tanggal. Proses pengajuan selesai dalam hitungan menit.</div>
        </div>
        <div class="fitur-card reveal">
          <div class="fitur-icon icon-green"><i class="bi bi-patch-check-fill"></i></div>
          <div class="fitur-title">Konfirmasi Admin</div>
          <div class="fitur-desc">Setiap peminjaman dikonfirmasi oleh admin untuk memastikan ketersediaan dan kelancaran proses.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- CARA PINJAM -->
  <section class="section section-alt" id="cara-pinjam">
    <div class="container">
      <div class="text-center reveal">
        <div class="section-tag"><i class="bi bi-list-ol"></i> Panduan</div>
        <h2 class="section-title">Cara Peminjaman</h2>
        <p class="section-desc mx-auto">Empat langkah mudah untuk meminjam peralatan sekolah secara digital.</p>
      </div>

      <div class="steps-wrapper reveal">
        <div class="step-item">
          <div class="step-num">1</div>
          <div class="step-title">Cek Daftar Alat</div>
          <div class="step-desc">Buka halaman Daftar Alat dan pastikan stok tersedia untuk alat yang ingin dipinjam.</div>
        </div>
        <div class="step-item">
          <div class="step-num">2</div>
          <div class="step-title">Isi Form Pinjam</div>
          <div class="step-desc">Klik tombol "Ajukan Peminjaman", lalu isi nama, kelas, jumlah, dan tanggal pinjam.</div>
        </div>
        <div class="step-item">
          <div class="step-num">3</div>
          <div class="step-title">Tunggu Konfirmasi</div>
          <div class="step-desc">Admin akan memverifikasi pengajuan dan mengkonfirmasi peminjaman sesegera mungkin.</div>
        </div>
        <div class="step-item">
          <div class="step-num">4</div>
          <div class="step-title">Ambil &amp; Kembalikan</div>
          <div class="step-desc">Ambil alat di ruang server sesuai jadwal dan kembalikan tepat waktu setelah digunakan.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-content reveal">
        <h2>Siap Meminjam Peralatan?</h2>
        <p>Lihat daftar alat yang tersedia dan ajukan peminjaman sekarang juga.</p>
        <div class="cta-buttons">
          <a href="user/daftar_alat.php" class="btn-primary-hero">
            <i class="bi bi-pencil-square"></i>
            Mulai Pinjam
          </a>
          <a href="admin/login.php" class="btn-outline-hero">
            <i class="bi bi-shield-lock-fill"></i>
            Login Admin
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <div class="footer-top">
        <div>
          <div class="footer-brand-name">
            <div class="brand-icon">
              <img src="assets/img/logo-smk.png" alt="SMK Ketintang" />
            </div>
            SiPinjam
          </div>
          <p class="footer-desc">
            Sistem informasi peminjaman alat sekolah berbasis web untuk SMKS Ketintang Surabaya.
            Memudahkan proses pinjam-meminjam peralatan pembelajaran secara digital.
          </p>
        </div>
        <div>
          <div class="footer-col-title">Navigasi</div>
          <ul class="footer-links">
            <li><a href="#beranda">Home</a></li>
            <li><a href="#fitur">Fitur Unggulan</a></li>
            <li><a href="#cara-pinjam">Cara Pinjam</a></li>
            <li><a href="admin/login.php">Login Admin</a></li>
          </ul>
        </div>
        <div>
          <div class="footer-col-title">Informasi</div>
          <ul class="footer-links">
            <li><a href="#">📍 Jl. Ketintang, Surabaya</a></li>
            <li><a href="#">🏫 SMKS Ketintang</a></li>
            <li><a href="#">⏰ Senin – Sabtu, 07.00–15.00</a></li>
            <li><a href="#">📞 Ruang Server Lt. 1</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© 2026 SiPinjam — SMKS Ketintang Surabaya.</span>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 50);
    });

    const hamburger   = document.getElementById('hamburger');
    const mobileMenu  = document.getElementById('mobileMenu');
    const mobileClose = document.getElementById('mobileClose');

    hamburger.addEventListener('click', () => mobileMenu.classList.add('open'));
    mobileClose.addEventListener('click', () => mobileMenu.classList.remove('open'));

    function closeMobile() { mobileMenu.classList.remove('open'); }

    const revealEls = document.querySelectorAll('.reveal');
    const observer  = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          setTimeout(() => entry.target.classList.add('visible'), i * 80);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    revealEls.forEach(el => observer.observe(el));
  </script>
</body>
</html>