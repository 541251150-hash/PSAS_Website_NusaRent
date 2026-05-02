

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NusaRent - Masuk</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- 3. Memanggil file CSS eksternal -->
    <link rel="stylesheet" href="login.css">
</head>
<body class="h-screen w-full flex items-center justify-center bg-gray-100 relative">

    <!-- Area Notifikasi Alert -->
    <?php if ($notif_pesan != ""): ?>
        <?php 
            $bg_color = ($notif_tipe == 'sukses') ? 'bg-slate-800 border-green-500' : 'bg-red-500 border-red-800'; 
            $icon_color = ($notif_tipe == 'sukses') ? 'text-green-400' : 'text-white';
        ?>
        <div class="fixed top-5 right-5 <?php echo $bg_color; ?> text-white px-6 py-4 rounded-lg shadow-xl z-50 border-l-4 flex items-center gap-3 animate-bounce">
            <svg class="w-6 h-6 <?php echo $icon_color; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <h4 class="font-semibold">Gagal Masuk!</h4>
                <p class="text-sm text-gray-100"><?php echo $notif_pesan; ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Container Utama -->
    <div class="flex w-full max-w-5xl h-[600px] bg-white rounded-2xl shadow-2xl overflow-hidden m-4">
        
        <!-- Sisi Kiri: Gambar Background dari login.css -->
        <div class="hidden md:flex w-1/2 bg-image relative">
            <div class="absolute inset-0 overlay flex flex-col justify-center px-12 text-white">
                <h1 class="text-5xl font-bold mb-6 tracking-tight">NusaRent<span class="text-blue-500">.</span></h1>
                <h2 class="text-2xl font-semibold mb-4 leading-tight">Jelajahi Kota Tanpa Batas.</h2>
                <p class="text-base text-gray-300 font-light leading-relaxed">
                    Mobilitas masa depan ada di genggaman Anda. Nikmati pengalaman sewa kendaraan premium yang mulus, efisien, dan dirancang khusus untuk gaya hidup urban Anda.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 lg:p-14 relative overflow-hidden">
            
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
                    <!-- 4. Mengarahkan ke file register.php -->
                    <a href="register.html" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">Daftar sekarang</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>