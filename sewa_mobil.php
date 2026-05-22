<?php
// Memulai session
session_start();

// Mengecek apakah user sudah login
if (!isset($_SESSION['email'])) {
    header("Location: test/index.php");
    exit();
}

// Memanggil koneksi database
include("test/connect.php"); 

$nama_user = "Pelanggan"; // Default

// Mengambil data user berdasarkan email
$email = $_SESSION['email'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if($row = mysqli_fetch_assoc($query)){
    if(isset($row['firstname']) && !empty($row['firstname'])) $nama_user = $row['firstname']; 
    else if(isset($row['firstName']) && !empty($row['firstName'])) $nama_user = $row['firstName']; 
    else if(isset($row['fName']) && !empty($row['fName'])) $nama_user = $row['fName']; 
    else {
        $email_parts = explode("@", $row['email']);
        $nama_user = $email_parts[0];
    }
}

// =========================================================================
// LOGIKA PENCARIAN & DATABASE SEMENTARA (ARRAY)
// =========================================================================

// Menangkap parameter GET dari form pencarian
$lokasi_cari    = isset($_GET['lokasi']) ? $_GET['lokasi'] : '';
$mobil_cari     = isset($_GET['mobil']) ? $_GET['mobil'] : 'semua';
$tanggal_cari   = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$lama_sewa_cari = isset($_GET['lama_sewa']) ? (int)$_GET['lama_sewa'] : 1;
$jumlah_cari    = isset($_GET['jumlah']) ? (int)$_GET['jumlah'] : 1;
$paket_cari     = isset($_GET['paket']) ? $_GET['paket'] : 'semua';

// Data Mobil (Array Multidimensi sebagai Database Sementara)
$data_mobil = [
    [
        'id' => 'avanza', 'nama' => 'Toyota All New Avanza', 'tahun' => '2020-2023',
        'harga' => 450000, 'harga_coret' => 500000, 'gambar' => 'gambar/toyota all new avanza.jpg',
        'penumpang' => 7, 'fitur1' => 'NusaRent car rental', 'fitur2' => 'Pemakaian radius 40 km', 'fitur3' => 'Termasuk Supir / Dropoff'
    ],
    [
        'id' => 'xpander', 'nama' => 'Mitsubishi Xpander', 'tahun' => '2021-2023',
        'harga' => 480000, 'harga_coret' => 550000, 'gambar' => 'gambar/mitshubishi xpander.jpg',
        'penumpang' => 7, 'fitur1' => 'NusaRent car rental', 'fitur2' => 'Pemakaian radius 40 km', 'fitur3' => 'Termasuk Supir / Dropoff'
    ],
    [
        'id' => 'innova_reborn', 'nama' => 'Toyota Innova Reborn', 'tahun' => '2018-2022',
        'harga' => 750000, 'harga_coret' => 850000, 'gambar' => 'gambar/toyota innova reborn.jpg',
        'penumpang' => 7, 'fitur1' => 'NusaRent premium rental', 'fitur2' => 'Dalam & Luar Kota', 'fitur3' => 'Termasuk Supir / Dropoff'
    ],
    [
        'id' => 'alphard', 'nama' => 'Toyota Alphard', 'tahun' => '2021-2024',
        'harga' => 2500000, 'harga_coret' => 0, 'gambar' => 'gambar/toyota alphard.jpg',
        'penumpang' => 7, 'fitur1' => 'Layanan VIP VVIP', 'fitur2' => 'Pemakaian Dalam Kota', 'fitur3' => 'Termasuk Supir Eksklusif'
    ],
    [
        'id' => 'hiace_commuter', 'nama' => 'Toyota Hiace Commuter', 'tahun' => '2019-2022',
        'harga' => 1400000, 'harga_coret' => 0, 'gambar' => 'gambar/toyota hiace.jpg',
        'penumpang' => 15, 'fitur1' => 'Kapasitas Besar (15 Orang)', 'fitur2' => 'Pemakaian Tour / Wisata', 'fitur3' => 'Termasuk Supir Pariwisata'
    ],
    [
        'id' => 'hiace_premio', 'nama' => 'Toyota Hiace Premio', 'tahun' => '2022-2024',
        'harga' => 1800000, 'harga_coret' => 0, 'gambar' => 'gambar/toyota hiace premio.jpg',
        'penumpang' => 12, 'fitur1' => 'Eksekutif Van (Captain Seat)', 'fitur2' => 'Tour Mewah Keluarga', 'fitur3' => 'Termasuk Supir Profesional'
    ],
    [
        'id' => 'pajero', 'nama' => 'Mitsubishi Pajero Sport', 'tahun' => '2021-2023',
        'harga' => 1500000, 'harga_coret' => 0, 'gambar' => 'gambar/mitshubishi pajero.jpg',
        'penumpang' => 7, 'fitur1' => 'SUV Premium Tangguh', 'fitur2' => 'Cocok Segala Medan', 'fitur3' => 'Termasuk Supir'
    ],
    [
        'id' => 'xenia', 'nama' => 'Daihatsu All New Xenia', 'tahun' => '2022-2024',
        'harga' => 350000, 'harga_coret' => 450000, 'gambar' => 'gambar/daihatsu all newxenia.jpg',
        'penumpang' => 7, 'fitur1' => 'Mobil Keluarga Ekonomis', 'fitur2' => 'Hemat Bahan Bakar', 'fitur3' => 'Lepas Kunci / Dengan Supir'
    ],
    [
        'id' => 'raize', 'nama' => 'Toyota Raize', 'tahun' => '2022-2023',
        'harga' => 450000, 'harga_coret' => 0, 'gambar' => 'gambar/toyota raize.jpg',
        'penumpang' => 5, 'fitur1' => 'Compact SUV Kekinian', 'fitur2' => 'Lincah di Perkotaan', 'fitur3' => 'Lepas Kunci Tersedia'
    ],
    [
        'id' => 'rush', 'nama' => 'Toyota Rush GR Sport', 'tahun' => '2021-2023',
        'harga' => 550000, 'harga_coret' => 0, 'gambar' => 'gambar/toyota rush.jpg',
        'penumpang' => 7, 'fitur1' => 'SUV Sporty 7 Penumpang', 'fitur2' => 'Ground Clearance Tinggi', 'fitur3' => 'Termasuk Supir'
    ],
    [
        'id' => 'veloz', 'nama' => 'Toyota All New Veloz', 'tahun' => '2022-2024',
        'harga' => 500000, 'harga_coret' => 0, 'gambar' => 'gambar/toyota veloz.jpg',
        'penumpang' => 7, 'fitur1' => 'MPV Nyaman & Canggih', 'fitur2' => 'Nyaman Perjalanan Jauh', 'fitur3' => 'Termasuk Supir'
    ],
    [
        'id' => 'zenix', 'nama' => 'Toyota Innova Zenix Hybrid', 'tahun' => '2023-2024',
        'harga' => 900000, 'harga_coret' => 0, 'gambar' => 'gambar/toyota zenix.jpg',
        'penumpang' => 7, 'fitur1' => 'Kabin Senyap & Luas', 'fitur2' => 'Hemat BBM (Hybrid)', 'fitur3' => 'Termasuk Supir Eksklusif'
    ]
];

// Looping untuk memfilter mobil berdasarkan pencarian (Mobil yang dipilih)
$hasil_pencarian = [];
foreach ($data_mobil as $mobil) {
    // Jika user mencari mobil spesifik dan bukan "semua"
    if (!empty($mobil_cari) && $mobil_cari != 'semua') {
        if ($mobil['id'] != $mobil_cari) continue; // Skip jika tidak cocok
    }
    
    // Perhitungan harga dinamis = harga satuan x lama hari x jumlah mobil
    $total_bayar = $mobil['harga'] * $lama_sewa_cari * $jumlah_cari;
    
    // Masukkan data harga akhir ke array mobil ini
    $mobil['total_bayar'] = $total_bayar;
    $hasil_pencarian[] = $mobil;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sewa Mobil Dinamis - NusaRent</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background-color: #f9f9f9; scroll-behavior: smooth; overflow-x: hidden; }
        .bg-indoloka-blue { background-color: #0076D6; }
        .border-indoloka-yellow { border-bottom: 4px solid #FFC107; }

        /* Form Pencarian */
        .search-box-glass { background-color: #ffffff; padding: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-radius: 8px; border: 1px solid #e5e7eb; }
        .search-box-header { font-style: italic; font-weight: bold; color: #333; margin-bottom: 15px; display: inline-block; width: 100%; border-bottom: 2px solid #ccc; padding-bottom: 8px; font-size: 1.2rem; }
        .input-group { position: relative; margin-bottom: 15px; }
        .input-group i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #0076D6; }
        .input-group input, .input-group select { width: 100%; padding: 10px 10px 10px 38px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px; outline: none; background-color: #f9fafb; transition: border-color 0.2s; }
        .input-group input:focus, .input-group select:focus { border-color: #0076D6; background-color: #ffffff; }
        .form-label { font-size: 13px; font-weight: 700; color: #4b5563; margin-bottom: 6px; display: block; }
        select { appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 10px center; background-size: 1em; }
    </style>
</head>
<body class="antialiased" id="top">

    <!-- NAVBAR TOP -->
    <nav class="bg-indoloka-blue border-indoloka-yellow text-white w-full fixed top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-8">
                    <a href="dashboard.php" class="flex flex-col cursor-pointer hover:opacity-90 transition">
                        <div class="flex items-center text-3xl font-bold tracking-tight">
                            <i class="fa-solid fa-car-side mr-2"></i> NusaRent<span class="text-sm font-normal pt-2">.com</span>
                        </div>
                        <span class="text-xs font-medium tracking-wide">Sewa Mobil Online No 1 di Indonesia</span>
                    </a>
                    
                    <div class="hidden md:flex items-center space-x-6 pt-2">
                        <a href="dashboard.php" class="text-sm font-medium hover:text-gray-200 transition">Home</a>
                        <a href="sewa_mobil.php" class="bg-blue-500/50 px-3 py-1 rounded text-sm font-medium hover:bg-blue-600 transition">Sewa Mobil</a>
                        <a href="hubungi_kami.php" class="text-sm font-medium hover:text-gray-200 transition">Hubungi Kami</a>
                        <div class="flex items-center space-x-3 text-lg border-l border-white/30 pl-4 ml-2">
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-whatsapp"></i></a>
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-6 pt-2 text-sm font-medium">
                    <div class="relative group cursor-pointer">
                        <div class="flex items-center hover:opacity-80 transition">
                            <span class="uppercase">HALO, <?php echo htmlspecialchars($nama_user); ?></span> 
                            <i class="fa-solid fa-caret-down ml-1"></i>
                        </div>
                        <div class="absolute hidden group-hover:block pt-3 w-32 right-0 z-50">
                            <div class="bg-white text-black rounded shadow-lg p-2 border border-gray-100">
                                <a href="test/logout.php" class="block px-4 py-2 hover:bg-gray-100 text-red-600 font-bold transition rounded"><i class="fa-solid fa-sign-out-alt"></i> Keluar</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative group cursor-pointer">
                        <div class="flex items-center hover:opacity-80 transition">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="mr-2 h-3 border border-gray-300">
                            IND <i class="fa-solid fa-caret-down ml-1"></i>
                        </div>
                        <div class="absolute hidden group-hover:block pt-3 w-36 right-0 z-50">
                            <div class="bg-white text-black rounded shadow-lg py-2 border border-gray-100">
                                <a href="sewa_mobil.php" class="flex items-center px-4 py-2 hover:bg-blue-50 font-semibold transition"><img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="mr-2 h-3 border border-gray-300"> Indonesia</a>
                                <a href="sewa_mobil_eng.php" class="flex items-center px-4 py-2 hover:bg-blue-50 font-semibold transition"><img src="https://flagcdn.com/w20/gb.png" alt="EN Flag" class="mr-2 h-3 border border-gray-300"> English</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- HEADER & FORM PENCARIAN DINAMIS -->
    <section class="pt-28 pb-12 bg-[#005ea6]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-down" data-aos-duration="800">
            <div class="search-box-glass">
                <div class="search-box-header">Ubah Kriteria Pencarian Anda</div>
                
                <form action="sewa_mobil.php" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Lokasi Penjemputan -->
                        <div>
                            <label class="form-label">Lokasi Penjemputan</label>
                            <div class="input-group">
                                <i class="fa-solid fa-location-dot"></i>
                                <select name="lokasi">
                                    <option value="bandung" <?php if($lokasi_cari == 'bandung') echo 'selected'; ?>>BANDUNG</option>
                                    <option value="jakarta" <?php if($lokasi_cari == 'jakarta') echo 'selected'; ?>>JAKARTA</option>
                                    <option value="bali" <?php if($lokasi_cari == 'bali') echo 'selected'; ?>>BALI</option>
                                    <option value="malang" <?php if($lokasi_cari == 'malang') echo 'selected'; ?>>MALANG</option>
                                    <option value="yogyakarta" <?php if($lokasi_cari == 'yogyakarta') echo 'selected'; ?>>YOGYAKARTA</option>
                                    <option value="surabaya" <?php if($lokasi_cari == 'surabaya') echo 'selected'; ?>>SURABAYA</option>
                                </select>
                            </div>
                        </div>

                        <!-- Jenis Mobil -->
                        <div>
                            <label class="form-label">Jenis Mobil Sewa</label>
                            <div class="input-group">
                                <i class="fa-solid fa-car"></i>
                                <select name="mobil">
                                    <option value="semua" <?php if($mobil_cari == 'semua' || $mobil_cari == '') echo 'selected'; ?>>-- Semua Jenis Mobil --</option>
                                    <option value="avanza" <?php if($mobil_cari == 'avanza') echo 'selected'; ?>>Toyota All New Avanza</option>
                                    <option value="xpander" <?php if($mobil_cari == 'xpander') echo 'selected'; ?>>Mitsubishi Xpander</option>
                                    <option value="innova_reborn" <?php if($mobil_cari == 'innova_reborn') echo 'selected'; ?>>Toyota Innova Reborn</option>
                                    <option value="alphard" <?php if($mobil_cari == 'alphard') echo 'selected'; ?>>Toyota Alphard</option>
                                    <option value="hiace_commuter" <?php if($mobil_cari == 'hiace_commuter') echo 'selected'; ?>>Toyota Hiace Commuter</option>
                                    <option value="hiace_premio" <?php if($mobil_cari == 'hiace_premio') echo 'selected'; ?>>Toyota Hiace Premio</option>
                                    <option value="pajero" <?php if($mobil_cari == 'pajero') echo 'selected'; ?>>Mitsubishi Pajero Sport</option>
                                    <option value="xenia" <?php if($mobil_cari == 'xenia') echo 'selected'; ?>>Daihatsu All New Xenia</option>
                                    <option value="raize" <?php if($mobil_cari == 'raize') echo 'selected'; ?>>Toyota Raize</option>
                                    <option value="rush" <?php if($mobil_cari == 'rush') echo 'selected'; ?>>Toyota Rush GR Sport</option>
                                    <option value="veloz" <?php if($mobil_cari == 'veloz') echo 'selected'; ?>>Toyota All New Veloz</option>
                                    <option value="zenix" <?php if($mobil_cari == 'zenix') echo 'selected'; ?>>Toyota Innova Zenix Hybrid</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Tanggal -->
                        <div>
                            <label class="form-label">Tanggal Sewa</label>
                            <div class="input-group">
                                <i class="fa-regular fa-calendar-days"></i>
                                <input type="date" name="tanggal" class="!pl-[38px]" value="<?php echo htmlspecialchars($tanggal_cari); ?>" required> 
                            </div>
                        </div>
                        
                        <!-- Lama Sewa -->
                        <div>
                            <label class="form-label">Lama Sewa</label>
                            <div class="input-group">
                                <i class="fa-regular fa-clock"></i>
                                <select name="lama_sewa">
                                    <option value="1" <?php if($lama_sewa_cari == 1) echo 'selected'; ?>>1 Hari</option>
                                    <option value="2" <?php if($lama_sewa_cari == 2) echo 'selected'; ?>>2 Hari</option>
                                    <option value="3" <?php if($lama_sewa_cari == 3) echo 'selected'; ?>>3 Hari</option>
                                </select>
                            </div>
                        </div>

                        <!-- Jumlah Unit -->
                        <div>
                            <label class="form-label">Jumlah Unit</label>
                            <div class="input-group">
                                <i class="fa-solid fa-car"></i>
                                <select name="jumlah">
                                    <option value="1" <?php if($jumlah_cari == 1) echo 'selected'; ?>>1 Unit</option>
                                    <option value="2" <?php if($jumlah_cari == 2) echo 'selected'; ?>>2 Unit</option>
                                    <option value="3" <?php if($jumlah_cari == 3) echo 'selected'; ?>>3 Unit</option>
                                </select>
                            </div>
                        </div>

                        <!-- Paket -->
                        <div>
                            <label class="form-label">Paket</label>
                            <div class="input-group">
                                <i class="fa-solid fa-box"></i>
                                <select name="paket">
                                    <option value="semua" <?php if($paket_cari == 'semua') echo 'selected'; ?>>Semua Paket</option>
                                    <option value="lepas_kunci" <?php if($paket_cari == 'lepas_kunci') echo 'selected'; ?>>Lepas Kunci</option>
                                    <option value="all_in" <?php if($paket_cari == 'all_in') echo 'selected'; ?>>All In</option>
                                    <option value="diluar_operasional" <?php if($paket_cari == 'diluar_operasional') echo 'selected'; ?>>Diluar Biaya Operasional</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Search -->
                    <div class="mt-2">
                        <button type="submit" class="w-full bg-[#ff9800] text-white font-bold py-3 px-4 rounded shadow hover:bg-[#e68a00] transition transform hover:scale-[1.01] flex items-center justify-center gap-2">
                            <i class="fa-solid fa-magnifying-glass"></i> TEMUKAN MOBIL
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- HASIL PENCARIAN: LOOPING DINAMIS ARRAY PHP -->
    <section id="daftar-mobil" class="pb-20 pt-8 bg-[#f9f9f9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold text-gray-800" data-aos="fade-right">
                    <!-- Menampilkan jumlah mobil yang ditemukan secara dinamis -->
                    <?php echo count($hasil_pencarian); ?> MOBIL DITEMUKAN
                </h2>
                <div class="flex items-center gap-2 text-sm text-gray-600" data-aos="fade-left">
                    <span class="font-medium">Urutkan berdasarkan:</span>
                    <select class="border border-gray-300 rounded px-3 py-1.5 bg-white outline-none cursor-pointer focus:border-blue-500">
                        <option>Harga Termurah</option>
                        <option>Rekomendasi</option>
                    </select>
                </div>
            </div>

            <?php if (count($hasil_pencarian) > 0): ?>
                
                <!-- MEMULAI LOOPING MOBIL (1 KODE UNTUK SEMUA) -->
                <?php foreach ($hasil_pencarian as $index => $car): ?>
                
                <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="<?php echo ($index % 3) * 100; ?>">
                    
                    <!-- Area Gambar -->
                    <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                        <img src="<?php echo $car['gambar']; ?>" alt="<?php echo $car['nama']; ?>" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500 mix-blend-multiply">
                    </div>
                    
                    <!-- Area Deskripsi & Fitur -->
                    <div class="w-full md:w-1/2 flex flex-col justify-center">
                        <h3 class="text-2xl font-bold text-gray-800"><?php echo $car['nama']; ?></h3>
                        
                        <!-- Keterangan Tambahan berdasarkan form (Lokasi/Tanggal) -->
                        <p class="text-gray-500 text-sm mb-4">
                            Tahun Mobil <?php echo $car['tahun']; ?> 
                            <?php if(!empty($lokasi_cari)): ?> | Lokasi Penjemputan: <strong class="text-blue-600 uppercase"><?php echo htmlspecialchars($lokasi_cari); ?></strong> <?php endif; ?>
                            <?php if(!empty($tanggal_cari)): ?> | Tanggal: <strong class="text-blue-600"><?php echo date("d M Y", strtotime($tanggal_cari)); ?></strong> <?php endif; ?>
                        </p>
                        
                        <!-- Ikon Fasilitas -->
                        <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                            <i class="fa-solid fa-snowflake" title="AC"></i>
                            <i class="fa-solid fa-users" title="<?php echo $car['penumpang']; ?> Penumpang"></i>
                            <i class="fa-solid fa-suitcase" title="Kapasitas Bagasi"></i>
                            <i class="fa-solid fa-gas-pump" title="Bahan Bakar"></i>
                        </div>
                        
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> <?php echo $car['fitur1']; ?></li>
                            <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> <?php echo $car['fitur2']; ?></li>
                            <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> <?php echo $car['fitur3']; ?></li>
                        </ul>
                    </div>
                    
                    <!-- Area Harga & Pesan -->
                    <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                        <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                        
                        <?php if ($car['harga_coret'] > 0): ?>
                            <p class="text-xs text-gray-400 line-through mb-1">Rp. <?php echo number_format($car['harga_coret'], 0, ',', '.'); ?></p>
                        <?php endif; ?>
                        
                        <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. <?php echo number_format($car['harga'], 0, ',', '.'); ?> <span class="text-xs font-normal text-gray-500">/ 12 Jam</span></p>
                        
                        <!-- Perhitungan Dinamis Dimunculkan Disini -->
                        <div class="text-xs text-gray-500 mb-5 bg-gray-50 p-2 rounded w-full border border-gray-100 text-right">
                            <?php echo $lama_sewa_cari; ?> Hari &times; <?php echo $jumlah_cari; ?> Unit <br>
                            <span class="font-bold text-gray-800 text-sm">Total: Rp. <?php echo number_format($car['total_bayar'], 0, ',', '.'); ?></span>
                        </div>
                        
                        <button onclick="alert('Pesanan untuk <?php echo $car['nama']; ?> telah masuk ke keranjang!')" class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">PESAN SEKARANG</button>
                    </div>
                </div>

                <?php endforeach; ?>
                <!-- SELESAI LOOPING -->

            <?php else: ?>
                <!-- Menampilkan Notifikasi jika Mobil Tidak Ditemukan -->
                <div class="bg-red-50 border border-red-200 text-red-600 px-6 py-10 rounded-lg text-center shadow-sm">
                    <i class="fa-solid fa-car-burst text-5xl mb-4 text-red-300"></i>
                    <h3 class="text-xl font-bold mb-2">Maaf, Mobil Tidak Ditemukan</h3>
                    <p>Mobil dengan kriteria yang Anda cari tidak tersedia untuk saat ini. Silakan coba mengubah tanggal atau pilih jenis mobil lain.</p>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- Footer Simple -->
    <footer class="bg-[#1a2b4c] text-gray-300 py-10 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-white text-xl font-bold mb-4"><i class="fa-solid fa-car-side"></i> NusaRent</h3>
            <p class="text-sm mb-4">Sewa Mobil Online Mudah, Aman, dan Terpercaya di Seluruh Indonesia.</p>
            <p class="text-sm opacity-75">© <?php echo date("Y"); ?> NusaRent. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- TOMBOL SCROLL TO TOP -->
    <a href="#top" class="fixed bottom-6 right-6 bg-[#444444] text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg hover:bg-gray-800 transition z-50 hover:-translate-y-1">
        <i class="fa-solid fa-chevron-up text-xl"></i>
    </a>

    <!-- SCRIPT AOS ANIMASI -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Inisialisasi AOS
        AOS.init({ once: true, offset: 50 });
    </script>
</body>
</html>