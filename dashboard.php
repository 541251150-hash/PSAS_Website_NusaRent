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
            background-color: rgba(255, 255, 255, 0.85);
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: relative;
        }
        
        /* Pita / Label di atas form */
        .search-box-header {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 8px 12px;
            font-style: italic;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
            display: inline-block;
            width: 100%;
            border-bottom: 2px solid #ccc;
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
            background-image: url('https://images.unsplash.com/photo-1549473889-14f410d83298?q=80&w=2000&auto=format&fit=crop'); /* Gambar Bandung HD */
            background-size: cover;
            /* DIUBAH: Fokus ke tengah dan tinggi disesuaikan persis gambar */
            background-position: center; 
            height: 520px; 
            position: relative;
            transition: background-image 0.6s ease-in-out; /* Animasi pergantian gambar */
        }

        /* Efek gelap di slider agar form kiri terbaca tapi kanan tetap cerah */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.2) 40%, rgba(0,0,0,0) 100%);
        }

        /* Navigasi Panah Kiri Kanan */
        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 40px;
            cursor: pointer;
            text-shadow: 0 2px 6px rgba(0,0,0,0.6);
            opacity: 0.8;
            z-index: 30;
            transition: opacity 0.3s, transform 0.2s;
        }
        .slider-arrow:hover { 
            opacity: 1; 
            transform: translateY(-50%) scale(1.1);
        }
        .arrow-left { left: 30px; }
        .arrow-right { right: 30px; }

        /* Titik Navigasi Bawah */
        .slider-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 30;
        }
        .dot {
            width: 12px;
            height: 12px;
            background-color: rgba(255,255,255,0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .dot.active { background-color: white; box-shadow: 0 0 5px rgba(0,0,0,0.5); }
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
                    <!-- Sapaan User -->
                    <div class="relative group cursor-pointer">
                        <span class="uppercase">HALO, <?php echo htmlspecialchars($nama_user); ?> <i class="fa-solid fa-caret-down ml-1"></i></span>
                        <!-- Dropdown Logout -->
                        <div class="absolute hidden group-hover:block bg-white text-black mt-2 rounded shadow-lg p-2 w-32 right-0 z-50">
                            <a href="test/logout.php" class="block px-4 py-2 hover:bg-gray-100 text-red-600 font-bold"><i class="fa-solid fa-sign-out-alt"></i> Keluar</a>
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
    <section class="hero-slider" id="hero-slider">
        <div class="hero-overlay"></div>
        
        <!-- Panah Kiri & Kanan -->
        <i class="fa-solid fa-angle-left slider-arrow arrow-left" id="btn-prev"></i>
        <i class="fa-solid fa-angle-right slider-arrow arrow-right" id="btn-next"></i>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative">
            
            <!-- FORM PENCARIAN (Kiri) -->
            <div class="absolute top-1/2 -translate-y-1/2 left-0 md:left-4 w-full md:w-[420px] px-4 md:px-0 z-20">
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

            <!-- PROMO TEXT (Kanan - Dipusatkan di sisa ruang) -->
            <!-- w-[55%] dan right-0 membuat teks ini mengambil 55% ruang sebelah kanan, jadi tampil pas di tengah-tengah bagian yang kosong -->
            <div class="hidden md:flex absolute top-1/2 -translate-y-1/2 right-0 w-[55%] flex-col items-center justify-center text-white text-center z-20">
                <h2 id="promo-title" class="text-[3.5rem] font-bold drop-shadow-lg mb-1 transition-all duration-300">Bandung</h2>
                <h3 id="promo-subtitle" class="text-2xl drop-shadow-md mb-6 transition-all duration-300">Rental Mobil Bandung</h3>
                <a href="#" class="btn-indoloka-blue px-8 py-3 text-xl font-bold shadow-lg hover:bg-blue-700 transition">BOOK NOW !</a>
            </div>

            <!-- TEKS LOKASI BAWAH KANAN (Seperti referensi gambar Bromo) -->
            <div id="promo-location" class="absolute bottom-5 right-0 text-white text-lg font-medium italic drop-shadow-lg z-20">
                Lokasi : Jembatan Pasupati
            </div>

        </div>

        <!-- Pagination Dots Bawah -->
        <div class="slider-dots" id="slider-dots-container">
            <!-- Dots diisi oleh JavaScript -->
        </div>
    </section>

    <!-- KONTEN BAWAH (AYO JALAN - JALAN) -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg font-bold text-gray-800 mb-6 uppercase border-b border-gray-300 pb-2 inline-block">AYO JALAN - JALAN KE KOTA MENARIK INI</h2>
            
            <!-- GRID 6 KOTA SESUAI DESAIN -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
                
                <!-- Card 1: Jakarta -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="gambar/jakarta.jpg" alt="Jakarta" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center">
                        <p class="text-white text-2xl font-normal tracking-wide">Jakarta</p>
                        <p class="text-gray-300 text-xs italic mt-1">Lebih dari 400 rental</p>
                    </div>
                </div>

                <!-- Card 2: Bali -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800&auto=format&fit=crop" alt="Bali" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center">
                        <p class="text-white text-2xl font-normal tracking-wide">Bali</p>
                        <p class="text-gray-300 text-xs italic mt-1">Lebih dari 400 rental</p>
                    </div>
                </div>

                <!-- Card 3: Bandung -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1549473889-14f410d83298?q=80&w=800&auto=format&fit=crop" alt="Bandung" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center">
                        <p class="text-white text-2xl font-normal tracking-wide">Bandung</p>
                        <p class="text-gray-300 text-xs italic mt-1">Lebih dari 400 rental</p>
                    </div>
                </div>

                <!-- Card 4: Malang -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="gambar/malang.jpg" alt="Malang" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center">
                        <p class="text-white text-2xl font-normal tracking-wide">Malang</p>
                        <p class="text-gray-300 text-xs italic mt-1">Lebih dari 400 rental</p>
                    </div>
                </div>

                <!-- Card 5: Yogyakarta -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="gambar/jogja.jpg" alt="Yogyakarta" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center">
                        <p class="text-white text-2xl font-normal tracking-wide">Yogyakarta</p>
                        <p class="text-gray-300 text-xs italic mt-1">Lebih dari 400 rental</p>
                    </div>
                </div>

                <!-- Card 6: Surabaya -->
                <div class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=800&auto=format&fit=crop" alt="Surabaya" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center">
                        <p class="text-white text-2xl font-normal tracking-wide">Surabaya</p>
                        <p class="text-gray-300 text-xs italic mt-1">Lebih dari 400 rental</p>
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

    <!-- JAVASCRIPT UNTUK ANIMASI SLIDER -->
    <script>
        // Data untuk masing-masing slide 
        // Ditambahkan lokasi agar tulisan pojok kanan bawah ikut berubah
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