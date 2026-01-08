<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Toko Online - Aureon Tech</title>

  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230d6efd'/><path d='M35 80 L10 80 L45 10 L55 10 Z' fill='%23ffffff'/><path d='M65 80 L90 80 L55 10 L45 10 Z' fill='%23f0f0f0'/><path d='M25 60 L75 60 L75 75 L25 75 Z' fill='%2300bfff'/></svg>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    /*
       BASE STYLES (DESKTOP FIRST)
    */
    .shopee-header-wrapper {
      background: linear-gradient(-180deg, #1958d6, #0d6efd);
      color: white;
      position: sticky;
      top: 0;
      z-index: 1020;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
      font-family: sans-serif;
    }

    /* Top Bar */
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

    .shopee-top-bar a:last-child {
      border-right: none;
    }

    .shopee-top-bar a:hover {
      opacity: 0.8;
    }

    /* Dropdown Bahasa */
    .custom-dropdown-menu {
      border: none;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      padding: 8px;
      margin-top: 10px;
      font-size: 1rem;
      min-width: 200px;
    }

    .custom-dropdown-item {
      padding: 10px 15px;
      border-radius: 5px;
      transition: all 0.2s;
      font-weight: 500;
      color: #333;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
    }

    .custom-dropdown-item:hover {
      background-color: #f0f8ff;
      color: #0d6efd;
      transform: translateX(5px);
    }

    .custom-dropdown-item.active-lang {
      color: #0d6efd;
      font-weight: 700;
      background-color: #e6f2ff;
    }

    /* Main Bar Header */
    .shopee-main-bar {
      padding: 20px 0;
      display: flex;
      align-items: center;
      gap: 20px;
      flex-wrap: nowrap;
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

    /* Search Wrapper Relative untuk Dropdown Suggestion */
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

    /* Search Suggestions Dropdown */
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
      color: #333;
    }

    .suggestion-item {
      padding: 10px 15px;
      background: #fff;
      border-bottom: 1px solid #f5f5f5;
      cursor: pointer;
      transition: background 0.2s;
    }

    .suggestion-item:hover {
      background-color: #f0f8ff;
    }

    /* Cart Icon */
    .shopee-cart {
      font-size: 2.2rem;
      color: white;
      margin-left: 25px;
      position: relative;
      cursor: pointer;
      white-space: nowrap;
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
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .header-links a {
      color: #fff;
      text-decoration: none;
      margin-right: 15px;
    }

    .header-links a:hover {
      text-decoration: underline;
    }

    /* Schedule / Timer Bar */
    .schedule-bar {
      background: #fff;
      padding: 15px 20px;
      border-bottom: 1px solid #ddd;
      display: flex;
      align-items: center;
      gap: 20px;
      border-radius: 8px;
      flex-wrap: wrap;
    }

    .timer-digit {
      background: #000;
      color: #fff;
      font-weight: bold;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 1.1rem;
    }

    /* Category Cards */
    .category-card {
      background: #fff;
      border-radius: 15px;
      padding: 20px 10px;
      text-align: center;
      border: 1px solid rgba(0, 0, 0, 0.05);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
      transition: all 0.4s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-decoration: none;
      min-height: 90px;
    }

    .category-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(13, 110, 253, 0.15);
      border-color: #0d6efd;
    }

    .category-icon-box {
      font-size: 1.8rem;
      margin-bottom: 15px;
      display: inline-block;
      background: linear-gradient(45deg, #1958d6, #0dcaf0);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      color: transparent;
      transition: transform 0.3s ease;
    }

    .category-card:hover .category-icon-box {
      transform: scale(1.1);
    }

    .category-title {
      font-size: 0.85rem;
      font-weight: 700;
      color: #333;
      transition: color 0.3s;
    }

    .category-card:hover .category-title {
      color: #0d6efd;
    }

    /* General Utilities */
    .feature-icon {
      color: #0d6efd !important;
      font-size: 2.5rem;
    }

    .card:hover {
      transform: translateY(-5px);
      transition: transform 0.3s ease;
    }

    /* 
       BANNER STYLE (UKURAN BESAR & TEKS DI BAWAH)
     */
    .header-banner {
      width: 100%;
      min-height: 600px;

      background-image: url("https://www.agres.id/article/wp-content/uploads/2024/08/1920x1080px-Landscape-INTEL_INDEPENDENCE-DAY.jpg");
      background-repeat: no-repeat;

      background-position: center top;

      background-size: cover;
      background-color: #f8f9fa;
      border-radius: 15px;
      position: relative;
      overflow: hidden;

      display: flex;
      /* flex-end memaksa konten (Promo Gajian) turun ke lantai dasar banner */
      align-items: flex-end;
    }

    .banner-overlay {
      /* Gradasi halus dari bawah ke atas supaya teks putih terbaca */
      background: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0) 50%);
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;

      display: flex;
      /* Pastikan items ada di bawah */
      align-items: flex-end;
      justify-content: flex-start;

      /* Memberi jarak dari pojok kiri bawah */
      padding: 50px;
      padding-bottom: 60px;
      /* Sedikit naik agar tidak mepet garis bawah */
    }

    .banner-content {
      color: #feffff;
      text-align: left;
      width: 60%;
      z-index: 2;
    }

    .banner-content h1 {
      font-size: 3rem;
      /* Ukuran font besar untuk desktop */
      font-weight: 800;
      margin-bottom: 10px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .banner-content p {
      font-size: 1.3rem;
      font-weight: 300;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    /*
       RESPONSIF BANNER (AGAR RAPI DI HP/TABLET)
     */
    @media (max-width: 992px) {

      /* Tablet / Laptop Kecil */
      .header-banner {
        min-height: 400px;
        /* Sedikit lebih pendek dari desktop */
        background-position: center center;
      }

      .banner-content h1 {
        font-size: 2.2rem;
      }
    }

    @media (max-width: 768px) {

      /* HP Landscape / Tablet Kecil */
      .header-banner {
        min-height: 300px;
        background-position: center center;
      }

      .banner-overlay {
        padding: 30px;
        /* Padding dikecilkan */
      }

      .banner-content {
        width: 100%;
        /* Lebar konten dipenuhkan */
      }

      .banner-content h1 {
        font-size: 1.8rem;
      }

      .banner-content p {
        font-size: 1rem;
      }
    }

    @media (max-width: 576px) {

      /* HP Potrait (Layar Sempit) */
      .header-banner {
        min-height: 250px;
        /* Cukup pendek agar tidak memenuhi layar HP */
      }

      .banner-overlay {
        padding: 20px;
      }

      .banner-content h1 {
        font-size: 1.5rem;
      }

      .banner-content p {
        font-size: 0.85rem;
        margin-bottom: 10px;
      }

      /* Tombol belanja dikecilkan sedikit */
      .banner-content .btn {
        padding: 8px 16px;
        font-size: 0.9rem;
      }
    }

    /* Footer */
    .shopee-footer {
      background-color: #fbfbfb;
      border-top: 4px solid #0d6efd;
      padding-top: 50px;
      padding-bottom: 30px;
      font-size: 1rem;
      color: #333;
    }

    .shopee-footer h6 {
      font-weight: 800;
      text-transform: uppercase;
      margin-bottom: 25px;
      color: #000;
      font-size: 1rem;
      letter-spacing: 0.5px;
    }

    .shopee-footer ul li {
      margin-bottom: 10px;
    }

    .shopee-footer ul li a {
      color: rgba(0, 0, 0, 0.7);
      text-decoration: none;
      transition: color 0.2s;
      font-weight: 500;
      font-size: 0.95rem;
    }

    .shopee-footer ul li a:hover {
      color: #0d6efd;
    }

    .footer-payment-icons img,
    .footer-shipping-icons img {
      height: 30px;
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
      font-size: 1rem;
    }

    .footer-social-icon:hover {
      color: #000;
    }

    .footer-social-icon i {
      font-size: 1.4rem;
      margin-right: 10px;
    }

    .footer-download-qr {
      width: 80px;
      height: 80px;
      margin-right: 10px;
      border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .footer-download-apps img {
      width: 100px;
      height: auto;
      margin-bottom: 5px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 2px;
    }

    .footer-copyright {
      border-top: 1px solid rgba(0, 0, 0, 0.1);
      padding-top: 20px;
      margin-top: 40px;
      font-size: 0.9rem;
      color: rgba(0, 0, 0, 0.6);
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    /* Scroll Top Button */
    #scrollToTopBtn {
      display: none;
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 99;
      border: none;
      outline: none;
      background-color: #0d6efd;
      color: white;
      padding: 12px 15px;
      border-radius: 50%;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }

    /* Flash Sale Scroll */
    .fs-wrapper {
      position: relative;
    }

    .flash-sale-container {
      display: flex;
      overflow-x: auto;
      scroll-behavior: smooth;
      gap: 15px;
      padding: 10px 5px;
      -ms-overflow-style: none;
      /* IE and Edge */
      scrollbar-width: none;
      /* Firefox */
    }

    .flash-sale-container::-webkit-scrollbar {
      display: none;
      /* Chrome */
    }

    .fs-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 40px;
      height: 40px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 50%;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 10;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #0d6efd;
      transition: all 0.3s;
      opacity: 0.9;
    }

    .fs-btn:hover {
      background-color: #0d6efd;
      color: white;
      transform: translateY(-50%) scale(1.1);
    }

    .fs-btn-prev {
      left: -20px;
    }

    .fs-btn-next {
      right: -20px;
    }

    /* 
       MEDIA QUERIES (RESPONSIVE RULES)
    */

    /* TABLET & MOBILE (Max Width 992px) */
    @media (max-width: 992px) {
      .shopee-top-bar {
        display: none;
        /* Sembunyikan top bar di layar kecil agar tidak penuh */
      }

      .header-links {
        display: none;
        /* Sembunyikan link text di header */
      }

      .shopee-main-bar {
        padding: 15px 0;
      }

      .fs-btn {
        display: none;
        /* Tombol panah flash sale hilang di mobile  */
      }
    }

    /* TABLET (Max Width 768px) */
    @media (max-width: 768px) {

      /* Header Layout: Logo Kiri, Cart Kanan, Search Turun ke Bawah */
      .shopee-main-bar {
        flex-wrap: wrap;
        justify-content: space-between;
      }

      .shopee-brand {
        order: 1;
        flex-grow: 1;
        font-size: 1.4rem;
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

      /* Banner */
      .header-banner {
        min-height: 200px;
        border-radius: 10px;
      }

      .banner-content {
        width: 100%;
        text-align: center;
      }

      .banner-content h1 {
        font-size: 1.8rem;
      }

      .banner-content p {
        font-size: 1rem;
      }

      .banner-overlay {
        justify-content: center;
        align-items: center;
        padding: 20px;
      }

      /* Category Grid */
      .category-title {
        font-size: 0.8rem;
      }

      .category-icon-box {
        font-size: 1.5rem;
        margin-bottom: 5px;
      }

      .category-card {
        padding: 15px 5px;
        min-height: auto;
      }
    }

    /* MOBILE (Max Width 576px) */
    @media (max-width: 576px) {
      .shopee-header-wrapper {
        position: sticky;
        top: 0;
      }

      .shopee-brand svg {
        width: 50px;
        height: 50px;
      }

      .shopee-brand span {
        font-size: 1.2rem;
      }

      .header-banner {
        min-height: 180px;
        background-position: center;
      }

      .banner-content h1 {
        font-size: 1.4rem;
      }

      .banner-content p {
        font-size: 0.8rem;
        display: none;
        /* Sembunyikan deskripsi banner di HP sangat kecil */
      }

      .btn-lg {
        padding: 5px 15px;
        font-size: 0.9rem;
      }

      /* Flash Sale Header Stack */
      .schedule-bar {
        flex-direction: column;
        align-items: flex-start;
        padding: 15px;
        gap: 10px;
      }

      .schedule-bar .ms-auto {
        margin-left: 0 !important;
        width: 100%;
        text-align: right;
      }

      /* Produk Grid di Mobile (2 Kolom) */
      #product-container .col {
        padding: 3px !important;
        /* Jarak antar kartu diperkecil biar muat */
      }

      /* PEMERIKSAAN FOTO HILANG */
      #product-container img {
        display: block !important;
        /* Paksa gambar muncul */
        max-width: 100% !important;
        height: 150px !important;
        /* Paksa tinggi gambar agar terlihat */
        object-fit: contain !important;
        /* Gambar utuh tidak gepeng */
        margin: 0 auto;
      }

      #product-container .card {
        height: 100% !important;
        /* Kartu memanjang ke bawah sesuai isi */
        min-height: 280px;
        /* Tinggi minimal kartu */
      }

      .card-body {
        padding: 10px;
      }

      .card-title {
        font-size: 0.85rem;
      }

      .text-primary {
        font-size: 0.95rem;
      }

      /* Footer Stack */
      .footer-copyright {
        flex-direction: column;
        text-align: center;
        gap: 10px;
      }
    }
  </style>
</head>

<body>

  <header class="shopee-header-wrapper">
    <div class="container-fluid px-3">

      <div class="shopee-top-bar">
        <div class="d-flex align-items-center">
          <a href="#" data-i18n="seller">Seller Centre</a>
          <a href="#" data-i18n="selling">Mulai Berjualan</a>
          <a href="#" data-i18n="download">Download</a>
          <span class="ms-2 me-2 text-white opacity-75" data-i18n="follow">Ikuti kami di</span>
          <a href="https://www.facebook.com/univ.diannswantoro" target="_blank" style="border:none"><i class="bi bi-facebook fs-5"></i></a>
          <a href="https://www.instagram.com/udinus_smg" target="_blank" style="border:none"><i class="bi bi-instagram fs-5"></i></a>
        </div>
        <div class="d-flex align-items-center">
          <a href="#"><i class="bi bi-bell"></i> <span data-i18n="notif">Notifikasi</span></a>
          <a href="#"><i class="bi bi-question-circle"></i> <span data-i18n="help">Bantuan</span></a>
          <div class="dropdown d-inline">
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border:none; color:rgba(255,255,255,0.95); text-decoration: none;" id="current-lang-display"><i class="bi bi-globe me-1"></i> Bahasa Indonesia</a>
            <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
              <li><a class="dropdown-item custom-dropdown-item active-lang" onclick="changeLanguage('id')" id="lang-id"><span>Bahasa Indonesia</span></a></li>
              <li><a class="dropdown-item custom-dropdown-item" onclick="changeLanguage('en')" id="lang-en"><span>English</span></a></li>
            </ul>
          </div>
          <a href="#" class="fw-bold ms-4" data-i18n="register">Daftar</a>
          <a href="login.php" class="fw-bold" style="border:none" data-i18n="login">Log In</a>
        </div>
      </div>

      <div class="shopee-main-bar">
        <a class="shopee-brand" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="70" height="70" class="me-3">
            <path d="M35 80 L10 80 L45 10 L55 10 Z" fill="#ffffff" stroke="#ddd" stroke-width="1" />
            <path d="M65 80 L90 80 L55 10 L45 10 Z" fill="#f0f0f0" stroke="#ddd" stroke-width="1" />
            <path d="M25 60 L75 60 L75 75 L25 75 Z" fill="#00bfff" />
            <path d="M20 60 L80 60" stroke="#0d6efd" stroke-width="2" />
          </svg>
          <span class="text-white">Aureon Tech</span>
        </a>

        <div class="search-wrapper-rel">
          <form action="result.php" method="GET" class="shopee-search-box">
            <input type="text" name="keyword" class="shopee-search-input" placeholder="Cari gadget impianmu disini..." id="search-input" autocomplete="off">
            <button type="submit" class="shopee-search-btn">
              <i class="bi bi-search"></i>
            </button>
            <div class="search-suggestions" id="suggestions-box"></div>
          </form>

          <div class="header-links">
            <a href="#">Laptop Gaming</a> <a href="#">iPhone 15</a> <a href="#">Headset Bluetooth</a> <a href="#">Keyboard Mekanik</a> <a href="#">Smart TV</a>
          </div>
        </div>
        <div class="shopee-cart">
          <i class="bi bi-cart3"></i>
          <span class="cart-badge">3</span>
        </div>
      </div>
    </div>
  </header>

  <header class="container-fluid bg-white py-4 px-3" data-aos="zoom-in">
    <div class="container-fluid px-0">
      <div id="date-time-display" class="text-center mb-4"></div>

      <div class="header-banner shadow-lg">
        <div class="banner-overlay">
          <div class="banner-content" data-aos="fade-right" data-aos-delay="300">
            <h1 class="display-3 fw-bold" data-i18n="promo_title">PROMO GAJIAN!</h1>
            <p class="lead" data-i18n="promo_desc">DISKON HINGGA 50% UNTUK SEMUA GADGET</p>
            <a href="#produk" class="btn btn-light btn-lg mt-3 text-primary fw-bold" data-i18n="shop_now">
              <i class="bi bi-cart-fill"></i> Belanja Sekarang
            </a>
          </div>
        </div>
      </div>

      <div class="container-fluid px-1 mt-4 mb-4" data-aos="fade-up">
        <div class="d-flex align-items-center mb-2 px-2">
          <h6 class="fw-bold text-secondary mb-0" style="letter-spacing: 1px; font-size: 0.9rem;" data-i18n="explore_cat">KATEGORI PILIHAN</h6>
          <div class="flex-grow-1 ms-3 bg-light" style="height: 1px;"></div>
        </div>
        <div class="row g-2 justify-content-center">
          <div class="col-4 col-md-2" data-aos="zoom-in" data-aos-delay="50"><a href="#" class="category-card"><i class="bi bi-phone category-icon-box"></i><span class="category-title" data-i18n="hp">Handphone</span></a></div>
          <div class="col-4 col-md-2" data-aos="zoom-in" data-aos-delay="100"><a href="#" class="category-card"><i class="bi bi-laptop category-icon-box"></i><span class="category-title" data-i18n="laptop">Laptop</span></a></div>
          <div class="col-4 col-md-2" data-aos="zoom-in" data-aos-delay="150"><a href="#" class="category-card"><i class="bi bi-smartwatch category-icon-box"></i><span class="category-title" data-i18n="watch">Smartwatch</span></a></div>
          <div class="col-4 col-md-2" data-aos="zoom-in" data-aos-delay="200"><a href="#" class="category-card"><i class="bi bi-headphones category-icon-box"></i><span class="category-title" data-i18n="audio">Audio</span></a></div>
          <div class="col-4 col-md-2" data-aos="zoom-in" data-aos-delay="250"><a href="#" class="category-card"><i class="bi bi-camera category-icon-box"></i><span class="category-title" data-i18n="camera">Kamera</span></a></div>
          <div class="col-4 col-md-2" data-aos="zoom-in" data-aos-delay="300"><a href="#" class="category-card"><i class="bi bi-mouse category-icon-box"></i><span class="category-title" data-i18n="accessories">Aksesoris</span></a></div>
        </div>
      </div>

      <div class="schedule-bar shadow-sm mt-5" data-aos="fade-up">
        <div class="d-flex align-items-center me-4">
          <h3 class="mb-0 fw-bold fst-italic text-primary" data-i18n="flash_sale">FLASH SALE</h3>
          <i class="bi bi-lightning-fill text-warning fs-2 ms-2"></i>
        </div>
        <div class="d-flex align-items-center"><span class="me-3 fw-bold text-muted" style="font-size: 1.1rem;" data-i18n="ends_in">BERAKHIR DALAM</span><span class="timer-digit" id="hours">02</span> <span class="mx-1 fw-bold fs-5">:</span><span class="timer-digit" id="minutes">15</span> <span class="mx-1 fw-bold fs-5">:</span><span class="timer-digit" id="seconds">40</span></div>
        <div class="ms-auto"><a href="#" class="text-primary text-decoration-none fw-bold fs-5" data-i18n="view_all">Lihat Semua ></a></div>
      </div>

      <div class="container-fluid px-4 mt-3" data-aos="fade-up" data-aos-delay="100">
        <div class="fs-wrapper">
          <button class="fs-btn fs-btn-prev" id="scrollLeftBtn"><i class="bi bi-chevron-left fs-5"></i></button>
          <div class="flash-sale-container" id="flashSaleList">
            <?php
            $queryFS = "SELECT * FROM produk ORDER BY RAND() LIMIT 10";
            $resultFS = mysqli_query($conn, $queryFS);
            if (mysqli_num_rows($resultFS) > 0) {
              while ($rowFS = mysqli_fetch_assoc($resultFS)) {
                $harga_asli_angka = $rowFS['harga'] * 1.2;
                $harga_final = "Rp " . number_format($rowFS['harga'], 0, ',', '.');
                $harga_coret = "Rp " . number_format($harga_asli_angka, 0, ',', '.');
                $persen_terjual = rand(60, 95);
            ?>
                <div style="min-width: 190px; max-width: 190px;">
                  <div class="card h-100 border-0 shadow-sm position-relative">
                    <div class="position-absolute top-0 end-0 bg-warning text-dark fw-bold px-2 py-1 small m-2 rounded" style="font-size: 0.7rem; z-index: 2;"><i class="bi bi-lightning-fill text-danger"></i> -20%</div>
                    <div class="bg-white p-2 d-flex align-items-center justify-content-center" style="height: 160px; overflow: hidden;"><img src="<?php echo $rowFS['gambar']; ?>" class="img-fluid" alt="<?php echo $rowFS['nama_produk']; ?>" style="max-height: 100%; object-fit: contain;"></div>
                    <div class="card-body p-2 d-flex flex-column text-center">
                      <h6 class="text-truncate mb-1" style="font-size: 0.9rem;"><?php echo $rowFS['nama_produk']; ?></h6>
                      <div class="text-decoration-line-through text-muted small" style="font-size: 0.75rem;"><?php echo $harga_coret; ?></div>
                      <div class="text-danger fw-bold fs-6 mb-2"><?php echo $harga_final; ?></div>
                      <div class="position-relative w-100 mb-2">
                        <div class="progress" style="height: 14px; border-radius: 10px; background-color: #ffeca0;">
                          <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $persen_terjual; ?>%"></div>
                        </div>
                        <div class="position-absolute top-0 start-50 translate-middle-x text-white fw-bold small" style="font-size: 0.6rem; line-height: 14px;">TERJUAL <?php echo $persen_terjual; ?>%</div>
                      </div>
                      <a href="#" class="btn btn-primary btn-sm w-100 mt-auto fw-bold" style="font-size: 0.8rem;"><i class="bi bi-cart-plus-fill me-1"></i> Beli</a>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>
          </div>
          <button class="fs-btn fs-btn-next" id="scrollRightBtn"><i class="bi bi-chevron-right fs-5"></i></button>
        </div>
      </div>
    </div>
  </header>

  <main id="produk" class="container-fluid my-5 px-4">
    <div class="row text-center mb-4" data-aos="fade-up">
      <div class="col">
        <h2 data-i18n="popular_title">Rekomendasi</h2>
        <p data-i18n="popular_desc">Coba menu pilihan kami</p>
      </div>
    </div>
    <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-5 justify-content-center" id="product-container">
      <?php
      $query = "SELECT * FROM produk ORDER BY id DESC";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $harga = "Rp " . number_format($row['harga'], 0, ',', '.');
      ?>
          <div class="col" data-aos="fade-up">
            <div class="card h-100 shadow-sm border-0">
              <div style="height: 200px; overflow: hidden;" class="d-flex align-items-center justify-content-center bg-white p-2">
                <img src="<?php echo $row['gambar']; ?>" class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
              </div>
              <div class="card-body d-flex flex-column p-2">
                <h6 class="card-title fw-bold text-truncate" style="font-size: 0.95rem;"><?php echo $row['nama_produk']; ?></h6>
                <p class="card-text text-muted small mb-1"><?php echo substr($row['deskripsi'], 0, 30); ?>...</p>
                <h6 class="text-primary fw-bold mb-2"><?php echo $harga; ?></h6>
                <a href="#" class="btn btn-sm btn-outline-primary mt-auto"><i class="bi bi-cart-plus"></i> Beli</a>
              </div>
            </div>
          </div>
      <?php }
      } else {
        echo '<div class="col-12 text-center py-5 text-muted">Belum ada produk yang diupload.</div>';
      } ?>
    </div>
  </main>

  <section id="layanan" class="container-fluid my-5 px-5" data-aos="fade-up">
    <div class="row text-center mb-4">
      <div class="col">
        <h2 data-i18n="services_title">Layanan & Keunggulan Kami</h2>
        <p data-i18n="services_desc">Mengapa Anda harus berbelanja di Aureon Tech.</p>
      </div>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-12 col-sm-6 col-lg-4 col-xl-3" data-aos="flip-left">
        <div class="card h-100 shadow-sm border-0 text-center p-3">
          <div class="card-body"><i class="bi bi-patch-check feature-icon"></i>
            <h5 class="card-title mt-3" data-i18n="original">Produk 100% Original</h5>
            <p class="card-text text-muted" data-i18n="original_desc">Kami menjamin semua produk yang kami jual adalah asli.</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 col-xl-3" data-aos="flip-left">
        <div class="card h-100 shadow-sm border-0 text-center p-3">
          <div class="card-body"><i class="bi bi-shield-lock feature-icon"></i>
            <h5 class="card-title mt-3" data-i18n="warranty">Garansi Resmi</h5>
            <p class="card-text text-muted" data-i18n="warranty_desc">Perlindungan garansi resmi dari setiap produsen ternama.</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 col-xl-3" data-aos="flip-left">
        <div class="card h-100 shadow-sm border-0 text-center p-3">
          <div class="card-body"><i class="bi bi-truck feature-icon"></i>
            <h5 class="card-title mt-3" data-i18n="shipping">Pengiriman Cepat</h5>
            <p class="card-text text-muted" data-i18n="shipping_desc">Pesanan Anda akan kami proses dan kirim di hari yang sama.</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 col-xl-3" data-aos="flip-left">
        <div class="card h-100 shadow-sm border-0 text-center p-3">
          <div class="card-body"><i class="bi bi-headset feature-icon"></i>
            <h5 class="card-title mt-3" data-i18n="support">Layanan 24/7</h5>
            <p class="card-text text-muted" data-i18n="support_desc">Tim kami siap membantu Anda kapanpun Anda membutuhkannya.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="tentang-kami" class="bg-light py-5 container-fluid" data-aos="fade-up">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="text-center mb-4">
            <h2 data-i18n="about_title">Tentang Aureon Tech</h2>
            <p data-i18n="about_desc">Kenali lebih jauh tentang siapa kami dan apa yang kami lakukan.</p>
          </div>
          <div class="accordion" id="accordionTentangKami">
            <div class="accordion-item">
              <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"><strong data-i18n="who_we_are">Siapa Kami?</strong></button></h2>
              <div id="collapseOne" class="accordion-collapse collapse show">
                <div class="accordion-body"><strong>Aureon Tech</strong> adalah pelopor toko online gadget dan aksesoris di Indonesia. Didirikan sejak tahun 2020.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"><strong data-i18n="vision">Visi & Misi Kami</strong></button></h2>
              <div id="collapseTwo" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <p><strong>Visi:</strong> Menjadi platform e-commerce teknologi nomor satu.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"><strong>FAQ</strong></button></h2>
              <div id="collapseThree" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <p><strong>Q: Apakah produknya aman?</strong><br />A: Ya, semua produk kami bergaransi.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="shopee-footer">
    <div class="container-fluid px-3">
      <div class="row">
        <div class="col-md-3 col-sm-6">
          <h6 data-i18n="footer_cs">LAYANAN PELANGGAN</h6>
          <ul class="list-unstyled">
            <li><a href="#" data-i18n="help">Bantuan</a></li>
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
          <h6 data-i18n="footer_explore">JELAJAHI AUREON</h6>
          <ul class="list-unstyled">
            <li><a href="#" data-i18n="about_title">Tentang Kami</a></li>
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
          <div class="d-flex flex-wrap footer-payment-icons mb-4"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA"><img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri"><img src="https://images.seeklogo.com/logo-png/35/2/bank-bni-logo-png_seeklogo-355606.png" alt="BNI"><img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg" alt="BRI"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa"><img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard"><img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GoPay"><img src="https://pbs.twimg.com/media/EUbePLEU0AIpder.jpg" alt="OVO"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Logo_Indomaret.png/1280px-Logo_Indomaret.png" alt="Indomaret"><img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Alfamart_logo.svg" alt="Alfamart"></div>
          <h6>PENGIRIMAN</h6>
          <div class="d-flex flex-wrap footer-shipping-icons"><img src="https://upload.wikimedia.org/wikipedia/commons/9/92/New_Logo_JNE.png" alt="JNE"><img src="https://i.pinimg.com/736x/72/23/3c/72233c7d51fe3ffde3cb3c345a7f7731.jpg" alt="J&T"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwtAQ3uug50276mHy9MJE8yiJWHCbKQEcI0A&s" alt="SiCepat"><img src="https://upload.wikimedia.org/wikipedia/commons/f/f6/Grab_Logo.svg" alt="Grab"><img src="https://everpro.id/wp-content/uploads/2022/09/gosend1.jpg" alt="GoSend"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRQhCp4Szj86kC2pS5pIJJk8PxhzQhqzhjFbQ&s" alt="Pos Indonesia"></div>
        </div>
        <div class="col-md-3 col-sm-6">
          <h6 data-i18n="follow">IKUTI KAMI</h6>
          <div class="mb-4"><a href="https://www.facebook.com/univ.diannswantoro" target="_blank" class="footer-social-icon"><i class="bi bi-facebook"></i> Facebook</a><a href="https://www.instagram.com/udinus_smg" target="_blank" class="footer-social-icon"><i class="bi bi-instagram"></i> Instagram</a><a href="https://twitter.com/udinus_smg" target="_blank" class="footer-social-icon"><i class="bi bi-twitter"></i> Twitter</a><a href="https://www.linkedin.com/school/universitas-dian-nuswantoro" target="_blank" class="footer-social-icon"><i class="bi bi-linkedin"></i> LinkedIn</a></div>
          <h6>DOWNLOAD APLIKASI AUREON</h6>
          <div class="d-flex align-items-center"><img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QR Code" class="footer-download-qr bg-white p-1">
            <div class="footer-download-apps d-flex flex-column"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Play Store"><img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store"><img src="https://img.freepik.com/vektor-premium/sebuah-logo-hitam-putih-dengan-segitiga-biru-di-bagian-bawah_853558-1949.jpg" alt="App Gallery"></div>
          </div>
        </div>
      </div>
      <div class="footer-copyright d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="mb-2 mb-md-0" data-i18n="rights">&copy; 2025 AureonTech. Hak Cipta Dilindungi.</div>
        <div class="small">Negara: <a href="#" class="text-muted text-decoration-none">Indonesia</a> | <a href="#" class="text-muted text-decoration-none">Singapura</a> | <a href="#" class="text-muted text-decoration-none">Malaysia</a></div>
      </div>
    </div>
  </footer>

  <button onclick="topFunction()" id="scrollToTopBtn" title="Kembali ke Atas"><i class="bi bi-arrow-up"></i></button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script>
    // JS MODIFIKASI: LIVE SEARCH AJAX
    $(document).ready(function() {
      // 1. Saat mengetik
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

      // 2. Klik item saran -> Isi input & Submit Form
      $(document).on('click', '.suggestion-item', function() {
        var text = $(this).data('name');
        $('#search-input').val(text);
        $('#suggestions-box').fadeOut();
        // Submit form agar pindah ke result.php
        $('form.shopee-search-box').submit();
      });

      // 3. Klik di luar menutup dropdown
      $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-wrapper-rel').length) {
          $('#suggestions-box').fadeOut();
        }
      });
    });

    AOS.init({
      duration: 800,
      once: true
    });

    // KAMUS BAHASA
    const translations = {
      id: {
        seller: "Seller Centre",
        selling: "Mulai Berjualan",
        download: "Download",
        follow: "Ikuti kami di",
        notif: "Notifikasi",
        help: "Bantuan",
        register: "Daftar",
        login: "Log In",
        search_placeholder: "Cari gadget impianmu disini...",
        promo_title: "PROMO GAJIAN!",
        promo_desc: "DISKON HINGGA 50% UNTUK SEMUA GADGET",
        shop_now: "Belanja Sekarang",
        flash_sale: "FLASH SALE",
        ends_in: "BERAKHIR DALAM",
        view_all: "Lihat Semua >",
        explore_cat: "KATEGORI PILIHAN",
        hp: "Handphone",
        laptop: "Laptop",
        watch: "Smartwatch",
        audio: "Audio",
        camera: "Kamera",
        accessories: "Aksesoris",
        popular_title: "Rekomendasi",
        popular_desc: "Coba menu pilihan kami",
        add_cart: "Tambah ke Keranjang",
        services_title: "Layanan & Keunggulan Kami",
        services_desc: "Mengapa Anda harus berbelanja di Aureon Tech.",
        original: "Produk 100% Original",
        original_desc: "Kami menjamin semua produk yang kami jual adalah asli.",
        warranty: "Garansi Resmi",
        warranty_desc: "Perlindungan garansi resmi dari setiap produsen ternama.",
        shipping: "Pengiriman Cepat",
        shipping_desc: "Pesanan Anda akan kami proses dan kirim di hari yang sama.",
        support: "Layanan 24/7",
        support_desc: "Tim kami siap membantu Anda kapanpun Anda membutuhkannya.",
        footer_cs: "LAYANAN PELANGGAN",
        footer_explore: "JELAJAHI AUREON",
        about_title: "Tentang Kami",
        rights: "© 2025 AureonTech. Hak Cipta Dilindungi.",
        who_we_are: "Siapa Kami?",
        vision: "Visi & Misi Kami"
      },
      en: {
        seller: "Seller Centre",
        selling: "Start Selling",
        download: "Download",
        follow: "Follow us on",
        notif: "Notifications",
        help: "Help",
        register: "Sign Up",
        login: "Log In",
        search_placeholder: "Search for your dream gadget here...",
        promo_title: "PAYDAY PROMO!",
        promo_desc: "UP TO 50% OFF ON ALL GADGETS",
        shop_now: "Shop Now",
        flash_sale: "FLASH SALE",
        ends_in: "ENDS IN",
        view_all: "View All >",
        explore_cat: "EXPLORE CATEGORIES",
        hp: "Mobile Phone",
        laptop: "Laptop",
        watch: "Smartwatch",
        audio: "Audio",
        camera: "Camera",
        accessories: "Accessories",
        popular_title: "Recommendation",
        popular_desc: "Try our curated selection",
        add_cart: "Add to Cart",
        services_title: "Our Services & Advantages",
        services_desc: "Why you should shop at Aureon Tech.",
        original: "100% Original Products",
        original_desc: "We guarantee all products we sell are authentic.",
        warranty: "Official Warranty",
        warranty_desc: "Get official warranty protection from top manufacturers.",
        shipping: "Fast Shipping",
        shipping_desc: "Your order will be processed and shipped on the same day.",
        support: "24/7 Support",
        support_desc: "Our team is ready to help you whenever you need it.",
        footer_cs: "CUSTOMER SERVICE",
        footer_explore: "EXPLORE AUREON",
        about_title: "About Us",
        rights: "© 2025 AureonTech. All Rights Reserved.",
        who_we_are: "Who We Are?",
        vision: "Our Vision & Mission"
      }
    };

    function changeLanguage(lang) {
      document.querySelectorAll("[data-i18n]").forEach(el => {
        const key = el.getAttribute("data-i18n");
        if (translations[lang][key]) el.textContent = translations[lang][key];
      });
      document.getElementById("search-input").placeholder = translations[lang].search_placeholder;
      const currentLabel = document.getElementById("current-lang-display");
      const itemID = document.getElementById("lang-id");
      const itemEN = document.getElementById("lang-en");
      const checkID = document.getElementById("check-id");
      const checkEN = document.getElementById("check-en");

      if (lang === 'id') {
        currentLabel.innerHTML = '<i class="bi bi-globe me-1"></i> Bahasa Indonesia';
        itemID.classList.add("active-lang");
        itemEN.classList.remove("active-lang");
        checkID.classList.remove("d-none");
        checkEN.classList.add("d-none");
      } else {
        currentLabel.innerHTML = '<i class="bi bi-globe me-1"></i> English';
        itemEN.classList.add("active-lang");
        itemID.classList.remove("active-lang");
        checkEN.classList.remove("d-none");
        checkID.classList.add("d-none");
      }
    }

    const hoursEl = document.getElementById('hours'),
      minutesEl = document.getElementById('minutes'),
      secondsEl = document.getElementById('seconds');

    function updateTimer() {
      let h = parseInt(hoursEl.innerText),
        m = parseInt(minutesEl.innerText),
        s = parseInt(secondsEl.innerText);
      s--;
      if (s < 0) {
        s = 59;
        m--;
      }
      if (m < 0) {
        m = 59;
        h--;
      }
      if (h < 0) {
        h = 23;
      }
      hoursEl.innerText = h < 10 ? '0' + h : h;
      minutesEl.innerText = m < 10 ? '0' + m : m;
      secondsEl.innerText = s < 10 ? '0' + s : s;
    }
    setInterval(updateTimer, 1000);

    function updateDateTime() {
      const now = new Date();
      const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      };
      const dateTimeDisplay = document.getElementById("date-time-display");
      if (dateTimeDisplay) {
        dateTimeDisplay.innerHTML = `<p class="fw-bold mb-0 small text-white opacity-75"><i class="bi bi-calendar"></i> ${now.toLocaleDateString("id-ID", options)} | <i class="bi bi-clock"></i> ${now.toLocaleTimeString("id-ID")}</p>`;
      }
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

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

    const fsContainer = document.getElementById('flashSaleList');
    const btnLeft = document.getElementById('scrollLeftBtn');
    const btnRight = document.getElementById('scrollRightBtn');
    btnRight.addEventListener('click', () => {
      fsContainer.scrollBy({
        left: 250,
        behavior: 'smooth'
      });
    });
    btnLeft.addEventListener('click', () => {
      fsContainer.scrollBy({
        left: -250,
        behavior: 'smooth'
      });
    });
  </script>
</body>

</html>