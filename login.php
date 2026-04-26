<?php
// Memulai session (akan berguna untuk menyimpan status login nanti)
session_start();

// Variabel untuk menampung pesan notifikasi
$notif_pesan = "";
$notif_tipe = ""; 

// Mengecek apakah ada data form yang dikirim dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ==========================================
    // LOGIKA KETIKA TOMBOL REGISTER DITEKAN
    // ==========================================
    if (isset($_POST['btn_register'])) {
        // Mengambil data dari form register
        $nama = $_POST['nama_lengkap'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // TODO (Minggu depan): Kode INSERT INTO users ke database akan ditaruh di sini
        
        // Simulasi notifikasi berhasil (sementara sebelum ada database)
        $notif_pesan = "Halo $nama, simulasi pendaftaran berhasil! Silakan Login.";
        $notif_tipe = "sukses";
    }
    
    // ==========================================
    // LOGIKA KETIKA TOMBOL LOGIN DITEKAN
    // ==========================================
    if (isset($_POST['btn_login'])) {
        // Mengambil data dari form login
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // TODO (Minggu depan): Kode SELECT * FROM users akan ditaruh di sini
        
        // Simulasi notifikasi berhasil
        $notif_pesan = "Simulasi Login berhasil untuk $email!";
        $notif_tipe = "sukses";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NusaRent - Login & Register PHP</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
        .form-container { transition: all 0.5s ease; }
        .hidden-form { display: none; opacity: 0; }
        .active-form { display: block; opacity: 1; animation: fadeIn 0.5s ease forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Background gambar kota Jakarta dari Bing */
        .bg-image {
            background-image: url('https://tse3.mm.bing.net/th/id/OIP._E1sfCmKFPoqH23SgGF1YAHaE8?rs=1&pid=ImgDetMain&o=7&rm=3');
            background-size: cover;
            background-position: center;
        }
        .overlay { background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.4) 100%); }
    </style>
</head>
<body class="h-screen w-full flex items-center justify-center bg-gray-100 relative">

    <!-- Notifikasi PHP (Akan muncul jika ada aksi submit form) -->
    <?php if ($notif_pesan != ""): ?>
        <div id="phpNotif" class="fixed top-5 right-5 bg-slate-800 text-white px-6 py-4 rounded-lg shadow-xl z-50 border-l-4 border-blue-500 flex items-center gap-3 transition-opacity duration-500">
            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-semibold"><?php echo $notif_tipe == 'sukses' ? 'Berhasil!' : 'Info'; ?></h4>
                <p class="text-sm text-gray-300"><?php echo $notif_pesan; ?></p>
            </div>
        </div>
        <!-- Script untuk menghilangkan notif PHP setelah 4 detik -->
        <script>
            setTimeout(() => {
                const notif = document.getElementById('phpNotif');
                if(notif) {
                    notif.style.opacity = '0';
                    setTimeout(() => notif.remove(), 500);
                }
            }, 4000);
        </script>
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
            
            <!-- LOGIN FORM -->
            <!-- Tambahkan method POST dan hilangkan onsubmit JS sebelumnya -->
            <div id="loginForm" class="w-full active-form form-container">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang Kembali!</h2>
                    <p class="text-gray-500 mt-2">Masuk untuk melanjutkan perjalanan Anda</p>
                </div>

                <form method="POST" action="">
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="loginEmail">Alamat Email</label>
                        <!-- Tambahkan name="email" -->
                        <input type="email" name="email" id="loginEmail" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="anda@email.com" required>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-gray-700 text-sm font-semibold" for="loginPassword">Kata Sandi</label>
                            <a href="#" class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">Lupa Kata Sandi?</a>
                        </div>
                        <!-- Tambahkan name="password" -->
                        <input type="password" name="password" id="loginPassword" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="••••••••" required>
                    </div>

                    <!-- Tambahkan name="btn_login" sebagai trigger -->
                    <button type="submit" name="btn_login" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg">
                        Masuk
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-8">
                    Belum bergabung dengan NusaRent? 
                    <button onclick="toggleForms('register')" class="text-blue-600 font-semibold hover:text-blue-800 focus:outline-none transition-colors">Daftar sekarang</button>
                </p>
            </div>

            <!-- REGISTER FORM -->
            <div id="registerForm" class="w-full hidden-form form-container">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Mulai Perjalanan</h2>
                    <p class="text-gray-500 mt-2">Buat akun untuk pengalaman sewa terbaik</p>
                </div>

                <form method="POST" action="">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="regName">Nama Lengkap</label>
                        <!-- Tambahkan name="nama_lengkap" -->
                        <input type="text" name="nama_lengkap" id="regName" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="Nama sesuai KTP" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="regEmail">Alamat Email</label>
                        <!-- Tambahkan name="email" -->
                        <input type="email" name="email" id="regEmail" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="anda@email.com" required>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="regPassword">Kata Sandi</label>
                        <!-- Tambahkan name="password" -->
                        <input type="password" name="password" id="regPassword" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="Minimal 8 karakter" required>
                    </div>

                    <!-- Tambahkan name="btn_register" sebagai trigger -->
                    <button type="submit" name="btn_register" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg">
                        Buat Akun
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-6">
                    Sudah memiliki akun? 
                    <button onclick="toggleForms('login')" class="text-blue-600 font-semibold hover:text-blue-800 focus:outline-none transition-colors">Masuk di sini</button>
                </p>
            </div>

        </div>
    </div>

    <!-- Script JS untuk animasi pertukaran form -->
    <script>
        function toggleForms(formType) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');

            if (formType === 'register') {
                loginForm.classList.remove('active-form');
                loginForm.classList.add('hidden-form');
                
                setTimeout(() => {
                    registerForm.classList.remove('hidden-form');
                    registerForm.classList.add('active-form');
                }, 100);
            } else {
                registerForm.classList.remove('active-form');
                registerForm.classList.add('hidden-form');
                
                setTimeout(() => {
                    loginForm.classList.remove('hidden-form');
                    loginForm.classList.add('active-form');
                }, 100);
            }
        }
    </script>
</body>
</html>