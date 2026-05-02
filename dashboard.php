<?php
// Memulai session untuk mengambil data user yang sedang login
session_start();

// Mengecek apakah user sudah login (Hanya aktif di XAMPP/VS Code)
if (!isset($_SESSION['id_user'])) {
    // Jika belum login, baris di bawah ini akan memulangkan user ke halaman login
    // header("Location: login.php");
    // exit();
}

// Simulasi nama user jika dijalankan tanpa login (hanya untuk tampilan visual)
$nama_user = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : "Pelanggan";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Mobil Online No 1 di Indonesia - NusaRent</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome CDN untuk Ikon (Mobil, Kalender, Lokasi, dll) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Font Roboto untuk menyamai gaya font Indoloka -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #ffffff;
        }

        /* Warna Biru Khas Indoloka */
        .bg-indoloka-blue {
            background-color: #0076D6; /* Biru Header */
        }
        .btn-indoloka-blue {
            background-color: #006BFE; /* Biru Tombol */
        }
        .border-indoloka-yellow {
            border-bottom: 4px solid #FFC107; /* Garis kuning di bawah navbar */
        }

        /* Form Pencarian Transparan */
        .search-box-glass {
            background-color: rgba(255, 255, 255, 0.65);
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: relative;
        }
        
        /* Pita / Label di atas form */
        .search-box-header {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 8px 12px;
            font-style: italic;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
            display: inline-block;
            width: 100%;
        }

        /* Input Form Custom */
        .input-group {
            position: relative;
            margin-bottom: 12px;
        }
        .input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #0076D6;
        }
        .input-group input, .input-group select {
            width: 100%;
            padding: 8px 10px 8px 35px;
            border: 1px solid #ccc;
            border-radius: 2px;
            font-size: 14px;
            outline: none;
            background-color: #fff;
        }
        .input-group input:focus, .input-group select:focus {
            border-color: #0076D6;
        }
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
            display: block;
        }

        /* Custom Dropdown Arrow */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 1em;
        }

        /* Hero Image Slider */
        .hero-slider {
            background-image: url('https://images.unsplash.com/photo-1514282401047-d79a71a590e8?q=80&w=2000&auto=format&fit=crop'); /* Gambar Pantai Lombok */
            background-size: cover;
            background-position: center;
            height: 500px;
            position: relative;
        }

        /* Navigasi Panah Kiri Kanan */
        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 40px;
            cursor: pointer;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            opacity: 0.8;
            z-index: 10;
        }
        .slider-arrow:hover { opacity: 1; }
        .arrow-left { left: 20px; }
        .arrow-right { right: 20px; }

        /* Titik Navigasi Bawah */
        .slider-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }
        .dot {
            width: 12px;
            height: 12px;
            background-color: rgba(255,255,255,0.5);
            border-radius: 50%;
            cursor: pointer;
        }
        .dot.active { background-color: white; }
    </style>
</head>
<body class="antialiased">

    <!-- NAVBAR TOP -->
    <nav class="bg-indoloka-blue border-indoloka-yellow text-white w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Kiri: Logo & Link -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <div class="flex flex-col cursor-pointer">
                        <div class="flex items-center text-3xl font-bold tracking-tight">
                            <i class="fa-solid fa-car-side mr-2"></i> NusaRent<span class="text-sm font-normal pt-2">.com</span>
                        </div>
                        <span class="text-xs font-medium tracking-wide">Sewa Mobil Online No 1 di Indonesia</span>
                    </div>
                    
                    <!-- Menu Links -->
                    <div class="hidden md:flex space-x-6 pt-2">
                        <a href="#" class="bg-blue-500/50 px-3 py-1 rounded text-sm font-medium hover:bg-blue-600">Sewa Mobil</a>
                        <a href="#" class="text-sm font-medium hover:text-gray-200 pt-1">Hubungi Kami</a>
                        <a href="#" class="text-sm font-medium hover:text-gray-200 pt-1">Corporate</a>
                    </div>
                </div>

                <!-- Kanan: Sign In & Language -->
                <div class="hidden md:flex items-center space-x-6 pt-2 text-sm font-medium">
                    <!-- Sapaan User (Menggantikan SIGN IN) -->
                    <div class="relative group cursor-pointer">
                        <span class="uppercase">HALO, <?php echo htmlspecialchars($nama_user); ?> <i class="fa-solid fa-caret-down ml-1"></i></span>
                        <!-- Dropdown Logout -->
                        <div class="absolute hidden group-hover:block bg-white text-black mt-2 rounded shadow-lg p-2 w-32 right-0 z-50">
                            <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100 text-red-600 font-bold"><i class="fa-solid fa-sign-out-alt"></i> Keluar</a>
                        </div>
                    </div>
                    
                    <!-- Language -->
                    <div class="flex items-center cursor-pointer">
                        <img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="mr-2 h-3 border border-gray-300">
                        IND <i class="fa-solid fa-caret-down ml-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SLIDER SECTION -->
    <section class="hero-slider">
        
        <!-- Panah Kiri & Kanan -->
        <i class="fa-solid fa-angle-left slider-arrow arrow-left"></i>
        <i class="fa-solid fa-angle-right slider-arrow arrow-right"></i>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative">
            
            <!-- FORM PENCARIAN (Kiri) -->
            <div class="absolute top-1/2 -translate-y-1/2 left-4 md:left-8 w-[90%] md:w-[420px] z-20">
                <div class="search-box-glass">
                    <div class="search-box-header">
                        NusaRent Sewa Mobil
                    </div>
                    
                    <form action="#" method="GET">
                        <!-- Lokasi Penjemputan -->
                        <div class="mb-3">
                            <label class="form-label">Lokasi Penjemputan</label>
                            <div class="input-group">
                                <i class="fa-solid fa-location-dot"></i>
                                <select name="lokasi">
                                    <option value="jakarta">JAKARTA</option>
                                    <option value="bali">BALI</option>
                                    <option value="lombok">LOMBOK</option>
                                    <option value="surabaya">SURABAYA</option>
                                </select>
                            </div>
                        </div>

                        <!-- Jenis Mobil -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Mobil Sewa</label>
                            <div class="input-group">
                                <i class="fa-solid fa-car"></i>
                                <select name="mobil">
                                    <option value="avanza">Toyota Avanza</option>
                                    <option value="innova">Toyota Innova</option>
                                    <option value="brio">Honda Brio</option>
                                    <option value="alphard">Toyota Alphard</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tanggal & Lama Sewa (Grid 2 Kolom) -->
                        <div class="flex gap-2 mb-3">
                            <div class="w-1/2">
                                <label class="form-label">Tanggal Sewa</label>
                                <div class="input-group">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <input type="date" name="tanggal" class="!pl-[35px] !pr-[5px]"> 
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label class="form-label">Lama Sewa</label>
                                <div class="input-group">
                                    <i class="fa-regular fa-clock"></i>
                                    <select name="lama_sewa">
                                        <option value="1">1 Hari</option>
                                        <option value="2">2 Hari</option>
                                        <option value="3">3 Hari</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah Unit & Paket (Grid 2 Kolom) -->
                        <div class="flex gap-2 mb-4">
                            <div class="w-1/2">
                                <label class="form-label">Jumlah Unit</label>
                                <div class="input-group">
                                    <i class="fa-solid fa-car"></i>
                                    <select name="jumlah">
                                        <option value="1">1 Unit</option>
                                        <option value="2">2 Unit</option>
                                        <option value="3">3 Unit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label class="form-label">Paket</label>
                                <div class="input-group">
                                    <i class="fa-solid fa-box"></i>
                                    <select name="paket">
                                        <option value="semua">Semua Paket</option>
                                        <option value="lepas_kunci">Lepas Kunci</option>
                                        <option value="dengan_supir">Dengan Supir</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Search -->
                        <button type="submit" class="w-full btn-indoloka-blue text-white font-bold py-3 px-4 flex items-center justify-center gap-2 hover:bg-blue-700 transition">
                            SEARCH NOW <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- PROMO TEXT (Kanan) -->
            <div class="hidden md:flex absolute top-1/2 -translate-y-1/2 right-12 flex-col items-center justify-center text-white text-center z-10">
                <h2 class="text-6xl font-bold drop-shadow-lg mb-2">Lombok</h2>
                <h3 class="text-2xl drop-shadow-md mb-6">Rental Mobil Lombok</h3>
                <a href="#" class="btn-indoloka-blue px-8 py-3 text-xl font-bold shadow-lg hover:bg-blue-700 transition">BOOK NOW !</a>
            </div>

            <!-- Tag Lokasi Bawah Kanan -->
            <div class="absolute bottom-6 right-4 bg-black/50 px-4 py-2 text-white text-sm font-medium italic z-10 border border-white/20">
                Lokasi : Hotel Lombok
            </div>
        </div>

        <!-- Pagination Dots Bawah -->
        <div class="slider-dots">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </section>

    <!-- KONTEN BAWAH (AYO JALAN - JALAN) -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg font-bold text-gray-800 mb-6 uppercase border-b border-gray-300 pb-2 inline-block">AYO JALAN - JALAN KE KOTA MENARIK INI</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
                <!-- Card Kota 1 -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1555899434-94d1368aa7af?q=80&w=800&auto=format&fit=crop" alt="Jakarta" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/60 p-3">
                        <p class="text-white font-bold text-center tracking-wide">JAKARTA</p>
                    </div>
                </div>

                <!-- Card Kota 2 -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800&auto=format&fit=crop" alt="Bali" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/60 p-3">
                        <p class="text-white font-bold text-center tracking-wide">BALI</p>
                    </div>
                </div>

                <!-- Card Kota 3 -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=800&auto=format&fit=crop" alt="Surabaya" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/60 p-3">
                        <p class="text-white font-bold text-center tracking-wide">SURABAYA</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Simple -->
    <footer class="bg-gray-100 border-t border-gray-200 text-gray-600 py-6 mt-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">© <?php echo date("Y"); ?> NusaRent (Sewa Mobil Online). All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>