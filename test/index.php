<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NusaRent - Masuk & Daftar</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Memanggil file CSS jika ada styling tambahan -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="h-screen w-full flex items-center justify-center bg-gray-100 relative">

    <!-- Container Utama -->
    <div class="flex w-full max-w-5xl h-[600px] bg-white rounded-2xl shadow-2xl overflow-hidden m-4">
        
        <!-- Sisi Kiri: Gambar Background -->
<div class="hidden md:flex w-1/2 relative" 
     style="background-image: url('../gambar/bg.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">
            
    <div class="absolute inset-0 flex flex-col justify-center px-12 text-white" 
     style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.5) 0%, rgba(15, 23, 42, 0.1) 100%);">

        <h1 class="text-5xl font-bold mb-6 tracking-tight">NusaRent<span class="text-blue-500">.</span></h1>
        <h2 class="text-2xl font-semibold mb-4 leading-tight">Jelajahi Kota Tanpa Batas.</h2>
        <p class="text-base text-gray-300 font-light leading-relaxed">
            Mobilitas masa depan ada di genggaman Anda. Nikmati pengalaman sewa kendaraan premium yang mulus, efisien, dan dirancang khusus untuk gaya hidup urban Anda.
        </p>
    </div>
</div>

        <!-- Sisi Kanan: Form Login & Register Dinamis -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 lg:p-14 relative overflow-hidden">
            
            <!-- ============================================== -->
            <!-- FORM LOGIN (SIGN IN)                           -->
            <!-- ============================================== -->
            <div id="signIn" class="w-full transition-all duration-500">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang Kembali!</h2>
                    <p class="text-gray-500 mt-2">Masuk untuk melanjutkan perjalanan Anda</p>
                </div>

                <form method="post" action="register.php">
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" id="email" class="w-full pl-10 px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="anda@email.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-gray-700 text-sm font-semibold" for="password">Kata Sandi</label>
                            <a href="#" class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">Lupa Kata Sandi?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password" class="w-full pl-10 px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors" placeholder="••••••••" required>
                        </div>
                    </div>

                    <input type="submit" name="signIn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg cursor-pointer" value="Masuk">
                </form>

                <p class="text-center text-sm text-gray-600 mt-8">
                    Belum bergabung dengan NusaRent? 
                    <!-- Tombol ini memicu script.js milik YouTube -->
                    <button type="button" id="signUpButton" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors bg-transparent border-none cursor-pointer">Daftar sekarang</button>
                </p>
            </div>

            <!-- ============================================== -->
            <!-- FORM REGISTER (SIGN UP)                        -->
            <!-- ============================================== -->
            <!-- Form ini disembunyikan secara default (display: none) mengikuti gaya YouTube -->
            <div id="signup" class="w-full transition-all duration-500" style="display:none;">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Buat Akun Baru</h2>
                    <p class="text-gray-500 mt-2">Daftar untuk pengalaman sewa terbaik</p>
                </div>

                <form method="post" action="register.php">
                    <!-- Grid untuk First Name dan Last Name -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-xs font-semibold mb-1" for="fName">Nama Depan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="fName" id="fName" class="w-full pl-9 px-3 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:outline-none transition-colors" placeholder="Nama Depan" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-xs font-semibold mb-1" for="lName">Nama Belakang</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="lName" id="lName" class="w-full pl-9 px-3 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:outline-none transition-colors" placeholder="Nama Belakang" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="emailReg">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" id="emailReg" class="w-full pl-10 px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:outline-none transition-colors" placeholder="anda@email.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="passwordReg">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="passwordReg" class="w-full pl-10 px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:outline-none transition-colors" placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>

                    <input type="submit" name="signUp" class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg cursor-pointer" value="Daftar Akun">
                </form>

                <p class="text-center text-sm text-gray-600 mt-6">
                    Sudah memiliki akun? 
                    <!-- Tombol ini memicu script.js milik YouTube -->
                    <button type="button" id="signInButton" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors bg-transparent border-none cursor-pointer">Masuk di sini</button>
                </p>
            </div>

        </div>
    </div>

    <!-- SCRIPT WAJIB dari tutorial YouTube untuk animasi form -->
    <script src="script.js"></script>
</body>
</html>