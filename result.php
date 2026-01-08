<?php
include 'koneksi.php';

// AMBIL DAN AMANKAN DATA GET
$keywordRaw = isset($_GET['keyword']) ? $_GET['keyword'] : '';
// Amankan string untuk query database
$keyword    = mysqli_real_escape_string($conn, $keywordRaw);

// Ambil parameter Filter & Sort
$min_price  = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price  = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? $_GET['max_price'] : '';
$sort       = isset($_GET['sort']) ? $_GET['sort'] : 'related';

// Fungsi bantu untuk membuat Link URL 
function buildUrl($newParams = [])
{
    $queryParams = $_GET;
    foreach ($newParams as $key => $value) {
        $queryParams[$key] = $value;
    }
    return '?' . http_build_query($queryParams);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Pencarian: <?php echo htmlspecialchars($keywordRaw); ?> - Aureon Tech</title>
    <link rel="icon" href="https://img.icons8.com/fluency/48/online-shopping.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* 
           1. STYLE DASAR (SAMA DENGAN INDEX.PHP)
           */
        body {
            background-color: #f5f5f5;
            font-family: sans-serif;
        }

        .shopee-header-wrapper {
            background: linear-gradient(-180deg, #1958d6, #0d6efd);
            color: white;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .shopee-top-bar {
            font-size: 0.9rem;
            padding: 8px 0;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            font-weight: 500;
        }

        .shopee-top-bar a {
            color: rgba(255, 255, 255, 0.95);
            text-decoration: none;
            padding: 0 15px;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            transition: opacity 0.2s;
            cursor: pointer;
        }

        .shopee-top-bar a:hover {
            opacity: 0.8;
        }

        .shopee-main-bar {
            padding: 20px 0;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .shopee-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            min-width: 180px;
        }

        .search-wrapper-rel {
            flex-grow: 1;
            position: relative;
        }

        .shopee-search-box {
            background: #fff;
            border-radius: 6px;
            padding: 5px;
            display: flex;
            height: 45px;
            position: relative;
            z-index: 50;
        }

        .shopee-search-input {
            width: 100%;
            border: none;
            outline: none;
            padding: 0 15px;
            font-size: 1.1rem;
            border-radius: 4px;
            height: 100%;
        }

        .shopee-search-btn {
            background-color: #0d6efd;
            border: none;
            border-radius: 4px;
            color: white;
            padding: 0 35px;
            margin: 0;
            transition: 0.3s;
            font-size: 1.2rem;
            height: 100%;
            cursor: pointer;
        }

        .shopee-search-btn:hover {
            background-color: #0b5ed7;
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border-radius: 0 0 6px 6px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 100;
            display: none;
            margin-top: 2px;
            overflow: hidden;
        }

        .suggestion-item {
            padding: 10px 15px;
            background: #fff;
            border-bottom: 1px solid #f5f5f5;
            cursor: pointer;
            transition: background 0.2s;
            color: #333;
        }

        .suggestion-item:hover {
            background-color: #f0f8ff;
        }

        .shopee-cart {
            font-size: 2.2rem;
            color: white;
            margin-left: 25px;
            position: relative;
            cursor: pointer;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: #ffc107;
            color: #000;
            font-size: 0.8rem;
            padding: 2px 8px;
            border-radius: 12px;
            border: 2px solid #fff;
            font-weight: bold;
        }

        .header-links {
            margin-top: 8px;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .header-links a {
            color: #fff;
            text-decoration: none;
            margin-right: 15px;
        }

        .header-links a:hover {
            text-decoration: underline;
        }

        /* 
           2. FOOTER STYLE
         */
        .shopee-footer {
            background-color: #fbfbfb;
            border-top: 4px solid #0d6efd;
            padding-top: 50px;
            padding-bottom: 30px;
            font-size: 1rem;
            color: #333;
            margin-top: 50px;
        }

        .shopee-footer h6 {
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 25px;
            color: #000;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        .shopee-footer ul li {
            margin-bottom: 12px;
        }

        .shopee-footer ul li a {
            color: rgba(0, 0, 0, 0.7);
            text-decoration: none;
            transition: color 0.2s;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .shopee-footer ul li a:hover {
            color: #0d6efd;
        }

        .footer-payment-icons img,
        .footer-shipping-icons img {
            height: 35px;
            width: auto;
            margin-right: 6px;
            margin-bottom: 6px;
            background: #fff;
            padding: 3px;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            object-fit: contain;
        }

        .footer-social-icon {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: rgba(0, 0, 0, 0.7);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .footer-social-icon:hover {
            color: #000;
        }

        .footer-social-icon i {
            font-size: 1.4rem;
            margin-right: 10px;
        }

        .footer-download-qr {
            width: 90px;
            height: 90px;
            margin-right: 12px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .footer-download-apps img {
            width: 80px;
            height: auto;
            margin-bottom: 5px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 2px;
        }

        .footer-copyright {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 30px;
            margin-top: 40px;
            font-size: 0.95rem;
            color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: space-between;
            font-weight: 500;
        }

        #scrollToTopBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #0d6efd;
            color: white;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* 
           3. STYLE KHUSUS RESULT (FILTER & SORT)
           */
        .filter-sidebar {
            font-size: 0.9rem;
        }

        .filter-group {
            border-bottom: 1px solid #e8e8e8;
            padding: 15px 0;
        }

        .filter-header {
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-item {
            display: block;
            padding: 4px 0;
            color: #444;
            cursor: pointer;
        }

        .filter-item:hover {
            color: #0d6efd;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .sort-bar {
            background: #ededed;
            padding: 10px 20px;
            border-radius: 2px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .sort-label {
            font-size: 0.9rem;
            margin-right: 5px;
            color: #555;
        }

        .sort-btn {
            border: 1px solid transparent;
            background: #fff;
            padding: 5px 15px;
            font-size: 0.9rem;
            cursor: pointer;
            border-radius: 2px;
            text-decoration: none;
            color: #333;
            transition: 0.2s;
        }

        .sort-btn:hover {
            background: #f0f0f0;
        }

        .sort-btn.active {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        /* Dropdown Sort Price */
        .sort-price-dropdown {
            position: relative;
            display: inline-block;
        }

        .sort-price-btn {
            background: #fff;
            padding: 5px 15px;
            min-width: 150px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 2px;
            cursor: pointer;
            font-size: 0.9rem;
            border: 1px solid transparent;
        }

        .sort-price-btn.active {
            background: #0d6efd;
            color: white;
        }

        .card-result {
            border: 1px solid transparent;
            transition: all 0.1s;
            border-radius: 0;
        }

        .card-result:hover {
            border: 1px solid #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        /*  4. RESPONSIVE MEDIA QUERIES */
        @media (max-width: 992px) {
            .shopee-top-bar {
                display: none;
            }

            .header-links {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .shopee-main-bar {
                flex-wrap: wrap;
                justify-content: space-between;
                padding: 15px 0;
            }

            .shopee-brand {
                order: 1;
                flex-grow: 1;
                font-size: 1.3rem;
            }

            .shopee-cart {
                order: 2;
                margin-left: 0;
                font-size: 1.8rem;
            }

            .search-wrapper-rel {
                order: 3;
                width: 100%;
                margin-top: 15px;
            }

            .shopee-search-btn {
                padding: 0 20px;
            }

            .sort-bar {
                overflow-x: auto;
                white-space: nowrap;
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .shopee-header-wrapper {
                position: sticky;
                top: 0;
            }

            .shopee-brand svg {
                width: 40px;
                height: 40px;
            }

            .shopee-brand span {
                font-size: 1.2rem;
            }

            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .card-result .p-2.d-flex {
                height: 150px !important;
            }

            .card-result h6 {
                font-size: 0.8rem !important;
            }

            .text-primary.fw-bold {
                font-size: 0.9rem !important;
            }

            .shopee-footer .row>div {
                text-align: center;
                margin-bottom: 20px;
            }

            .footer-payment-icons,
            .footer-shipping-icons,
            .mb-4 {
                justify-content: center;
                display: flex;
                flex-wrap: wrap;
            }

            .d-flex.align-items-center {
                justify-content: center;
            }

            .footer-copyright {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <header class="shopee-header-wrapper">
        <div class="container-fluid px-3">
            <div class="shopee-top-bar">
                <div class="d-flex align-items-center">
                    <a href="#">Seller Centre</a>
                    <a href="#">Download</a>
                    <span class="ms-2 me-2 text-white opacity-75">Ikuti kami di</span>
                    <a href="#" style="border:none"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" style="border:none"><i class="bi bi-instagram fs-5"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    <a href="#"><i class="bi bi-bell"></i> Notifikasi</a>
                    <a href="#"><i class="bi bi-question-circle"></i> Bantuan</a>
                    <div class="dropdown d-inline">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-globe me-1"></i> Bahasa Indonesia</a>
                        <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                            <li><a class="dropdown-item custom-dropdown-item active-lang" href="#">Bahasa Indonesia</a></li>
                            <li><a class="dropdown-item custom-dropdown-item" href="#">English</a></li>
                        </ul>
                    </div>
                    <a href="#" class="fw-bold ms-4">Daftar</a>
                    <a href="login.php" class="fw-bold" style="border:none">Log In</a>
                </div>
            </div>

            <div class="shopee-main-bar">
                <a class="shopee-brand" href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="70" height="70" class="me-3">
                        <path d="M35 80 L10 80 L45 10 L55 10 Z" fill="#ffffff" />
                        <path d="M65 80 L90 80 L55 10 L45 10 Z" fill="#f0f0f0" />
                        <path d="M25 60 L75 60 L75 75 L25 75 Z" fill="#00bfff" />
                        <path d="M20 60 L80 60" stroke="#0d6efd" stroke-width="2" />
                    </svg>
                    <span class="text-white">Aureon Tech</span>
                </a>

                <div class="search-wrapper-rel">
                    <form action="result.php" method="GET" class="shopee-search-box">
                        <input type="text" name="keyword" class="shopee-search-input" value="<?php echo htmlspecialchars($keywordRaw); ?>" placeholder="Cari gadget impianmu disini..." id="search-input" autocomplete="off">
                        <button type="submit" class="shopee-search-btn"><i class="bi bi-search"></i></button>
                        <div id="suggestions-box" class="search-suggestions"></div>
                    </form>
                    <div class="header-links">
                        <a href="#">Laptop Gaming</a> <a href="#">iPhone 15</a> <a href="#">Headset Bluetooth</a>
                    </div>
                </div>

                <div class="shopee-cart">
                    <i class="bi bi-cart3"></i><span class="cart-badge">3</span>
                </div>
            </div>
        </div>
    </header>

    <div class="container py-4">

        <div class="mb-3 text-muted small">
            <i class="bi bi-house-door"></i> Beranda &nbsp;>&nbsp; Hasil pencarian untuk "<strong><?php echo htmlspecialchars($keywordRaw); ?></strong>"
        </div>

        <div class="row">
            <div class="col-lg-2 d-none d-lg-block filter-sidebar">
                <div class="mb-3">
                    <div class="filter-header"><i class="bi bi-funnel"></i> FILTER</div>
                </div>

                <form action="result.php" method="GET">
                    <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($keywordRaw); ?>">
                    <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">

                    <div class="filter-group">
                        <div class="fw-bold mb-2">Lokasi</div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="loc1"><label class="form-check-label" for="loc1">Jabodetabek</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="loc2"><label class="form-check-label" for="loc2">DKI Jakarta</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="loc3"><label class="form-check-label" for="loc3">Jawa Barat</label></div>
                        <div class="more-link text-muted small mt-1 ps-4"><i class="bi bi-chevron-down"></i> Lainnya</div>
                    </div>

                    <div class="filter-group">
                        <div class="fw-bold mb-2">Batas Harga</div>
                        <div class="d-flex align-items-center gap-1 mb-2">
                            <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Rp MIN" value="<?php echo $min_price; ?>">
                            <span>-</span>
                            <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Rp MAX" value="<?php echo $max_price; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">TERAPKAN</button>
                    </div>
                </form>
            </div>

            <div class="col-lg-10">
                <div class="sort-bar">
                    <span class="sort-label">Urutkan:</span>

                    <a href="result.php<?php echo buildUrl(['sort' => 'related']); ?>" class="sort-btn <?php echo ($sort == 'related') ? 'active' : ''; ?>">Terkait</a>
                    <a href="result.php<?php echo buildUrl(['sort' => 'newest']); ?>" class="sort-btn <?php echo ($sort == 'newest') ? 'active' : ''; ?>">Terbaru</a>
                    <a href="result.php<?php echo buildUrl(['sort' => 'bestselling']); ?>" class="sort-btn <?php echo ($sort == 'bestselling') ? 'active' : ''; ?>">Terlaris</a>

                    <div class="dropdown">
                        <div class="sort-price-btn <?php echo ($sort == 'price_asc' || $sort == 'price_desc') ? 'active' : ''; ?>" data-bs-toggle="dropdown">
                            <span><?php echo ($sort == 'price_asc') ? 'Harga: Rendah ke Tinggi' : (($sort == 'price_desc') ? 'Harga: Tinggi ke Rendah' : 'Harga'); ?></span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="result.php<?php echo buildUrl(['sort' => 'price_asc']); ?>">Harga: Rendah ke Tinggi</a></li>
                            <li><a class="dropdown-item" href="result.php<?php echo buildUrl(['sort' => 'price_desc']); ?>">Harga: Tinggi ke Rendah</a></li>
                        </ul>
                    </div>
                </div>

                <div class="row g-2 row-cols-2 row-cols-md-4 row-cols-lg-5">
                    <?php
                    // 2. QUERY DINAMIS BERDASARKAN FILTER
                    $query = "SELECT * FROM produk WHERE (nama_produk LIKE '%$keyword%' OR kategori LIKE '%$keyword%')";

                    // Tambah filter harga jika ada
                    if ($min_price != '') {
                        $query .= " AND harga >= $min_price";
                    }
                    if ($max_price != '') {
                        $query .= " AND harga <= $max_price";
                    }

                    // Tambah urutan (Sorting)
                    if ($sort == 'newest') {
                        $query .= " ORDER BY id DESC"; // ID terbesar = Terbaru
                    } elseif ($sort == 'bestselling') {
                        $query .= " ORDER BY RAND()";
                    } elseif ($sort == 'price_asc') {
                        $query .= " ORDER BY harga ASC"; // Termurah
                    } elseif ($sort == 'price_desc') {
                        $query .= " ORDER BY harga DESC"; // Termahal
                    } else {
                        
                    }

                    $res = mysqli_query($conn, $query);

                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $harga = "Rp " . number_format($row['harga'], 0, ',', '.');
                            $lokasi = array("Jakarta Barat", "Kota Surabaya", "Kab. Tangerang", "Jakarta Pusat");
                            $lokasi_acak = $lokasi[array_rand($lokasi)];
                            // Simulasi terjual 
                            $terjual = rand(50, 1000);
                    ?>
                            <div class="col" data-aos="fade-up">
                                <div class="card h-100 card-result bg-white">
                                    <div class="p-2 d-flex align-items-center justify-content-center" style="height:180px; overflow:hidden;">
                                        <img src="<?php echo $row['gambar']; ?>" class="img-fluid" style="max-height:100%; max-width:100%;">
                                    </div>
                                    <div class="card-body p-2 d-flex flex-column">
                                        <h6 class="text-truncate mb-1" style="font-size: 0.9rem; line-height: 1.2em; height: 2.4em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo $row['nama_produk']; ?></h6>
                                        <div class="mt-auto">
                                            <div class="text-primary fw-bold mb-1" style="font-size: 1rem;"><?php echo $harga; ?></div>
                                            <div class="d-flex align-items-center small text-muted mb-1" style="font-size: 0.75rem;">
                                                <div class="me-2 text-warning"><i class="bi bi-star-fill"></i> 4.<?php echo rand(5, 9); ?></div>
                                                <div><?php echo $terjual; ?> Terjual</div>
                                            </div>
                                            <div class="text-muted small text-truncate" style="font-size: 0.75rem;"><i class="bi bi-geo-alt"></i> <?php echo $lokasi_acak; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="col-12 text-center py-5">
                    <div class="mb-3"><i class="bi bi-search fs-1 text-muted"></i></div>
                    <h5 class="text-muted">Produk tidak ditemukan</h5>
                    <p class="text-muted">Coba kata kunci lain atau kurangi filter.</p>
                  </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="shopee-footer">
        <div class="container-fluid px-3">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <h6>LAYANAN PELANGGAN</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Bantuan</a></li>
                        <li><a href="#">Metode Pembayaran</a></li>
                        <li><a href="#">ShopeePay</a></li>
                        <li><a href="#">Koin Shopee</a></li>
                        <li><a href="#">Lacak Pesanan Pembeli</a></li>
                        <li><a href="#">Gratis Ongkir</a></li>
                        <li><a href="#">Pengembalian Barang & Dana</a></li>
                        <li><a href="#">Garansi Shopee</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6">
                    <h6>JELAJAHI AUREON</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Kebijakan Aureon</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Aureon Mall</a></li>
                        <li><a href="#">Seller Centre</a></li>
                        <li><a href="#">Flash Sale</a></li>
                        <li><a href="#">Kontak Media</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6">
                    <h6>PEMBAYARAN</h6>
                    <div class="d-flex flex-wrap footer-payment-icons mb-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri">
                        <img src="https://images.seeklogo.com/logo-png/35/2/bank-bni-logo-png_seeklogo-355606.png" alt="BNI">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg" alt="BRI">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GoPay">
                        <img src="https://pbs.twimg.com/media/EUbePLEU0AIpder.jpg" alt="OVO">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Logo_Indomaret.png/1280px-Logo_Indomaret.png" alt="Indomaret">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Alfamart_logo.svg" alt="Alfamart">
                    </div>
                    <h6>PENGIRIMAN</h6>
                    <div class="d-flex flex-wrap footer-shipping-icons">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/92/New_Logo_JNE.png" alt="JNE">
                        <img src="https://i.pinimg.com/736x/72/23/3c/72233c7d51fe3ffde3cb3c345a7f7731.jpg" alt="J&T">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwtAQ3uug50276mHy9MJE8yiJWHCbKQEcI0A&s" alt="SiCepat">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f6/Grab_Logo.svg" alt="Grab">
                        <img src="https://everpro.id/wp-content/uploads/2022/09/gosend1.jpg" alt="GoSend">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRQhCp4Szj86kC2pS5pIJJk8PxhzQhqzhjFbQ&s" alt="Pos Indonesia">
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <h6>IKUTI KAMI</h6>
                    <div class="mb-4">
                        <a href="https://www.facebook.com/univ.diannswantoro" target="_blank" class="footer-social-icon"><i class="bi bi-facebook"></i> Facebook</a>
                        <a href="https://www.instagram.com/udinus_smg" target="_blank" class="footer-social-icon"><i class="bi bi-instagram"></i> Instagram</a>
                        <a href="https://twitter.com/udinus_smg" target="_blank" class="footer-social-icon"><i class="bi bi-twitter"></i> Twitter</a>
                        <a href="https://www.linkedin.com/school/universitas-dian-nuswantoro" target="_blank" class="footer-social-icon"><i class="bi bi-linkedin"></i> LinkedIn</a>
                    </div>
                    <h6>DOWNLOAD APLIKASI AUREON</h6>
                    <div class="d-flex align-items-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QR Code" class="footer-download-qr bg-white p-1">
                        <div class="footer-download-apps d-flex flex-column">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Play Store">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store">
                            <img src="https://img.freepik.com/vektor-premium/sebuah-logo-hitam-putih-dengan-segitiga-biru-di-bagian-bawah_853558-1949.jpg" alt="App Gallery">
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-2 mb-md-0">&copy; 2025 AureonTech. Hak Cipta Dilindungi.</div>
                <div class="small">
                    Negara: <a href="#" class="text-muted text-decoration-none">Indonesia</a> | <a href="#" class="text-muted text-decoration-none">Singapura</a> | <a href="#" class="text-muted text-decoration-none">Malaysia</a>
                </div>
            </div>
        </div>
    </footer>

    <button onclick="topFunction()" id="scrollToTopBtn" title="Kembali ke Atas"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        AOS.init();

        // SCRIPT SEARCH SUGGESTION 
        $(document).ready(function() {
            $('#search-input').on('keyup', function() {
                var query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: "ajax_suggest.php",
                        method: "GET",
                        data: {
                            keyword: query
                        },
                        success: function(data) {
                            $('#suggestions-box').fadeIn();
                            $('#suggestions-box').html(data);
                        }
                    });
                } else {
                    $('#suggestions-box').fadeOut();
                }
            });

            $(document).on('click', '.suggestion-item', function() {
                var text = $(this).data('name');
                $('#search-input').val(text);
                $('#suggestions-box').fadeOut();
                $('form.shopee-search-box').submit();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-wrapper-rel').length) {
                    $('#suggestions-box').fadeOut();
                }
            });
        });

        const scrollToTopBtn = document.getElementById("scrollToTopBtn");
        window.onscroll = () => {
            scrollToTopBtn.style.display = (window.scrollY > 300) ? "block" : "none";
        };

        function topFunction() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }
    </script>
</body>

</html>