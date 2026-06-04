<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

// Ambil data statistik
$total_barang   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM barang"))['total'];
$total_pinjam   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status='dipinjam'"))['total'];
$total_kembali  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status='dikembalikan'"))['total'];
$menunggu       = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status='menunggu'"))['total'];
$total_admin    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin — SiPinjam</title>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Dashboard CSS -->
  <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<!-- ============================================================
     SIDEBAR
============================================================ -->
<aside class="sidebar" id="sidebar">
  <a href="#" class="sidebar-brand" onclick="showSection('dashboard')">
    <div class="sidebar-brand-icon">
      <img src="../assets/img/logo-smk.png" alt="SMK Ketintang" />
    </div>
    <div class="sidebar-brand-name">SiPinjam</div>
  </a>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Menu Utama</div>

    <a class="nav-item active" id="nav-dashboard" onclick="showSection('dashboard')">
      <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
    <a class="nav-item" id="nav-barang" onclick="showSection('barang')">
      <i class="bi bi-boxes"></i> Manajemen Barang
    </a>
    <a class="nav-item" id="nav-stok" onclick="showSection('stok')">
      <i class="bi bi-bar-chart-fill"></i> Monitoring Stok
    </a>
    <a class="nav-item" id="nav-peminjaman" onclick="showSection('peminjaman')">
      <i class="bi bi-clipboard2-check-fill"></i> Manajemen Peminjaman
      <?php if($menunggu > 0): ?>
        <span class="badge-count"><?= $menunggu ?></span>
      <?php endif; ?>
    </a>
    <a class="nav-item" id="nav-admin" onclick="showSection('admin')">
      <i class="bi bi-shield-lock-fill"></i> Kelola Admin
    </a>

    <div class="nav-section-label">Sistem</div>
    <a class="nav-item" href="../index.php">
      <i class="bi bi-house-fill"></i> Ke Beranda
    </a>
    <a class="nav-item" href="logout.php">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="sidebar-avatar"><i class="bi bi-person-fill"></i></div>
      <div>
        <div class="sidebar-user-name"><?= htmlspecialchars($_SESSION['username']) ?></div>
        <div class="sidebar-user-role">Administrator</div>
      </div>
      <a href="logout.php" class="sidebar-logout" title="Logout">
        <i class="bi bi-power"></i>
      </a>
    </div>
  </div>
</aside>

<!-- Sidebar overlay mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ============================================================
     TOPBAR
============================================================ -->
<header class="topbar">
  <div class="topbar-left">
    <button class="hamburger-btn" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>
    <div>
      <div class="topbar-title" id="topbarTitle">Dashboard</div>
      <div class="topbar-subtitle">Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?> 👋</div>
    </div>
  </div>
  <div class="topbar-right">
    <div class="topbar-search">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Cari barang / peminjaman..." id="globalSearch" oninput="handleGlobalSearch(this.value)">
    </div>
    <a href="../index.php" class="topbar-btn" title="Ke Beranda"><i class="bi bi-house"></i></a>
    <a href="logout.php" class="topbar-btn" title="Logout"><i class="bi bi-box-arrow-right"></i></a>
  </div>
</header>

<!-- ============================================================
     MAIN CONTENT
============================================================ -->
<main class="main-content">

  <!-- Toast notification -->
  <div class="toast-wrap" id="toastWrap"></div>

  <!-- ==================== DASHBOARD HOME ==================== -->
  <section class="page-section active" id="sec-dashboard">

    <!-- Stat Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon si-blue"><i class="bi bi-boxes"></i></div>
        <div class="stat-info">
          <div class="stat-value"><?= $total_barang ?></div>
          <div class="stat-label">Total Jenis Barang</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-amber"><i class="bi bi-clock-fill"></i></div>
        <div class="stat-info">
          <div class="stat-value"><?= $total_pinjam ?></div>
          <div class="stat-label">Sedang Dipinjam</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-green"><i class="bi bi-check-circle-fill"></i></div>
        <div class="stat-info">
          <div class="stat-value"><?= $total_kembali ?></div>
          <div class="stat-label">Sudah Dikembalikan</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-red"><i class="bi bi-hourglass-split"></i></div>
        <div class="stat-info">
          <div class="stat-value"><?= $menunggu ?></div>
          <div class="stat-label">Menunggu Konfirmasi</div>
        </div>
      </div>
    </div>

    <!-- Recent Peminjaman -->
    <div class="dash-card">
      <div class="dash-card-header">
        <div>
          <div class="section-title">Peminjaman Terbaru</div>
          <div class="section-subtitle">5 peminjaman terakhir</div>
        </div>
        <button class="btn-primary-dash" onclick="showSection('peminjaman')">
          <i class="bi bi-arrow-right"></i> Lihat Semua
        </button>
      </div>
      <div class="table-wrap">
        <table class="dash-table">
          <thead>
            <tr>
              <th>Nama Siswa</th>
              <th>Barang</th>
              <th>Tgl Pinjam</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $q = mysqli_query($conn, "
              SELECT p.*, b.nama_barang
              FROM peminjaman p
              LEFT JOIN barang b ON p.id_barang = b.id
              ORDER BY p.id DESC LIMIT 5
            ");
            while($row = mysqli_fetch_assoc($q)):
              $badge = match($row['status']) {
                'menunggu'      => 'badge-yellow',
                'dipinjam'      => 'badge-blue',
                'dikembalikan'  => 'badge-green',
                default         => 'badge-gray'
              };
              $label = match($row['status']) {
                'menunggu'      => 'Menunggu',
                'dipinjam'      => 'Dipinjam',
                'dikembalikan'  => 'Dikembalikan',
                default         => $row['status']
              };
            ?>
            <tr>
              <td><strong><?= htmlspecialchars($row['nama_peminjam']) ?></strong></td>
              <td><?= htmlspecialchars($row['nama_barang'] ?? '-') ?></td>
              <td><?= date('d M Y', strtotime($row['tgl_pinjam'])) ?></td>
              <td><span class="badge-dash <?= $badge ?>"><?= $label ?></span></td>
              <td>
                <?php if($row['status'] == 'menunggu'): ?>
                  <a href="aksi_peminjaman.php?aksi=konfirmasi&id=<?= $row['id'] ?>" class="btn-sm-act btn-ok"><i class="bi bi-check-lg"></i> Konfirmasi</a>
                <?php elseif($row['status'] == 'dipinjam'): ?>
                  <a href="aksi_peminjaman.php?aksi=kembali&id=<?= $row['id'] ?>" class="btn-sm-act btn-return"><i class="bi bi-arrow-return-left"></i> Kembalikan</a>
                <?php else: ?>
                  <span class="badge-dash badge-green"><i class="bi bi-check-circle"></i> Selesai</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ==================== MANAJEMEN BARANG ==================== -->
  <section class="page-section" id="sec-barang">
    <div class="section-header">
      <div>
        <div class="section-title">Manajemen Barang</div>
        <div class="section-subtitle">Kelola data alat dan peralatan sekolah</div>
      </div>
      <button class="btn-primary-dash" onclick="openModal('modalTambahBarang')">
        <i class="bi bi-plus-lg"></i> Tambah Barang
      </button>
    </div>

    <div class="dash-card">
      <div class="dash-card-header">
        <div class="section-title" style="font-size:.9rem;">Daftar Barang</div>
        <div class="table-search">
          <i class="bi bi-search"></i>
          <input type="text" placeholder="Cari nama barang..." oninput="searchTable(this.value, 'tabelBarang')">
        </div>
      </div>
      <div class="table-wrap">
        <table class="dash-table" id="tabelBarang">
          <thead>
            <tr>
              <th>No</th>
              <th>Barang</th>
              <th>Deskripsi</th>
              <th>Stok</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qb = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
            $no = 1;
            while($b = mysqli_fetch_assoc($qb)):
              $stok = $b['stok'] ?? 0;
              $foto = !empty($b['foto']) ? '../assets/img/' . $b['foto'] : null;
              $status_badge = $stok > 3 ? 'badge-green' : ($stok > 0 ? 'badge-yellow' : 'badge-red');
              $status_label = $stok > 3 ? 'Tersedia' : ($stok > 0 ? 'Hampir Habis' : 'Habis');
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <div class="item-info">
                  <?php if($foto): ?>
                    <img src="<?= htmlspecialchars($foto) ?>" class="item-photo" style="object-fit:cover;" alt="foto">
                  <?php else: ?>
                    <div class="item-photo">📦</div>
                  <?php endif; ?>
                  <div>
                    <div class="item-name"><?= htmlspecialchars($b['nama_barang']) ?></div>
                  </div>
                </div>
              </td>
              <td style="max-width:200px;color:var(--gray-500)"><?= htmlspecialchars($b['deskripsi'] ?? '-') ?></td>
              <td><?= $stok ?></td>
              <td>
                <span class="badge-dash <?= $status_badge ?>">
                  <?= $status_label ?>
                </span>
              </td>
              <td style="display:flex;gap:6px;flex-wrap:wrap">
                <button class="btn-sm-act btn-edit" onclick="openEditBarang(<?= $b['id'] ?>, '<?= htmlspecialchars($b['nama_barang'], ENT_QUOTES) ?>', '<?= htmlspecialchars($b['deskripsi'] ?? '', ENT_QUOTES) ?>', <?= $stok ?>)">
                  <i class="bi bi-pencil"></i> Edit
                </button>
                <a href="hapus_barang.php?id=<?= $b['id'] ?>" class="btn-sm-act btn-del" onclick="return confirm('Yakin hapus barang ini?')">
                  <i class="bi bi-trash"></i> Hapus
                </a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ==================== MONITORING STOK ==================== -->
  <section class="page-section" id="sec-stok">
    <div class="section-header">
      <div>
        <div class="section-title">Monitoring Stok</div>
        <div class="section-subtitle">Pantau stok barang dan riwayat peminjaman</div>
      </div>
    </div>

    <div class="dash-card">
      <div class="dash-card-header">
        <div class="section-title" style="font-size:.9rem;">Status Stok Barang</div>
        <div class="table-search">
          <i class="bi bi-search"></i>
          <input type="text" placeholder="Cari barang..." oninput="searchTable(this.value, 'tabelStok')">
        </div>
      </div>
      <div class="table-wrap">
        <table class="dash-table" id="tabelStok">
          <thead>
            <tr>
              <th>Nama Alat</th>
              <th>Stok Awal</th>
              <th>Dipinjam</th>
              <th>Stok Tersisa</th>
              <th>Kondisi</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qs = mysqli_query($conn, "
              SELECT b.*,
                (SELECT COUNT(*) FROM peminjaman p WHERE p.id_barang=b.id AND p.status='dipinjam') as sedang_dipinjam
              FROM barang b ORDER BY b.nama_barang
            ");
            while($s = mysqli_fetch_assoc($qs)):
              $stok = $s['stok'] ?? 0;
              $dipinjam = $s['sedang_dipinjam'] ?? 0;
              $pct = $stok > 0 ? (($stok - $dipinjam) / $stok) * 100 : 0;
              $fillClass = $pct > 50 ? 'fill-green' : ($pct > 20 ? 'fill-yellow' : 'fill-red');
              $badge = $pct > 50 ? 'badge-green' : ($pct > 20 ? 'badge-yellow' : 'badge-red');
              $status = $pct > 50 ? 'Tersedia' : ($pct > 20 ? 'Hampir Habis' : 'Habis');
            ?>
            <tr>
              <td><strong><?= htmlspecialchars($s['nama_barang']) ?></strong></td>
              <td><?= $stok + $dipinjam ?></td>
              <td><?= $dipinjam ?></td>
              <td><?= $stok ?></td>
              <td>
                <div class="stok-bar-wrap">
                  <div class="stok-bar">
                    <div class="stok-bar-fill <?= $fillClass ?>" style="width:<?= $pct ?>%"></div>
                  </div>
                  <span class="stok-bar-text"><?= round($pct) ?>%</span>
                </div>
              </td>
              <td><span class="badge-dash <?= $badge ?>"><?= $status ?></span></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Riwayat Peminjaman -->
    <div class="dash-card" style="margin-top:24px;">
      <div class="dash-card-header">
        <div class="section-title" style="font-size:.9rem;">Riwayat Peminjaman</div>
      </div>
      <div class="table-wrap">
        <table class="dash-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Siswa</th>
              <th>Barang</th>
              <th>Jml</th>
              <th>Tgl Pinjam</th>
              <th>Tgl Kembali</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qr = mysqli_query($conn, "
              SELECT p.*, b.nama_barang FROM peminjaman p
              LEFT JOIN barang b ON p.id_barang = b.id
              ORDER BY p.id DESC
            ");
            $no = 1;
            while($r = mysqli_fetch_assoc($qr)):
              $badge = match($r['status']) {
                'menunggu'     => 'badge-yellow',
                'dipinjam'     => 'badge-blue',
                'dikembalikan' => 'badge-green',
                default        => 'badge-gray'
              };
              $label = match($r['status']) {
                'menunggu'     => 'Menunggu',
                'dipinjam'     => 'Dipinjam',
                'dikembalikan' => 'Dikembalikan',
                default        => $r['status']
              };
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($r['nama_peminjam']) ?></td>
              <td><?= htmlspecialchars($r['nama_barang'] ?? '-') ?></td>
              <td><?= $r['jumlah'] ?? 1 ?></td>
              <td><?= date('d M Y', strtotime($r['tgl_pinjam'])) ?></td>
              <td><?= $r['tgl_kembali'] ? date('d M Y', strtotime($r['tgl_kembali'])) : '-' ?></td>
              <td><span class="badge-dash <?= $badge ?>"><?= $label ?></span></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ==================== MANAJEMEN PEMINJAMAN ==================== -->
  <section class="page-section" id="sec-peminjaman">
    <div class="section-header">
      <div>
        <div class="section-title">Manajemen Peminjaman</div>
        <div class="section-subtitle">Konfirmasi dan kelola seluruh peminjaman</div>
      </div>
    </div>

    <!-- Filter tabs -->
    <div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
      <button class="btn-primary-dash filter-tab active" onclick="filterPeminjaman('semua', this)">Semua</button>
      <button class="btn-outline-dash filter-tab" onclick="filterPeminjaman('menunggu', this)">⏳ Menunggu</button>
      <button class="btn-outline-dash filter-tab" onclick="filterPeminjaman('dipinjam', this)">📦 Dipinjam</button>
      <button class="btn-outline-dash filter-tab" onclick="filterPeminjaman('dikembalikan', this)">✅ Dikembalikan</button>
    </div>

    <div class="dash-card">
      <div class="dash-card-header">
        <div class="section-title" style="font-size:.9rem;">Daftar Peminjaman</div>
        <div class="table-search">
          <i class="bi bi-search"></i>
          <input type="text" placeholder="Cari nama siswa / barang..." oninput="searchTable(this.value, 'tabelPeminjaman')">
        </div>
      </div>
      <div class="table-wrap">
        <table class="dash-table" id="tabelPeminjaman">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>Barang</th>
              <th>Jml</th>
              <th>Tgl Pinjam</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qp = mysqli_query($conn, "
              SELECT p.*, b.nama_barang FROM peminjaman p
              LEFT JOIN barang b ON p.id_barang = b.id
              ORDER BY
                CASE p.status WHEN 'menunggu' THEN 1 WHEN 'dipinjam' THEN 2 ELSE 3 END,
                p.id DESC
            ");
            $no = 1;
            while($p = mysqli_fetch_assoc($qp)):
              $badge = match($p['status']) {
                'menunggu'     => 'badge-yellow',
                'dipinjam'     => 'badge-blue',
                'dikembalikan' => 'badge-green',
                default        => 'badge-gray'
              };
              $label = match($p['status']) {
                'menunggu'     => 'Menunggu',
                'dipinjam'     => 'Dipinjam',
                'dikembalikan' => 'Dikembalikan',
                default        => $p['status']
              };
            ?>
            <tr data-status="<?= $p['status'] ?>">
              <td><?= $no++ ?></td>
              <td><strong><?= htmlspecialchars($p['nama_peminjam']) ?></strong></td>
              <td><?= htmlspecialchars($p['kelas'] ?? '-') ?></td>
              <td><?= htmlspecialchars($p['nama_barang'] ?? '-') ?></td>
              <td><?= $p['jumlah'] ?? 1 ?></td>
              <td><?= date('d M Y', strtotime($p['tgl_pinjam'])) ?></td>
              <td><span class="badge-dash <?= $badge ?>"><?= $label ?></span></td>
              <td style="display:flex;gap:6px;flex-wrap:wrap;">
                <?php if($p['status'] == 'menunggu'): ?>
                  <a href="aksi_peminjaman.php?aksi=konfirmasi&id=<?= $p['id'] ?>" class="btn-sm-act btn-ok">
                    <i class="bi bi-check-lg"></i> Konfirmasi
                  </a>
                  <a href="aksi_peminjaman.php?aksi=tolak&id=<?= $p['id'] ?>" class="btn-sm-act btn-del" onclick="return confirm('Tolak peminjaman ini?')">
                    <i class="bi bi-x-lg"></i> Tolak
                  </a>
                <?php elseif($p['status'] == 'dipinjam'): ?>
                  <a href="aksi_peminjaman.php?aksi=kembali&id=<?= $p['id'] ?>" class="btn-sm-act btn-return">
                    <i class="bi bi-arrow-return-left"></i> Kembalikan
                  </a>
                <?php else: ?>
                  <span class="badge-dash badge-green"><i class="bi bi-check-circle"></i> Selesai</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ==================== KELOLA ADMIN ==================== -->
  <section class="page-section" id="sec-admin">
    <div class="section-header">
      <div>
        <div class="section-title">Kelola Admin</div>
        <div class="section-subtitle">Manajemen akun administrator SiPinjam</div>
      </div>
      <button class="btn-primary-dash" onclick="openModal('modalTambahAdmin')">
        <i class="bi bi-plus-lg"></i> Tambah Admin
      </button>
    </div>

    <!-- Info -->
    <div style="background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:12px;font-size:.875rem;color:#1e40af;">
      <i class="bi bi-info-circle-fill" style="font-size:1.1rem;flex-shrink:0;"></i>
      <span>Total <strong><?= $total_admin ?> akun admin</strong> terdaftar. Minimal harus ada 1 akun admin aktif. Akun yang sedang login tidak dapat dihapus.</span>
    </div>

    <div class="dash-card">
      <div class="dash-card-header">
        <div class="section-title" style="font-size:.9rem;">Daftar Akun Admin</div>
        <div class="table-search">
          <i class="bi bi-search"></i>
          <input type="text" placeholder="Cari username..." oninput="searchTable(this.value, 'tabelAdmin')">
        </div>
      </div>
      <div class="table-wrap">
        <table class="dash-table" id="tabelAdmin">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Role</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qa = mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");
            $no = 1;
            while($a = mysqli_fetch_assoc($qa)):
              $isSelf = ($a['username'] === $_SESSION['username']);
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <div style="display:flex;align-items:center;gap:10px;">
                  <div style="width:34px;height:34px;border-radius:8px;background:linear-gradient(135deg,#3b82f6,#1a56db);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem;flex-shrink:0;">
                    <?= strtoupper(substr($a['username'], 0, 1)) ?>
                  </div>
                  <div>
                    <div style="font-weight:600;color:var(--gray-800)"><?= htmlspecialchars($a['username']) ?></div>
                    <div style="font-size:.72rem;color:var(--gray-400)">ID #<?= $a['id'] ?></div>
                  </div>
                </div>
              </td>
              <td><span class="badge-dash badge-blue"><i class="bi bi-shield-check"></i> Administrator</span></td>
              <td>
                <?php if($isSelf): ?>
                  <span class="badge-dash badge-green"><i class="bi bi-circle-fill" style="font-size:.5rem"></i> Login Sekarang</span>
                <?php else: ?>
                  <span class="badge-dash badge-gray"><i class="bi bi-circle-fill" style="font-size:.5rem"></i> Aktif</span>
                <?php endif; ?>
              </td>
              <td style="display:flex;gap:6px;flex-wrap:wrap;">
                <button class="btn-sm-act btn-edit"
                  onclick="openEditAdmin(<?= $a['id'] ?>, '<?= htmlspecialchars($a['username'], ENT_QUOTES) ?>')">
                  <i class="bi bi-pencil"></i> Edit
                </button>
                <?php if(!$isSelf): ?>
                  <a href="hapus_admin.php?id=<?= $a['id'] ?>"
                     class="btn-sm-act btn-del"
                     onclick="return confirm('Yakin hapus akun admin \'<?= htmlspecialchars($a['username'], ENT_QUOTES) ?>\'?')">
                    <i class="bi bi-trash"></i> Hapus
                  </a>
                <?php else: ?>
                  <span style="font-size:.75rem;color:var(--gray-400);padding:5px 8px;display:inline-flex;align-items:center;gap:4px;">
                    <i class="bi bi-lock"></i> Akun aktif
                  </span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

</main>

<!-- ============================================================
     MODAL TAMBAH BARANG
============================================================ -->
<div class="modal-overlay" id="modalTambahBarang">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-title"><i class="bi bi-plus-circle-fill" style="color:var(--blue-500)"></i> Tambah Barang</div>
      <button class="modal-close" onclick="closeModal('modalTambahBarang')"><i class="bi bi-x-lg"></i></button>
    </div>
    <form action="simpan_barang.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-grid">
          <div class="form-group span2">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-input" placeholder="Masukkan nama barang" required>
          </div>
          <div class="form-group span2">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-input" rows="2" placeholder="Deskripsi barang (opsional)"></textarea>
          </div>
          <div class="form-group span2">
            <label class="form-label">Jumlah Stok</label>
            <input type="number" name="stok" class="form-input" placeholder="0" min="0" required>
          </div>
          <div class="form-group span2">
            <label class="form-label">Foto Barang</label>
            <div class="foto-upload-wrap" id="fotoWrapTambah">
              <input type="file" name="foto" id="fotoTambah" accept="image/*" onchange="previewFotoModal(this, 'previewTambah', 'placeholderTambah')">
              <div id="placeholderTambah" class="foto-placeholder">
                <i class="bi bi-image" style="font-size:1.8rem;color:var(--gray-400)"></i>
                <div style="font-size:.8rem;color:var(--gray-500);margin-top:6px"><strong style="color:var(--blue-600)">Klik untuk upload</strong> foto barang</div>
                <div style="font-size:.72rem;color:var(--gray-400)">JPG, PNG, WEBP — Maks 2MB</div>
              </div>
              <img id="previewTambah" class="foto-preview" src="" alt="Preview">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-outline-dash" onclick="closeModal('modalTambahBarang')">Batal</button>
        <button type="submit" class="btn-primary-dash"><i class="bi bi-check-lg"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT BARANG -->
<div class="modal-overlay" id="modalEditBarang">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-title"><i class="bi bi-pencil-fill" style="color:var(--blue-500)"></i> Edit Barang</div>
      <button class="modal-close" onclick="closeModal('modalEditBarang')"><i class="bi bi-x-lg"></i></button>
    </div>
    <form action="update_barang.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" id="editId">
      <div class="modal-body">
        <div class="form-grid">
          <div class="form-group span2">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" id="editNama" class="form-input" required>
          </div>
          <div class="form-group span2">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="editDeskripsi" class="form-input" rows="2"></textarea>
          </div>
          <div class="form-group span2">
            <label class="form-label">Jumlah Stok</label>
            <input type="number" name="stok" id="editStok" class="form-input" min="0" required>
          </div>
          <div class="form-group span2">
            <label class="form-label">Foto Barang <span style="color:var(--gray-400);font-weight:400;text-transform:none">(kosongkan jika tidak diganti)</span></label>
            <div class="foto-upload-wrap" id="fotoWrapEdit">
              <input type="file" name="foto" id="fotoEdit" accept="image/*" onchange="previewFotoModal(this, 'previewEdit', 'placeholderEdit')">
              <div id="placeholderEdit" class="foto-placeholder">
                <i class="bi bi-image" style="font-size:1.8rem;color:var(--gray-400)"></i>
                <div style="font-size:.8rem;color:var(--gray-500);margin-top:6px"><strong style="color:var(--blue-600)">Klik untuk ganti</strong> foto barang</div>
              </div>
              <img id="previewEdit" class="foto-preview" src="" alt="Preview">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-outline-dash" onclick="closeModal('modalEditBarang')">Batal</button>
        <button type="submit" class="btn-primary-dash"><i class="bi bi-check-lg"></i> Update</button>
      </div>
    </form>
  </div>
</div>

<!-- ============================================================
     MODAL TAMBAH ADMIN
============================================================ -->
<div class="modal-overlay" id="modalTambahAdmin">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-title"><i class="bi bi-shield-plus" style="color:var(--blue-500)"></i> Tambah Admin Baru</div>
      <button class="modal-close" onclick="closeModal('modalTambahAdmin')"><i class="bi bi-x-lg"></i></button>
    </div>
    <form action="simpan_admin.php" method="POST">
      <div class="modal-body">
        <div class="form-grid">
          <div class="form-group span2">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-input" placeholder="Masukkan username" required autocomplete="off">
          </div>
          <div class="form-group">
            <label class="form-label">Password</label>
            <div style="position:relative;">
              <input type="password" name="password" id="pwTambah" class="form-input" placeholder="Min. 6 karakter" required autocomplete="new-password" style="padding-right:42px;">
              <button type="button" onclick="togglePw('pwTambah','eyeTambah')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);">
                <i class="bi bi-eye" id="eyeTambah"></i>
              </button>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <div style="position:relative;">
              <input type="password" name="konfirmasi" id="pwKonfTambah" class="form-input" placeholder="Ulangi password" required autocomplete="new-password" style="padding-right:42px;">
              <button type="button" onclick="togglePw('pwKonfTambah','eyeKonfTambah')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);">
                <i class="bi bi-eye" id="eyeKonfTambah"></i>
              </button>
            </div>
          </div>
          <div class="form-group span2" id="pwMatchInfo" style="display:none;">
            <div style="font-size:.8rem;padding:8px 12px;border-radius:8px;" id="pwMatchMsg"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-outline-dash" onclick="closeModal('modalTambahAdmin')">Batal</button>
        <button type="submit" class="btn-primary-dash"><i class="bi bi-check-lg"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT ADMIN -->
<div class="modal-overlay" id="modalEditAdmin">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-title"><i class="bi bi-shield-lock" style="color:var(--blue-500)"></i> Edit Admin</div>
      <button class="modal-close" onclick="closeModal('modalEditAdmin')"><i class="bi bi-x-lg"></i></button>
    </div>
    <form action="update_admin.php" method="POST">
      <input type="hidden" name="id" id="editAdminId">
      <input type="hidden" name="old_username" id="editAdminOldUsername">
      <div class="modal-body">
        <div class="form-grid">
          <div class="form-group span2">
            <label class="form-label">Username</label>
            <input type="text" name="username" id="editAdminUsername" class="form-input" required autocomplete="off">
          </div>
          <div class="form-group span2" style="background:var(--gray-50);border-radius:10px;padding:12px 14px;border:1.5px solid var(--gray-200);">
            <div style="font-size:.78rem;color:var(--gray-500);font-weight:600;margin-bottom:2px;text-transform:uppercase;letter-spacing:.4px;">
              <i class="bi bi-info-circle"></i> Ganti Password
            </div>
            <div style="font-size:.8rem;color:var(--gray-500);">Kosongkan jika tidak ingin mengganti password.</div>
          </div>
          <div class="form-group">
            <label class="form-label">Password Baru</label>
            <div style="position:relative;">
              <input type="password" name="password" id="pwEdit" class="form-input" placeholder="Kosongkan jika tidak diganti" autocomplete="new-password" style="padding-right:42px;">
              <button type="button" onclick="togglePw('pwEdit','eyeEdit')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);">
                <i class="bi bi-eye" id="eyeEdit"></i>
              </button>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <div style="position:relative;">
              <input type="password" name="konfirmasi" id="pwKonfEdit" class="form-input" placeholder="Ulangi password baru" autocomplete="new-password" style="padding-right:42px;">
              <button type="button" onclick="togglePw('pwKonfEdit','eyeKonfEdit')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);">
                <i class="bi bi-eye" id="eyeKonfEdit"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-outline-dash" onclick="closeModal('modalEditAdmin')">Batal</button>
        <button type="submit" class="btn-primary-dash"><i class="bi bi-check-lg"></i> Update</button>
      </div>
    </form>
  </div>
</div>

<!-- ============================================================
     JAVASCRIPT
============================================================ -->
<script>
// ── Section Navigation ──────────────────────────────────────
const sections = ['dashboard','barang','stok','peminjaman','admin'];
const titles   = {
  dashboard   : 'Dashboard',
  barang      : 'Manajemen Barang',
  stok        : 'Monitoring Stok',
  peminjaman  : 'Manajemen Peminjaman',
  admin       : 'Kelola Admin'
};

function showSection(name) {
  sections.forEach(s => {
    document.getElementById('sec-' + s).classList.remove('active');
    document.getElementById('nav-' + s)?.classList.remove('active');
  });
  document.getElementById('sec-' + name).classList.add('active');
  document.getElementById('nav-' + name)?.classList.add('active');
  document.getElementById('topbarTitle').textContent = titles[name];
  closeSidebar();
}

// ── Sidebar Mobile ───────────────────────────────────────────
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('open');
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sidebarOverlay').classList.remove('open');
}

// ── Modal ────────────────────────────────────────────────────
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(el => {
  el.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
  });
});

// ── Edit Barang ──────────────────────────────────────────────
function openEditBarang(id, nama, deskripsi, stok) {
  document.getElementById('editId').value        = id;
  document.getElementById('editNama').value      = nama;
  document.getElementById('editDeskripsi').value = deskripsi;
  document.getElementById('editStok').value      = stok;
  document.getElementById('previewEdit').style.display     = 'none';
  document.getElementById('placeholderEdit').style.display = 'flex';
  openModal('modalEditBarang');
}

// ── Preview Foto Modal ───────────────────────────────────────
function previewFotoModal(input, previewId, placeholderId) {
  const preview     = document.getElementById(previewId);
  const placeholder = document.getElementById(placeholderId);
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.style.display = 'block';
      placeholder.style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// ── Table Search ─────────────────────────────────────────────
function searchTable(query, tableId) {
  const rows = document.querySelectorAll('#' + tableId + ' tbody tr');
  const q = query.toLowerCase();
  rows.forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
}

// ── Global Search ────────────────────────────────────────────
function handleGlobalSearch(q) {
  if (!q) return;
  showSection('peminjaman');
  searchTable(q, 'tabelPeminjaman');
}

// ── Filter Peminjaman ────────────────────────────────────────
function filterPeminjaman(status, btn) {
  document.querySelectorAll('.filter-tab').forEach(b => {
    b.classList.remove('btn-primary-dash');
    b.classList.add('btn-outline-dash');
  });
  btn.classList.add('btn-primary-dash');
  btn.classList.remove('btn-outline-dash');
  const rows = document.querySelectorAll('#tabelPeminjaman tbody tr');
  rows.forEach(row => {
    row.style.display = (status === 'semua' || row.dataset.status === status) ? '' : 'none';
  });
}

// ── Toggle Password Visibility ───────────────────────────────
function togglePw(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'bi bi-eye-slash';
  } else {
    input.type = 'password';
    icon.className = 'bi bi-eye';
  }
}

// ── Open Edit Admin Modal ────────────────────────────────────
function openEditAdmin(id, username) {
  document.getElementById('editAdminId').value          = id;
  document.getElementById('editAdminUsername').value    = username;
  document.getElementById('editAdminOldUsername').value = username;
  document.getElementById('pwEdit').value               = '';
  document.getElementById('pwKonfEdit').value           = '';
  openModal('modalEditAdmin');
}

// ── Password Match Checker (Tambah Admin) ────────────────────
const pwT  = document.getElementById('pwTambah');
const pwKT = document.getElementById('pwKonfTambah');
if (pwT && pwKT) {
  function checkPwMatch() {
    const info = document.getElementById('pwMatchInfo');
    const msg  = document.getElementById('pwMatchMsg');
    if (!pwKT.value) { info.style.display = 'none'; return; }
    info.style.display = 'block';
    if (pwT.value === pwKT.value) {
      msg.style.background = '#dcfce7';
      msg.style.color      = '#15803d';
      msg.innerHTML = '<i class="bi bi-check-circle-fill"></i> Password cocok';
    } else {
      msg.style.background = '#fee2e2';
      msg.style.color      = '#b91c1c';
      msg.innerHTML = '<i class="bi bi-x-circle-fill"></i> Password tidak sama';
    }
  }
  pwT.addEventListener('input', checkPwMatch);
  pwKT.addEventListener('input', checkPwMatch);
}

// ── Toast ────────────────────────────────────────────────────
function showToast(msg, type = 'success') {
  const wrap = document.getElementById('toastWrap');
  const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
  const el = document.createElement('div');
  el.className = `toast-msg ${type}`;
  el.innerHTML = `<i class="bi ${icon}"></i> ${msg}`;
  wrap.appendChild(el);
  setTimeout(() => el.remove(), 3500);
}

// Show toast / redirect from URL param
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('success')) showToast(decodeURIComponent(urlParams.get('success')));
if (urlParams.get('error'))   showToast(decodeURIComponent(urlParams.get('error')), 'error');
if (urlParams.get('page'))    showSection(urlParams.get('page'));
</script>

</body>
</html>