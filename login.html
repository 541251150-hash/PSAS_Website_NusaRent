<?php
// Memulai session
session_start();

// 1. MENGHUBUNGKAN KE FILE KONEKSI BUATAN TEMANMU
require 'koneksi.php';

// Variabel untuk menampung pesan notifikasi
$notif_pesan = "";
$notif_tipe = ""; 

// 2. LOGIKA KETIKA TOMBOL LOGIN DITEKAN
if (isset($_POST['btn_login'])) {
    // Mengambil data dari form login
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Perintah SQL untuk mencari user berdasarkan email
    $query_cek = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if(mysqli_num_rows($query_cek) > 0) {
        // Membaca data user dari database
        $data_user = mysqli_fetch_assoc($query_cek);
        
        // Mencocokkan password inputan dengan password di database
        // Asumsi: temanmu di register.php menggunakan password_hash()
        if(password_verify($password, $data_user['password'])) {
            
            // Menyimpan identitas di Session
            $_SESSION['id_user'] = $data_user['id'];
            $_SESSION['nama_lengkap'] = $data_user['nama_lengkap'];
            
            // Pindah ke halaman beranda
            header("Location: beranda.php");
            exit();
            
        } else {
            $notif_pesan = "Kata Sandi yang Anda masukkan salah!";
            $notif_tipe = "gagal";
        }
    } else {
        $notif_pesan = "Email tidak ditemukan! Silakan daftar akun terlebih dahulu.";
        $notif_tipe = "gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NusaRent - Masuk</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- 3. MENGHUBUNGKAN KE FILE CSS KITA -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="h-screen w-full flex items-center justify-center bg-gray-100 relative">

    <!-- Notifikasi PHP jika ada pesan error -->
    <?php if ($notif_pesan != ""): ?>
        <?php 
            $bg_color = ($notif_tipe == 'sukses') ? 'bg-slate-800 border-blue-500' : 'bg-red-500 border-red-800'; 
            $icon_color = ($notif_tipe == 'sukses') ? 'text-blue-400' : 'text-white';
        ?>
        <div class="fade-out-anim fixed top-5 right-5 <?php echo $bg_color; ?> text-white px-6 py-4 rounded-lg shadow-xl z-50 border-l-4 flex items-center gap-3">
            <svg class="w-6 h-6 <?php echo $icon_color; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <h4 class="font-semibold"><?php echo $notif_tipe == 'sukses' ? 'Berhasil!' : 'Gagal Masuk!'; ?></h4>
                <p class="text-sm text-gray-100"><?php echo $notif_pesan; ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Card Container -->
    <div class="flex w-full max-w-5xl h-[600px] bg-white rounded-2xl shadow-2xl overflow-hidden m-4">
        
        <!-- Left Side: Image & Branding -->
        <div class="hidden md:flex w-1/2 bg-image relative">
            <div class="absolute inset-0 overlay flex flex-col justify-center px-12 text-white">
                <h1 class="text-5xl font-bold mb-6 tracking-tight">NusaRent<span class="text-blue-500">.</span></h1>
                <h2 class="text-2xl font-semibold mb-4 leading-tight">Jelajahi Kota Tanpa Batas.</h2>
                <p class="text-base text-gray-300 font-light leading-relaxed">
                    Mobilitas masa depan ada di genggaman Anda. Nikmati pengalaman sewa kendaraan premium yang mulus, efisien, dan dirancang khusus untuk gaya hidup urban Anda.
                </p>
            </div>
        </div>

        <!-- Right Side: Forms -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 lg:p-14">
            
            <div class="w-full">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang Kembali!</h2>
                    <p class="text-gray-500 mt-2">Masuk untuk melanjutkan perjalanan Anda</p>
                </div>

                <form method="POST" action="">
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="anda@email.com" required>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-gray-700 text-sm font-semibold" for="password">Kata Sandi</label>
                            <a href="#" class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">Lupa Kata Sandi?</a>
                        </div>
                        <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="••••••••" required>
                    </div>

                    <button type="submit" name="btn_login" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg">
                        Masuk
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-8">
                    Belum bergabung dengan NusaRent? 
                    <!-- 4. PENTING: MENGARAHKAN KE FILE REGISTER.PHP BUATAN TEMANMU -->
                    <a href="register.php" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">Daftar sekarang</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>