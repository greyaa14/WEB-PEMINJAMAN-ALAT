<?php
include '../koneksi.php';

// Ambil semua barang
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';

$where = "WHERE 1=1";
if ($search) $where .= " AND nama_barang LIKE '%$search%'";
if ($filter === 'tersedia')   $where .= " AND stok > 3";
if ($filter === 'hampir')     $where .= " AND stok > 0 AND stok <= 3";
if ($filter === 'habis')      $where .= " AND stok = 0";

$barang_list = mysqli_query($conn, "SELECT * FROM barang $where ORDER BY nama_barang ASC");
$total = mysqli_num_rows($barang_list);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Alat — SiPinjam</title>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- CSS Daftar Alat -->
  <link rel="stylesheet" href="../assets/css/daftar_alat.css">
</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="da-navbar">
  <div class="da-navbar-inner">
    <a href="../index.php" class="da-brand">
      <div class="da-brand-icon"><i class="bi bi-box-seam-fill"></i></div>
      <div class="da-brand-name">SiPinjam</div>
    </a>
    <div class="da-nav-links">
      <a href="../index.php" class="da-nav-link">Home</a>
      <a href="daftar_alat.php" class="da-nav-link active">Daftar Alat</a>
      <a href="../index.php#cara-pinjam" class="da-nav-link">Cara Pinjam</a>
    </div>
  </div>
</nav>

<!-- ── HERO ── -->
<div class="da-hero">
  <div class="da-hero-content">
    <div class="da-hero-tag"><i class="bi bi-grid-3x3-gap-fill"></i> Inventaris Sekolah</div>
    <h1 class="da-hero-title">Daftar <span>Alat Tersedia</span></h1>
    <p class="da-hero-desc">Temukan dan pinjam peralatan sekolah dengan mudah. Cek stok secara real-time.</p>

    <!-- Search -->
    <form method="GET" action="">
      <div class="da-search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" name="search" placeholder="Cari nama alat..." value="<?= htmlspecialchars($search) ?>">
        <?php if($filter !== 'semua'): ?>
          <input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>">
        <?php endif; ?>
        <button type="submit" class="da-search-btn">Cari</button>
      </div>
    </form>
  </div>
</div>

<!-- ── MAIN ── -->
<div class="da-wrapper">

  <!-- Alert -->
  <?php if (isset($_GET['success'])): ?>
    <div class="da-alert success">
      <i class="bi bi-check-circle-fill"></i>
      <?= htmlspecialchars($_GET['success']) ?>
    </div>
  <?php endif; ?>
  <?php if (isset($_GET['error'])): ?>
    <div class="da-alert error">
      <i class="bi bi-exclamation-circle-fill"></i>
      <?= htmlspecialchars($_GET['error']) ?>
    </div>
  <?php endif; ?>

  <!-- Filter Bar -->
  <div class="da-filter-bar">
    <div class="da-filter-left">
      <span class="da-filter-label">Filter:</span>
      <a href="?filter=semua<?= $search ? '&search='.urlencode($search) : '' ?>"
         class="da-filter-btn <?= $filter === 'semua' ? 'active' : '' ?>">Semua</a>
      <a href="?filter=tersedia<?= $search ? '&search='.urlencode($search) : '' ?>"
         class="da-filter-btn <?= $filter === 'tersedia' ? 'active' : '' ?>">✅ Tersedia</a>
      <a href="?filter=hampir<?= $search ? '&search='.urlencode($search) : '' ?>"
         class="da-filter-btn <?= $filter === 'hampir' ? 'active' : '' ?>">⚠️ Hampir Habis</a>
      <a href="?filter=habis<?= $search ? '&search='.urlencode($search) : '' ?>"
         class="da-filter-btn <?= $filter === 'habis' ? 'active' : '' ?>">❌ Habis</a>
    </div>
    <div class="da-result-count">
      Menampilkan <strong><?= $total ?></strong> alat
      <?= $search ? 'untuk "<strong>'.htmlspecialchars($search).'</strong>"' : '' ?>
    </div>
  </div>

  <!-- Grid Alat -->
  <?php if ($total > 0): ?>
  <div class="da-grid">
    <?php while($alat = mysqli_fetch_assoc($barang_list)):
      $stok = $alat['stok'] ?? 0;
      $foto = !empty($alat['foto']) ? '../assets/img/' . $alat['foto'] : null;
      $badge_class = $stok > 3 ? 'badge-tersedia' : ($stok > 0 ? 'badge-hampir' : 'badge-habis');
      $badge_label = $stok > 3 ? 'Tersedia' : ($stok > 0 ? 'Hampir Habis' : 'Habis');
      $tersedia    = $stok > 0;
    ?>
    <div class="da-card">
      <!-- Gambar -->
      <div class="da-card-img">
        <?php if($foto): ?>
          <img src="<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($alat['nama_barang']) ?>">
        <?php else: ?>
          <div class="da-card-img-placeholder"><i class="bi bi-box-seam"></i></div>
        <?php endif; ?>
        <span class="da-card-badge <?= $badge_class ?>"><?= $badge_label ?></span>
      </div>

      <!-- Body -->
      <div class="da-card-body">
        <div class="da-card-name"><?= htmlspecialchars($alat['nama_barang']) ?></div>
        <div class="da-card-desc"><?= htmlspecialchars($alat['deskripsi'] ?: 'Tidak ada deskripsi.') ?></div>

        <div class="da-card-stok">
          <div class="da-stok-info">
            Stok: <strong><?= $stok ?></strong> unit
          </div>
        </div>

        <?php if($tersedia): ?>
          <button class="da-card-btn available"
            onclick="openModalPinjam(<?= $alat['id'] ?>, '<?= htmlspecialchars($alat['nama_barang'], ENT_QUOTES) ?>', <?= $stok ?>, '<?= $foto ? htmlspecialchars($foto, ENT_QUOTES) : '' ?>')">
            <i class="bi bi-bag-plus-fill"></i> Ajukan Pinjam
          </button>
        <?php else: ?>
          <button class="da-card-btn disabled" disabled>
            <i class="bi bi-x-circle"></i> Stok Habis
          </button>
        <?php endif; ?>
      </div>
    </div>
    <?php endwhile; ?>
  </div>

  <?php else: ?>
  <div class="da-empty">
    <i class="bi bi-inbox"></i>
    <h3>Tidak ada alat ditemukan</h3>
    <p><?= $search ? 'Coba kata kunci lain atau hapus filter.' : 'Belum ada alat yang tersedia.' ?></p>
  </div>
  <?php endif; ?>

</div>

<!-- ── FOOTER ── -->
<footer class="da-footer">
  © 2026 SiPinjam — SMKS Ketintang Surabaya
</footer>

<!-- ── MODAL PINJAM ── -->
<div class="da-modal-overlay" id="modalPinjam">
  <div class="da-modal-box">
    <div class="da-modal-header">
      <div class="da-modal-title">
        <i class="bi bi-bag-plus-fill"></i> Ajukan Peminjaman
      </div>
      <button class="da-modal-close" onclick="closeModalPinjam()"><i class="bi bi-x-lg"></i></button>
    </div>

    <!-- Info Barang -->
    <div class="da-modal-barang-info">
      <div class="da-modal-barang-img" id="modalBarangImg">
        <i class="bi bi-box-seam"></i>
      </div>
      <div>
        <div class="da-modal-barang-name" id="modalBarangName">-</div>
        <div class="da-modal-barang-stok">Stok tersedia: <strong id="modalBarangStok">0</strong> unit</div>
      </div>
    </div>

    <form action="proses_pinjam.php" method="POST">
      <input type="hidden" name="id_barang" id="modalIdBarang">

      <div class="da-modal-body">
        <div class="da-form-row">
          <div class="da-form-group">
            <label class="da-form-label">Nama Lengkap <span>*</span></label>
            <input type="text" name="nama_peminjam" class="da-form-input" placeholder="Nama kamu" required>
          </div>
          <div class="da-form-group">
            <label class="da-form-label">Kelas <span>*</span></label>
            <input type="text" name="kelas" class="da-form-input" placeholder="Contoh: XII TKJ 1" required>
          </div>
        </div>
        <div class="da-form-row">
          <div class="da-form-group">
            <label class="da-form-label">Jumlah <span>*</span></label>
            <input type="number" name="jumlah" id="modalJumlah" class="da-form-input" placeholder="1" min="1" value="1" required>
          </div>
          <div class="da-form-group">
            <label class="da-form-label">Tanggal Pinjam <span>*</span></label>
            <input type="date" name="tgl_pinjam" class="da-form-input" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>
        <div class="da-form-group">
          <label class="da-form-label">Keperluan</label>
          <input type="text" name="keperluan" class="da-form-input" placeholder="Untuk apa alat ini dipinjam? (opsional)">
        </div>
      </div>

      <div class="da-modal-footer">
        <button type="button" class="da-btn-cancel" onclick="closeModalPinjam()">Batal</button>
        <button type="submit" class="da-btn-submit">
          <i class="bi bi-send-fill"></i> Kirim Pengajuan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openModalPinjam(id, nama, stok, foto) {
  document.getElementById('modalIdBarang').value   = id;
  document.getElementById('modalBarangName').textContent = nama;
  document.getElementById('modalBarangStok').textContent = stok;
  document.getElementById('modalJumlah').max       = stok;

  const imgEl = document.getElementById('modalBarangImg');
  if (foto) {
    imgEl.innerHTML = `<img src="${foto}" alt="${nama}" style="width:100%;height:100%;object-fit:cover;">`;
  } else {
    imgEl.innerHTML = '<i class="bi bi-box-seam"></i>';
  }

  document.getElementById('modalPinjam').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModalPinjam() {
  document.getElementById('modalPinjam').classList.remove('open');
  document.body.style.overflow = '';
}

// Close on overlay click
document.getElementById('modalPinjam').addEventListener('click', function(e) {
  if (e.target === this) closeModalPinjam();
});
</script>

</body>
</html>