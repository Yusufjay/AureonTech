<?php
session_start();
include "koneksi.php";

if (isset($_SESSION['username'])) {
    header("location:admin.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = md5($_POST['pass']);

    // Cek tabel users atau user (antisipasi nama tabel)
    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
    }

    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['username'];
            header("location:admin.php");
            exit;
        } else {
            $error = "Username atau Password Salah";
        }
        $stmt->close();
    } else {
        $error = "Terjadi kesalahan database.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Aureon Tech</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230d6efd'/><path d='M35 80 L10 80 L45 10 L55 10 Z' fill='%23ffffff'/><path d='M65 80 L90 80 L55 10 L45 10 Z' fill='%23f0f0f0'/><path d='M25 60 L75 60 L75 75 L25 75 Z' fill='%2300bfff'/></svg>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { background-color: #f8f9fa; overflow-x: hidden; font-family: sans-serif; }
        
        /* HEADER */
        .login-header {
            background: #fff; padding: 15px 5%; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            display: flex; align-items: center; justify-content: space-between;
        }
        .brand-logo { display: flex; align-items: center; text-decoration: none; color: #333; }
        .brand-text { font-size: 1.5rem; font-weight: 700; color: #0d6efd; margin-left: 10px; }
        .login-title { font-size: 1.2rem; color: #333; margin-left: 15px; padding-left: 15px; border-left: 2px solid #ddd; }

        /* HERO SECTION */
        .login-wrapper {
            background: #0d6efd; padding: 50px 20px; min-height: 80vh;
            display: flex; align-items: center; justify-content: center;
        }
        .login-container {
            max-width: 1100px; width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 50px;
        }
        .hero-content { color: white; text-align: center; flex: 1; }
        .hero-logo svg { width: 250px; height: 250px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2)); max-width: 100%; }
        .hero-slogan { font-size: 2.5rem; font-weight: 700; margin-top: 20px; }
        .hero-subtext { font-size: 1.2rem; opacity: 0.9; }

        /* LOGIN BOX */
        .login-box {
            background: white; 
            /* Perubahan Responsif:  */
            width: 100%; 
            max-width: 420px; 
            padding: 40px; border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
        }
        .btn-login {
            background: #0d6efd; color: white; border: none; padding: 12px; width: 100%;
            font-weight: 700; border-radius: 6px; margin-top: 10px; transition: 0.3s;
        }
        .btn-login:hover { background: #0b5ed7; transform: translateY(-2px); }

        /* FOOTER  */
        .shopee-footer { background-color: #fbfbfb; border-top: 4px solid #0d6efd; padding: 40px 0; }
        .shopee-footer h6 { font-weight: 800; font-size: 0.9rem; margin-bottom: 20px; }
        .shopee-footer a { text-decoration: none; color: rgba(0,0,0,0.6); font-size: 0.9rem; }
        .shopee-footer img { max-height: 30px; margin: 0 5px 5px 0; border: 1px solid #ddd; padding: 2px; background: #fff; border-radius: 3px; }

        /* --- RESPONSIVE CSS  --- */
        @media (max-width: 992px) {
            .login-container { 
                flex-direction: column; /* Stack logo dan form ke bawah */
                text-align: center; 
                gap: 30px;
            }
            .hero-content { margin-bottom: 20px; padding-right: 0; }
            .hero-logo svg { width: 150px; height: 150px; }
            .hero-slogan { font-size: 2rem; }
            
            /* Agar login box tidak terlalu lebar di tablet tapi pas di HP */
            .login-box { padding: 30px; margin: 0 auto; }
        }

        @media (max-width: 576px) {
            /* Penyesuaian Header HP */
            .login-header { padding: 15px; }
            .brand-text { font-size: 1.1rem; }
            .login-title { font-size: 1rem; margin-left: 10px; padding-left: 10px; }
            
            /* Penyesuaian Hero HP */
            .hero-slogan { font-size: 1.5rem; }
            .hero-subtext { font-size: 1rem; }
            .hero-logo svg { width: 100px; height: 100px; }
            
            /* Penyesuaian Login Box HP */
            .login-box { padding: 25px; }
        }
    </style>
</head>
<body>

<header class="login-header">
    <a href="index.php" class="brand-logo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40">
            <path d="M35 80 L10 80 L45 10 L55 10 Z" fill="#0d6efd"/>
            <path d="M65 80 L90 80 L55 10 L45 10 Z" fill="#0b5ed7"/>
            <path d="M25 60 L75 60 L75 75 L25 75 Z" fill="#00bfff"/>
        </svg>
        <span class="brand-text">Aureon Tech</span>
        <span class="login-title">Log In</span>
    </a>
    <a href="#" class="text-primary fw-bold text-decoration-none">Bantuan?</a>
</header>

<div class="login-wrapper">
    <div class="login-container">
        <div class="hero-content">
            <div class="hero-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <path d="M35 80 L10 80 L45 10 L55 10 Z" fill="#ffffff"/>
                    <path d="M65 80 L90 80 L55 10 L45 10 Z" fill="#e0e0e0"/>
                    <path d="M25 60 L75 60 L75 75 L25 75 Z" fill="#87cefa"/>
                </svg>
            </div>
            <div class="hero-slogan">Aureon Tech</div>
            <div class="hero-subtext">Smart Tech, Smart Life</div>
        </div>

        <div class="login-box">
            <h4 class="fw-bold mb-4 text-dark">Log In</h4>
            <?php if ($error): ?>
                <div class="alert alert-danger py-2 small"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="user" class="form-control p-3" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="pass" class="form-control p-3" placeholder="Password" required>
                </div>
                <button type="submit" class="btn-login">LOG IN</button>
                
                <div class="d-flex justify-content-between mt-3 small">
                    <a href="#" class="text-primary">Lupa Password</a>
                    <a href="#" class="text-primary">Login SMS</a>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="shopee-footer py-4">
    <div class="container text-center">
        <div class="mb-3">
            <span class="text-muted small mx-2">&copy; 2025 Aureon Tech</span>
            <a href="#" class="small mx-2">Kebijakan Privasi</a>
            <a href="#" class="small mx-2">Syarat & Ketentuan</a>
        </div>
    </div>
</footer>

</body>
</html>