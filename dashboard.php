<?php
// Memulai session untuk mengambil data user yang sedang login
session_start();

// Mengecek apakah user sudah login
if (!isset($_SESSION['email'])) {
    // Jika belum login, baris di bawah ini akan memulangkan user ke halaman login di folder test
    header("Location: test/index.php");
    exit();
}

// Memanggil koneksi database
include("test/connect.php"); 

$nama_user = "Pelanggan"; // Default

// Mengambil data user berdasarkan email yang tersimpan di session
$email = $_SESSION['email'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if($row = mysqli_fetch_assoc($query)){
    if(isset($row['firstName'])){
        $nama_user = $row['firstName']; 
    } else {
        $nama_user = $row['email'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Mobil Online No 1 di Indonesia - NusaRent</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome CDN untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Font Roboto untuk menyamai gaya font Indoloka -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- AOS CSS (Animasi Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #ffffff;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        /* Warna Biru Khas Indoloka */
        .bg-indoloka-blue { background-color: #0076D6; }
        .btn-indoloka-blue { background-color: #006BFE; }
        .border-indoloka-yellow { border-bottom: 4px solid #FFC107; }

        /* Form Pencarian */
        .search-box-glass { background-color: rgba(255, 255, 255, 0.85); padding: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); position: relative; }
        .search-box-header { background-color: rgba(255, 255, 255, 0.95); padding: 8px 12px; font-style: italic; font-weight: bold; color: #555; margin-bottom: 10px; display: inline-block; width: 100%; border-bottom: 2px solid #ccc; }
        .input-group { position: relative; margin-bottom: 12px; }
        .input-group i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #0076D6; }
        .input-group input, .input-group select { width: 100%; padding: 8px 10px 8px 35px; border: 1px solid #ccc; border-radius: 2px; font-size: 14px; outline: none; background-color: #fff; }
        .input-group input:focus, .input-group select:focus { border-color: #0076D6; }
        .form-label { font-size: 13px; font-weight: 600; color: #333; margin-bottom: 4px; display: block; }

        select { appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 10px center; background-size: 1em; }

        /* Hero Image Slider */
        /* Fokus gambar agak ditarik ke atas (center 20%) agar pas */
        .hero-slider { background-image: url('https://images.unsplash.com/photo-1549473889-14f410d83298?q=80&w=2000&auto=format&fit=crop'); background-size: cover; background-position: center 20%; height: 520px; position: relative; transition: background-image 0.6s ease-in-out; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.2) 40%, rgba(0,0,0,0) 100%); }
        .slider-arrow { position: absolute; top: 50%; transform: translateY(-50%); color: white; font-size: 40px; cursor: pointer; text-shadow: 0 2px 6px rgba(0,0,0,0.6); opacity: 0.8; z-index: 30; transition: opacity 0.3s, transform 0.2s; }
        .slider-arrow:hover { opacity: 1; transform: translateY(-50%) scale(1.1); }
        .arrow-left { left: 30px; } .arrow-right { right: 30px; }
        .slider-dots { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 30; }
        .dot { width: 12px; height: 12px; background-color: rgba(255,255,255,0.5); border-radius: 50%; cursor: pointer; transition: background-color 0.3s; }
        .dot.active { background-color: white; box-shadow: 0 0 5px rgba(0,0,0,0.5); }
    </style>
</head>
<body class="antialiased" id="top">

    <!-- NAVBAR TOP -->
    <nav class="bg-indoloka-blue border-indoloka-yellow text-white w-full fixed top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex items-center space-x-8">
                    <div class="flex flex-col cursor-pointer" data-aos="fade-right">
                        <div class="flex items-center text-3xl font-bold tracking-tight">
                            <i class="fa-solid fa-car-side mr-2"></i> NusaRent<span class="text-sm font-normal pt-2">.com</span>
                        </div>
                        <span class="text-xs font-medium tracking-wide">Sewa Mobil Online No 1 di Indonesia</span>
                    </div>
                    
                    <div class="hidden md:flex items-center space-x-6 pt-2" data-aos="fade-down" data-aos-delay="100">
                        <a href="#" class="bg-blue-500/50 px-3 py-1 rounded text-sm font-medium hover:bg-blue-600 transition">Sewa Mobil</a>
                        <a href="#" class="text-sm font-medium hover:text-gray-200 transition">Hubungi Kami</a>
                        <!-- MENGGANTI CORPORATE MENJADI SOCIAL MEDIA -->
                        <div class="flex items-center space-x-3 text-lg border-l border-white/30 pl-4 ml-2">
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-6 pt-2 text-sm font-medium" data-aos="fade-left">
                    <div class="relative group cursor-pointer">
                        <span class="uppercase">HALO, <?php echo htmlspecialchars($nama_user); ?> <i class="fa-solid fa-caret-down ml-1"></i></span>
                        <div class="absolute hidden group-hover:block bg-white text-black mt-2 rounded shadow-lg p-2 w-32 right-0 z-50">
                            <a href="test/logout.php" class="block px-4 py-2 hover:bg-gray-100 text-red-600 font-bold transition"><i class="fa-solid fa-sign-out-alt"></i> Keluar</a>
                        </div>
                    </div>
                    
                    <div class="flex items-center cursor-pointer hover:opacity-80 transition">
                        <img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="mr-2 h-3 border border-gray-300">
                        IND <i class="fa-solid fa-caret-down ml-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SLIDER SECTION -->
    <section class="hero-slider mt-20" id="hero-slider">
        <div class="hero-overlay"></div>
        
        <i class="fa-solid fa-angle-left slider-arrow arrow-left" id="btn-prev"></i>
        <i class="fa-solid fa-angle-right slider-arrow arrow-right" id="btn-next"></i>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative">
            
            <!-- FORM PENCARIAN -->
            <!-- Kotak ditarik agak ke atas (top-6 md:top-10) agar dropdown meluncur ke bawah dan pas di bingkai -->
            <div class="absolute top-6 md:top-10 left-0 md:left-4 w-full md:w-[420px] px-4 md:px-0 z-20" data-aos="fade-right" data-aos-duration="1000">
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
                                    <option value="bandung">BANDUNG</option>
                                    <option value="jakarta">JAKARTA</option>
                                    <option value="bali">BALI</option>
                                    <option value="malang">MALANG</option>
                                    <option value="yogyakarta">YOGYAKARTA</option>
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
                                    <option value="avanza">Toyota All New Avanza</option>
                                    <option value="xpander">Mitsubishi Xpander</option>
                                    <option value="innova_reborn">Toyota Innova Reborn</option>
                                    <option value="alphard">Toyota Alphard</option>
                                    <option value="hiace_commuter">Toyota Hiace Commuter</option>
                                    <option value="hiace_premio">Toyota Hiace Premio</option>
                                    <option value="pajero">Mitsubishi Pajero Sport</option>
                                    <option value="xenia">Daihatsu All New Xenia</option>
                                    <option value="raize">Toyota Raize</option>
                                    <option value="rush">Toyota Rush GR Sport</option>
                                    <option value="veloz">Toyota All New Veloz</option>
                                    <option value="zenix">Toyota Innova Zenix Hybrid</option>
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
                                        <option value="all_in">All In</option>
                                        <option value="diluar_operasional">Diluar Biaya Operasional</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL SEARCH NOW: Akan scroll ke id="daftar-mobil" -->
                        <button type="button" onclick="document.getElementById('daftar-mobil').scrollIntoView({behavior: 'smooth'})" class="w-full btn-indoloka-blue text-white font-bold py-3 px-4 flex items-center justify-center gap-2 hover:bg-blue-700 transition transform hover:scale-[1.02]">
                            SEARCH NOW <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- PROMO TEXT Kanan Tengah -->
            <div class="hidden md:flex absolute top-1/2 -translate-y-1/2 right-0 w-[55%] flex-col items-center justify-center text-white text-center z-20" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                <h2 id="promo-title" class="text-[3.5rem] font-bold drop-shadow-lg mb-1 transition-all duration-300">Bandung</h2>
                <h3 id="promo-subtitle" class="text-2xl drop-shadow-md mb-6 transition-all duration-300">Rental Mobil Bandung</h3>
                <!-- TOMBOL BOOK NOW: Mengarah ke id="daftar-mobil" -->
                <a href="#daftar-mobil" class="btn-indoloka-blue px-8 py-3 text-xl font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1">BOOK NOW !</a>
            </div>

            <div id="promo-location" class="absolute bottom-5 right-0 text-white text-lg font-medium italic drop-shadow-lg z-20">
                Lokasi : Jembatan Pasupati
            </div>

        </div>

        <div class="slider-dots" id="slider-dots-container"></div>
    </section>

    <!-- KONTEN BAWAH (AYO JALAN - JALAN) -->
    <section class="py-12 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg font-bold text-gray-800 mb-6 uppercase border-b border-gray-300 pb-2 inline-block" data-aos="fade-up">AYO JALAN - JALAN KE KOTA MENARIK INI</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="0">
                    <img src="gambar/jakarta.jpg" alt="Jakarta" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Jakarta</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">Lebih dari 400 rental</p></div>
                </div>

                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800&auto=format&fit=crop" alt="Bali" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Bali</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">Lebih dari 400 rental</p></div>
                </div>

                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1549473889-14f410d83298?q=80&w=800&auto=format&fit=crop" alt="Bandung" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Bandung</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">Lebih dari 400 rental</p></div>
                </div>

                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="0">
                    <img src="gambar/malang.jpg" alt="Malang" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Malang</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">Lebih dari 400 rental</p></div>
                </div>

                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="100">
                    <img src="gambar/jogja.PNG" alt="Yogyakarta" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Yogyakarta</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">Lebih dari 400 rental</p></div>
                </div>

                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=800&auto=format&fit=crop" alt="Surabaya" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Surabaya</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">Lebih dari 400 rental</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- MENGAPA SEWA MOBIL SECTION -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" data-aos="fade-in"><div class="flex h-1.5 w-full mb-8"><div class="w-1/3 bg-[#1ba0e2]"></div><div class="w-1/3 bg-[#ffb400]"></div><div class="w-1/3 bg-[#ff4b00]"></div></div></div>
    
    <section class="pb-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold text-gray-900 mb-8 uppercase text-left" data-aos="fade-right">MENGAPA SEWA MOBIL DI NUSARENT.COM?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Fitur -->
                <div class="border border-gray-200 p-6 flex flex-col items-center text-center bg-white hover:shadow-xl hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-[100px] h-[100px] rounded-full bg-[#1ba0e2] flex items-center justify-center text-white mb-5 relative hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-car text-5xl"></i>
                        <div class="absolute top-1 right-0 bg-[#1ba0e2] rounded-full w-10 h-10 flex flex-col items-center justify-center border-2 border-white shadow-sm">
                            <span class="text-[8px] leading-tight font-bold">Rp</span><span class="text-[6px] leading-tight font-bold text-yellow-300">BEST<br>PRICE</span>
                        </div>
                    </div>
                    <h3 class="text-[#1ba0e2] font-bold text-lg mb-2">Crazy Price</h3>
                    <p class="text-gray-600 text-sm px-2">Harga sangat kompetitif dan murah, buktikan Yukkk...</p>
                </div>
                <div class="border border-gray-200 p-6 flex flex-col items-center text-center bg-white hover:shadow-xl hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-[100px] h-[100px] rounded-full bg-[#1ba0e2] flex items-center justify-center text-white mb-5 hover:scale-110 transition duration-300"><i class="fa-regular fa-clock text-[55px]"></i></div>
                    <h3 class="text-[#1ba0e2] font-bold text-lg mb-2">Easy to Order</h3><p class="text-gray-600 text-sm px-2">Online order nya cepat, mudah & murah.</p>
                </div>
                <div class="border border-gray-200 p-6 flex flex-col items-center text-center bg-white hover:shadow-xl hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-[100px] h-[100px] rounded-full bg-[#1ba0e2] flex items-center justify-center text-white mb-5 hover:scale-110 transition duration-300">
                        <div class="flex flex-col items-center justify-center mt-3"><i class="fa-solid fa-car text-2xl -mb-1"></i><div class="flex gap-1"><i class="fa-solid fa-car text-3xl"></i><i class="fa-solid fa-car text-3xl"></i></div></div>
                    </div>
                    <h3 class="text-[#1ba0e2] font-bold text-lg mb-2">10,000+ Cars in 90 Cities</h3><p class="text-gray-600 text-[13px] leading-relaxed">NusaRent sewa mobil memiliki Lebih dari 10.000 mobil. NusaRent rental mobil tersedia di 90 kota di Indonesia.</p>
                </div>
                <div class="border border-gray-200 p-6 flex flex-col items-center text-center bg-white hover:shadow-xl hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-[100px] h-[100px] rounded-full bg-[#1ba0e2] flex flex-col items-center justify-center text-white mb-5 pt-2 hover:scale-110 transition duration-300">
                        <div class="flex gap-0.5 text-[10px] mb-1 text-white"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <i class="fa-solid fa-car text-3xl mb-1"></i><i class="fa-solid fa-hand-holding text-2xl"></i>
                    </div>
                    <h3 class="text-[#1ba0e2] font-bold text-lg mb-2">Layanan Premier:</h3>
                    <div class="text-gray-600 text-sm text-left w-full pl-3"><p class="mb-1">• supir berpengalaman.</p><p class="mb-1">• fleksibel jam & lokasi penjemputan.</p><p>• fasilitas pemesanan minuman & tissue.</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION BARU: DAFTAR ARMADA MOBIL (Sesuai Video) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2" data-aos="fade-in"><div class="flex h-[2px] w-full mb-8 bg-gray-200"></div></div>
    
    <section id="daftar-mobil" class="pb-20 pt-8 bg-[#f9f9f9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800" data-aos="fade-right">12 MOBIL DITEMUKAN</h2>
                <div class="flex items-center gap-2 text-sm text-gray-600" data-aos="fade-left">
                    <span>Sorted by:</span>
                    <select class="border border-gray-300 rounded px-2 py-1 bg-white outline-none">
                        <option>Harga Termurah</option>
                        <option>Rekomendasi</option>
                    </select>
                </div>
            </div>

            <!-- List Mobil 1: Avanza -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota all new avanza.jpg" alt="Toyota Avanza" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota All New Avanza</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2020-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake" title="AC"></i>
                        <i class="fa-solid fa-users" title="7 Penumpang"></i>
                        <i class="fa-solid fa-suitcase" title="2 Koper"></i>
                        <i class="fa-solid fa-gas-pump" title="Bensin"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> NusaRent car rental</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Pemakaian radius 40 km</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir / Dropoff</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-xs text-gray-400 line-through mb-1">Rp. 500.000</p>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 450.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 450.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

            <!-- List Mobil 2: Xpander -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/mitshubishi xpander.jpg" alt="Mitsubishi Xpander" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Mitsubishi Xpander</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2021-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> NusaRent car rental</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Pemakaian radius 40 km</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir / Dropoff</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-xs text-gray-400 line-through mb-1">Rp. 550.000</p>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 480.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 480.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

           
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota innova reborn.jpg" alt="Toyota Innova Reborn" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Innova Reborn</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2018-2022</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> NusaRent premium rental</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Dalam Kota & Luar Kota</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir / Dropoff</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-xs text-gray-400 line-through mb-1">Rp. 850.000</p>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 750.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 750.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

            
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota alphard.jpg" alt="Toyota Alphard" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Alphard</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2021-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Layanan VIP VVIP</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Pemakaian Dalam Kota</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir Eksklusif</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 2.500.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 2.500.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

           
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota hiace.jpg" alt="Toyota Hiace" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Hiace Commuter</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2019-2022</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users" title="15 Penumpang"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Kapasitas Besar (15 Orang)</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Pemakaian Tour / Wisata</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir Pariwisata</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 1.400.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 1.400.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

          
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota hiace premio.jpg" alt="Toyota Hiace Premio" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Hiace Premio</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2022-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users" title="12 Penumpang"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Eksekutif Van (Captain Seat)</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Tour Mewah Keluarga</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir Profesional</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 1.800.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 1.800.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

            <!-- List Mobil 7: Pajero Sport -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/mitshubishi pajero.jpg" alt="Mitsubishi Pajero Sport" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Mitsubishi Pajero Sport</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2021-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> SUV Premium Tangguh</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Cocok untuk Segala Medan</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 1.500.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 1.500.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

            <!-- List Mobil 8: Daihatsu Xenia -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/daihatsu all newxenia.jpg" alt="Daihatsu All New Xenia" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Daihatsu All New Xenia</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2022-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Mobil Keluarga Ekonomis</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Hemat Bahan Bakar</li>
                        <li><i class="fa-solid fa-key text-gray-700 mr-2 w-4"></i> Lepas Kunci / Dengan Supir</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <p class="text-xs text-gray-400 line-through mb-1">Rp. 450.000</p>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 350.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 350.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

            <!-- List Mobil 9: Toyota Raize -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota raize.jpg" alt="Toyota Raize" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Raize</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2022-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users" title="5 Penumpang"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Compact SUV Kekinian</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Lincah di Perkotaan</li>
                        <li><i class="fa-solid fa-key text-gray-700 mr-2 w-4"></i> Lepas Kunci Tersedia</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 450.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 450.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

            <!-- List Mobil 10: Toyota Rush -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota rush.jpg" alt="Toyota Rush" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Rush GR Sport</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2021-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> SUV Sporty 7 Penumpang</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Ground Clearance Tinggi</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 550.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 550.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

            <!-- List Mobil 11: Toyota Veloz -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota veloz.jpg" alt="Toyota Veloz" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota All New Veloz</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2022-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> MPV Nyaman & Canggih</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Nyaman Untuk Perjalanan Jauh</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 500.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 500.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

            <!-- List Mobil 12: Toyota Zenix -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota zenix.jpg" alt="Toyota Innova Zenix" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Innova Zenix Hybrid</h3>
                    <p class="text-gray-500 text-sm mb-4">Tahun Mobil 2023-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-leaf text-green-500" title="Hybrid"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Kabin Sangat Senyap & Luas</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Sangat Hemat BBM (Hybrid)</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Termasuk Supir Eksklusif</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 900.000 <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Bayar: Rp. 900.000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer Simple -->
    <footer class="bg-gray-100 border-t border-gray-200 text-gray-600 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">© <?php echo date("Y"); ?> NusaRent (Sewa Mobil Online). All Rights Reserved.</p>
        </div>
    </footer>

    <!-- TOMBOL SCROLL TO TOP -->
    <a href="#top" class="fixed bottom-6 right-6 bg-[#444444] text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg hover:bg-gray-800 transition z-50 hover:-translate-y-1">
        <i class="fa-solid fa-chevron-up text-xl"></i>
    </a>

    <!-- SCRIPT AOS ANIMASI -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- JAVASCRIPT UNTUK ANIMASI SLIDER & INIT AOS -->
    <script>
        // Inisialisasi AOS (Animasi Scroll)
        AOS.init({
            once: true, // Animasi hanya berjalan sekali saat di-scroll
            offset: 50, // Muncul lebih awal
        });

        // Data untuk masing-masing slide 
        const slides = [
            {
                image: "url('https://images.unsplash.com/photo-1549473889-14f410d83298?q=80&w=2000&auto=format&fit=crop')",
                title: "Bandung",
                subtitle: "Rental Mobil Bandung",
                location: "Lokasi : Jembatan Pasupati"
            },
            {
                image: "url('gambar/jakarta.jpg')", 
                title: "Jakarta",
                subtitle: "Rental Mobil Jakarta",
                location: "Lokasi : Monumen Nasional"
            },
            {
                image: "url('gambar/jogja.PNG')", 
                title: "Yogyakarta",
                subtitle: "Rental Mobil Yogyakarta",
                location: "Lokasi : Candi Prambanan"
            },
            {
                image: "url('gambar/malang.jpg')", 
                title: "Malang",
                subtitle: "Rental Mobil Malang",
                location: "Lokasi : Gunung Bromo"
            },
            {
                image: "url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=2000&auto=format&fit=crop')", 
                title: "Bali",
                subtitle: "Rental Mobil Bali",
                location: "Lokasi : Pura Ulun Danu"
            }
        ];

        let currentIndex = 0;
        const heroSlider = document.getElementById('hero-slider');
        const promoTitle = document.getElementById('promo-title');
        const promoSubtitle = document.getElementById('promo-subtitle');
        const promoLocation = document.getElementById('promo-location');
        const dotsContainer = document.getElementById('slider-dots-container');

        // Fungsi membuat titik (dots) di bawah slider
        function setupDots() {
            slides.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.classList.add('dot');
                if (index === 0) dot.classList.add('active');
                dot.addEventListener('click', () => goToSlide(index));
                dotsContainer.appendChild(dot);
            });
        }

        // Fungsi Update Tampilan Slider
        function updateSlider() {
            heroSlider.style.backgroundImage = slides[currentIndex].image;
            
            // Efek ganti teks
            promoTitle.style.opacity = '0';
            promoSubtitle.style.opacity = '0';
            promoLocation.style.opacity = '0';
            
            setTimeout(() => {
                promoTitle.textContent = slides[currentIndex].title;
                promoSubtitle.textContent = slides[currentIndex].subtitle;
                promoLocation.textContent = slides[currentIndex].location;
                
                promoTitle.style.opacity = '1';
                promoSubtitle.style.opacity = '1';
                promoLocation.style.opacity = '1';
            }, 300);

            // Update status titik aktif
            document.querySelectorAll('.dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex === slides.length - 1) ? 0 : currentIndex + 1;
            updateSlider();
        }

        function prevSlide() {
            currentIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1;
            updateSlider();
        }

        function goToSlide(index) {
            currentIndex = index;
            updateSlider();
        }

        document.getElementById('btn-next').addEventListener('click', nextSlide);
        document.getElementById('btn-prev').addEventListener('click', prevSlide);

        // Auto-play Slider setiap 5 detik
        setInterval(nextSlide, 5000);

        // Inisialisasi awal
        setupDots();
    </script>
</body>
</html>