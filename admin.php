<?php
session_start();
include 'koneksi.php';

// Cek keamanan: Jika belum login, tendang ke login.php
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

// LOGIKA TAMBAH PRODUK
$pesan = "";
if (isset($_POST['simpan'])) {
    $nama       = $_POST['nama_produk'];
    $harga      = $_POST['harga'];
    $deskripsi  = $_POST['deskripsi'];
    $kategori   = $_POST['kategori'];
    $gambar     = $_POST['gambar'];

    $query = "INSERT INTO produk (nama_produk, deskripsi, harga, gambar, kategori) 
              VALUES ('$nama', '$deskripsi', '$harga', '$gambar', '$kategori')";

    if (mysqli_query($conn, $query)) {
        $pesan = "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <i class='bi bi-check-circle-fill me-2'></i> Berhasil: <strong>$nama</strong> tersimpan!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else {
        $pesan = "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <i class='bi bi-exclamation-triangle-fill me-2'></i> Gagal: " . mysqli_error($conn) . "
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
}

// LOGIKA HAPUS PRODUK
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");
    header("location:admin.php");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - Aureon Tech</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230d6efd'/><path d='M35 80 L10 80 L45 10 L55 10 Z' fill='%23ffffff'/><path d='M65 80 L90 80 L55 10 L45 10 Z' fill='%23f0f0f0'/><path d='M25 60 L75 60 L75 75 L25 75 Z' fill='%2300bfff'/></svg>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
        }

        /* Navbar Gradient Aureon */
        .navbar-aureon {
            background: linear-gradient(90deg, #1958d6 0%, #0d6efd 100%);
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
            padding: 12px 0; 
        }

        .card-modern {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: #fff;
            transition: transform 0.3s ease;
        }

        .card-header-modern {
            background: transparent;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 25px;
            font-weight: 700;
            color: #333;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
            border-color: #0d6efd;
        }

        .table-custom thead th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 15px;
            white-space: nowrap;
        }

        .table-custom tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            white-space: nowrap;
        }

        .product-img-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary-modern {
            background: linear-gradient(90deg, #1958d6, #0d6efd);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
            transition: all 0.3s;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        /* --- RESPONSIVE CSS --- */
        @media (max-width: 768px) {
            .navbar-brand svg { width: 32px; height: 32px; } /* Perkecil logo sedikit di HP */
            .navbar-brand span.fs-4 { font-size: 1.15rem !important; } /* Perkecil teks di HP */
            
            .container { padding-left: 15px; padding-right: 15px; }
            .card-header-modern { flex-direction: column; align-items: flex-start; gap: 15px; }
            .card-header-modern > div:last-child { width: 100% !important; }
            
            .product-img-thumb { width: 50px; height: 50px; }
            .table-custom thead th, .table-custom tbody td { padding: 10px; font-size: 0.9rem; }
            
            .page-header-actions {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 15px;
            }
            .page-header-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark navbar-aureon sticky-top">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">

                <a class="navbar-brand d-flex align-items-center p-0 m-0" href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40" class="me-2">
                        <path d="M35 80 L10 80 L45 10 L55 10 Z" fill="#ffffff" stroke="rgba(255,255,255,0.2)" stroke-width="1" />
                        <path d="M65 80 L90 80 L55 10 L45 10 Z" fill="#f0f0f0" stroke="rgba(255,255,255,0.2)" stroke-width="1" />
                        <path d="M25 60 L75 60 L75 75 L25 75 Z" fill="#00bfff" />
                        <path d="M20 60 L80 60" stroke="#fff" stroke-width="2" />
                    </svg>
                    <span class="fw-bold fs-4 tracking-wide">Aureon Tech</span>
                    <span class="badge bg-white text-primary ms-2 rounded-pill" style="font-size: 0.7rem;">ADMIN</span>
                </a>

                <div class="d-flex align-items-center gap-2">

                    <div class="text-white d-none d-lg-block text-end me-2">
                        <small class="d-block opacity-75" style="font-size: 0.75rem; line-height: 1;">Login Sebagai</small>
                        <span class="fw-bold"><?php echo strtoupper($_SESSION['username']); ?></span>
                    </div>

                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>

                    <div class="dropdown">
                        <button class="btn text-white border-0 p-0 ms-1 d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list" style="font-size: 2.2rem;"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2" style="border-radius: 12px;">
                            <li class="d-lg-none px-3 py-2 text-center bg-light rounded mb-2">
                                <small class="d-block text-muted mb-1">Login Sebagai</small>
                                <strong><?php echo strtoupper($_SESSION['username']); ?></strong>
                            </li>
                            <li>
                                <a class="dropdown-item rounded py-2" href="index.php">
                                    <i class="bi bi-globe me-2 text-primary"></i> Lihat Website
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item rounded py-2 text-danger fw-bold" href="logout.php" onclick="return confirm('Yakin ingin logout?')">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                </div> </div> </div>
    </nav>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4 page-header-actions">
            <div>
                <h2 class="fw-bold text-dark mb-1">Dashboard Produk</h2>
                <p class="text-muted mb-0">Kelola katalog produk Aureon Tech Anda di sini.</p>
            </div>
            <a href="index.php" class="btn btn-outline-primary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Toko
            </a>
        </div>

        <div class="row g-4">

            <div class="col-lg-4">
                <div class="card-modern h-100">
                    <div class="card-header-modern">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        Tambah Produk Baru
                    </div>
                    <div class="card-body p-4">
                        <?php echo $pesan; ?>

                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" name="nama_produk" class="form-control" id="floatingInput" required placeholder="Nama Produk">
                                <label for="floatingInput">Nama Produk</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="harga" class="form-control" id="floatingHarga" required placeholder="Harga">
                                <label for="floatingHarga">Harga (Rp)</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select name="kategori" class="form-select" id="floatingSelect">
                                    <option value="laptop">Laptop</option>
                                    <option value="hp">Handphone</option>
                                    <option value="watch">Smartwatch</option>
                                    <option value="audio">Audio</option>
                                    <option value="camera">Kamera</option>
                                    <option value="accessories">Aksesoris</option>
                                </select>
                                <label for="floatingSelect">Pilih Kategori</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Link Gambar (URL)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-link-45deg"></i></span>
                                    <input type="url" name="gambar" class="form-control border-start-0 ps-0" required placeholder="https://...">
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <textarea name="deskripsi" class="form-control" id="floatingDesc" style="height: 100px" placeholder="Deskripsi"></textarea>
                                <label for="floatingDesc">Deskripsi Singkat</label>
                            </div>

                            <button type="submit" name="simpan" class="btn btn-primary-modern w-100 text-white">
                                <i class="bi bi-save me-2"></i> Simpan Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-modern">
                    <div class="card-header-modern justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-success bg-opacity-10 text-success p-2 rounded-3">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <span class="text-nowrap">Daftar Produk</span>
                        </div>
                        <div style="width: 200px; min-width: 150px;">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari produk..." id="searchTable">
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover mb-0" id="productTable">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $harga_fmt = "Rp " . number_format($row['harga'], 0, ',', '.');
                                            echo "<tr>";
                                            echo "<td class='ps-4'>
                                                    <div class='d-flex align-items-center'>
                                                        <img src='" . $row['gambar'] . "' class='product-img-thumb me-3'>
                                                        <div>
                                                            <div class='fw-bold text-dark'>" . $row['nama_produk'] . "</div>
                                                            <small class='text-muted d-block text-truncate' style='max-width: 150px;'>" . substr($row['deskripsi'], 0, 40) . "...</small>
                                                        </div>
                                                    </div>
                                                </td>";
                                            echo "<td><span class='badge bg-light text-dark border'>" . strtoupper($row['kategori']) . "</span></td>";
                                            echo "<td class='fw-bold text-primary'>$harga_fmt</td>";
                                            echo "<td class='text-end pe-4'>
                                                    <a href='admin.php?hapus=" . $row['id'] . "' class='btn btn-action btn-danger text-white' onclick='return confirm(\"Yakin ingin menghapus produk ini?\")' title='Hapus'>
                                                        <i class='bi bi-trash'></i>
                                                    </a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center py-5 text-muted'>Belum ada data produk.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchTable").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#productTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>