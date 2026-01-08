<?php
include 'koneksi.php';

if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    // Cari 5 produk yang mirip
    $query = "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' LIMIT 5";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="suggestion-item" onclick="selectSuggestion(\'' . $row['nama_produk'] . '\')">
                    <div class="d-flex align-items-center">
                        <img src="' . $row['gambar'] . '" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px; border-radius: 4px;">
                        <span style="font-size: 0.9rem; color: #333;">' . $row['nama_produk'] . '</span>
                    </div>
                  </div>';
        }
    } else {
        echo '<div class="p-2 text-muted small ms-2">Produk tidak ditemukan</div>';
    }
}
