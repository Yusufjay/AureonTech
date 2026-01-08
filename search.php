<?php
include 'koneksi.php';

// Ambil keyword dari AJAX
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Query pencarian menggunakan LIKE
$query = "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Format Rupiah
        $harga = "Rp " . number_format($row['harga'], 0, ',', '.');

        // Output HTML sesuai struktur card di index.php
        echo '
        <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up">
            <div class="card h-100 shadow-sm border-0">
                <img src="' . $row['gambar'] . '" class="card-img-top" alt="' . $row['nama_produk'] . '" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">' . $row['nama_produk'] . '</h5>
                    <p class="card-text text-muted">' . $row['deskripsi'] . '</p>
                    <h6 class="text-primary fs-5 fw-bold mb-3">' . $harga . '</h6>
                    <a href="#" class="btn btn-outline-primary mt-auto"> 
                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang 
                    </a>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<div class="col-12 text-center"><p class="text-muted">Produk tidak ditemukan.</p></div>';
}
