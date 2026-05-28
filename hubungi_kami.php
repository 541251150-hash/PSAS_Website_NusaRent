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
$email_user = $_SESSION['email']; // Untuk diisi otomatis di form

// Mengambil data user
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email_user'");

if($row = mysqli_fetch_assoc($query)){
    if(isset($row['firstname']) && !empty($row['firstname'])){
        $nama_user = $row['firstname']; 
    } 
    else if(isset($row['firstName']) && !empty($row['firstName'])){
        $nama_user = $row['firstName']; 
    } 
    else if(isset($row['fName']) && !empty($row['fName'])){
        $nama_user = $row['fName']; 
    }
    else {
        $email_parts = explode("@", $row['email']);
        $nama_user = $email_parts[0];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - NusaRent</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Font Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background-color: #f8f9fa; scroll-behavior: smooth; overflow-x: hidden; }
        .bg-indoloka-blue { background-color: #0076D6; }
        .text-indoloka-blue { color: #0076D6; }
        .btn-indoloka-blue { background-color: #006BFE; }
        .border-indoloka-yellow { border-bottom: 4px solid #FFC107; }
        
        .header-banner {
            background: linear-gradient(rgba(0, 118, 214, 0.85), rgba(0, 118, 214, 0.85)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop') center/cover;
            padding: 100px 0 60px 0;
            color: white;
            text-align: center;
        }

        .contact-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 4px solid #0076D6;
            transition: transform 0.3s ease;
        }
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
            background-color: #fafafa;
        }
        .form-input:focus {
            border-color: #0076D6;
            outline: none;
            background-color: #fff;
        }
        
        .location-item {
            border-left: 3px solid #FFC107;
            padding-left: 15px;
            margin-bottom: 20px;
            background: #fff;
            padding: 15px 15px 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body class="antialiased" id="top">

    <!-- NAVBAR TOP -->
    <nav class="bg-indoloka-blue border-indoloka-yellow text-white w-full fixed top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex items-center space-x-8">
                    <div class="flex flex-col cursor-pointer" onclick="window.location.href='dashboard.php'">
                        <div class="flex items-center text-3xl font-bold tracking-tight">
                            <i class="fa-solid fa-car-side mr-2"></i> NusaRent<span class="text-sm font-normal pt-2">.com</span>
                        </div>
                        <span class="text-xs font-medium tracking-wide">Sewa Mobil Online No 1 di Indonesia</span>
                    </div>
                    
                    <div class="hidden md:flex items-center space-x-6 pt-2">
                        <!-- MENU HOME (Mengarah ke dashboard.php) -->
                        <a href="dashboard.php" class="text-sm font-medium hover:text-gray-200 transition">Home</a>
                        
                        <!-- SEWA MOBIL (Mengarah ke sewa_mobil.php) -->
                        <a href="sewa_mobil.php" class="text-sm font-medium hover:text-gray-200 transition">Sewa Mobil</a>
                        
                        <!-- HUBUNGI KAMI (Posisi Aktif dengan background kotak) -->
                        <a href="hubungi_kami.php" class="bg-blue-500/50 px-3 py-1 rounded text-sm font-medium hover:bg-blue-600 transition">Hubungi Kami</a>
                        
                        <!-- IKON MEDSOS (Konsisten WhatsApp dan Instagram) -->
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
                        <div class="flex items-center hover:opacity-80 transition" id="lang-trigger">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID Flag" id="current-flag" class="mr-2 h-3 border border-gray-300">
                            <span id="current-lang">IND</span> 
                            <i class="fa-solid fa-caret-down ml-1"></i>
                        </div>
                        <div class="absolute hidden group-hover:block pt-3 w-36 right-0 z-50">
                            <div class="bg-white text-black rounded shadow-lg py-2 border border-gray-100">
                                <!-- DIUBAH: Menggunakan href murni tanpa javascript -->
                                <a href="hubungi_kami.php" class="flex items-center px-4 py-2 hover:bg-blue-50 font-semibold transition"><img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="mr-2 h-3 border border-gray-300"> Indonesia</a>
                                <a href="hubungi_kami_eng.php" class="flex items-center px-4 py-2 hover:bg-blue-50 font-semibold transition"><img src="https://flagcdn.com/w20/gb.png" alt="EN Flag" class="mr-2 h-3 border border-gray-300"> English</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- HEADER BANNER -->
    <section class="header-banner mt-20" data-aos="fade-in" data-aos-duration="1000">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4 uppercase tracking-wide">Pusat Layanan Pelanggan</h1>
            <p class="text-lg text-blue-100 max-w-2xl mx-auto">Kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami untuk pertanyaan, keluhan, atau bantuan pemesanan.</p>
        </div>
    </section>

    <!-- KARTU KONTAK CEPAT -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="contact-card text-center" data-aos="fade-up" data-aos-delay="0">
                <div class="w-16 h-16 mx-auto bg-blue-100 text-indoloka-blue rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Layanan Call Center</h3>
                <p class="text-gray-500 text-sm mb-3">Tersedia 24 Jam setiap hari</p>
                <p class="text-2xl font-bold text-indoloka-blue">0881-1336-160</p>
            </div>
            
            <div class="contact-card text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">WhatsApp Resmi</h3>
                <p class="text-gray-500 text-sm mb-3">Chat cepat untuk reservasi</p>
                <p class="text-2xl font-bold text-green-600">0817-7001-3416/p>
            </div>

            <div class="contact-card text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 mx-auto bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Email Bantuan</h3>
                <p class="text-gray-500 text-sm mb-3">Untuk kerjasama & keluhan</p>
                <p class="text-lg font-bold text-gray-800">irvantrans14@gmail.com</p>
            </div>
        </div>
    </section>

    <!-- BAGIAN UTAMA (FORM KONTAK & LOKASI) -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-10">
                
                <!-- KOLOM KIRI: FORMULIR KONTAK -->
                <div class="w-full lg:w-7/12 bg-white p-8 rounded-lg shadow-sm border border-gray-200" data-aos="fade-right">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2 border-b-2 border-indoloka-yellow pb-2 inline-block">Kirim Pesan Langsung</h2>
                    <p class="text-gray-500 text-sm mb-6 mt-2">Isi formulir di bawah ini dan tim Customer Service kami akan membalas pesan Anda maksimal 1x24 Jam.</p>
                    
                    <form action="#" method="POST" onsubmit="alert('Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.'); return false;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap *</label>
                                <input type="text" class="form-input" value="<?php echo htmlspecialchars($nama_user); ?>" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email *</label>
                                <input type="email" class="form-input" value="<?php echo htmlspecialchars($email_user); ?>" readonly style="background-color:#eee; cursor:not-allowed;">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor HP / WhatsApp *</label>
                            <input type="text" class="form-input" placeholder="Contoh: 0812xxxxxx" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Subjek Pesan *</label>
                            <select class="form-input" required>
                                <option value="">-- Pilih Subjek --</option>
                                <option value="Bantuan Sewa">Bantuan Reservasi / Sewa</option>
                                <option value="Keluhan">Keluhan Layanan</option>
                                <option value="Kerjasama">Tawaran Kerjasama / Corporate</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Detail Pesan *</label>
                            <textarea class="form-input" rows="5" placeholder="Tuliskan pertanyaan atau keluhan Anda di sini..." required></textarea>
                        </div>

                        <button type="submit" class="btn-indoloka-blue text-white font-bold py-3 px-8 rounded shadow hover:bg-blue-700 transition transform hover:scale-[1.02]">
                            <i class="fa-regular fa-paper-plane mr-2"></i> KIRIM PESAN
                        </button>
                    </form>
                </div>

                <!-- KOLOM KANAN: LOKASI OPERASIONAL -->
                <div class="w-full lg:w-5/12" data-aos="fade-left">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-indoloka-yellow pb-2 inline-block">Lokasi Garasi / Kantor Cabang</h2>
                    
                    <div class="location-item">
                        <h4 class="font-bold text-lg text-gray-800"><i class="fa-solid fa-building text-indoloka-blue mr-2"></i> Kantor Pusat Jakarta</h4>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">Gedung NusaRent Tower Lt. 5, Jl. Jend. Sudirman Kav. 52, Senayan, Jakarta Selatan, 12190.</p>
                    </div>

                    <div class="location-item">
                        <h4 class="font-bold text-lg text-gray-800"><i class="fa-solid fa-map-pin text-indoloka-blue mr-2"></i> Cabang Bandung</h4>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">Jl. Pasteur No. 11A, Pamoyanan, Kec. Cicendo, Kota Bandung, Jawa Barat 40173.</p>
                    </div>

                    <div class="location-item">
                        <h4 class="font-bold text-lg text-gray-800"><i class="fa-solid fa-map-pin text-indoloka-blue mr-2"></i> Cabang Bali</h4>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">Jl. By Pass Ngurah Rai No. 88, Tuban, Kuta, Kabupaten Badung, Bali 80361.</p>
                    </div>
                    
                    <div class="location-item">
                        <h4 class="font-bold text-lg text-gray-800"><i class="fa-solid fa-map-pin text-indoloka-blue mr-2"></i> Cabang Surabaya</h4>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">Jl. Ahmad Yani No. 288, Gayungan, Kota SBY, Jawa Timur 60235.</p>
                    </div>

                    <!-- Peta Google Maps (Embed) -->
                    <div class="mt-6 border border-gray-200 rounded p-1 bg-white">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.24037562095!2d106.75878436402099!3d-6.229746536098048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1714486518134!5m2!1sid!2sid" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- JEJARING SOSIAL SECTION -->
    <section class="py-12 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-xl font-bold text-gray-800 mb-6 uppercase">Ikuti Berita & Promo di Sosial Media Kami</h2>
            <div class="flex justify-center gap-6">
                <a href="#" class="w-14 h-14 bg-[#25D366] text-white rounded-full flex items-center justify-center text-3xl shadow hover:-translate-y-2 transition duration-300" title="WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="#" class="w-14 h-14 bg-gradient-to-tr from-[#f09433] via-[#e6683c] to-[#bc1888] text-white rounded-full flex items-center justify-center text-2xl shadow hover:-translate-y-2 transition duration-300" title="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="w-14 h-14 bg-[#007bb5] text-white rounded-full flex items-center justify-center text-2xl shadow hover:-translate-y-2 transition duration-300" title="LinkedIn">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
                <a href="#" class="w-14 h-14 bg-[#ff0000] text-white rounded-full flex items-center justify-center text-2xl shadow hover:-translate-y-2 transition duration-300" title="YouTube">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer Simple -->
    <footer class="bg-[#1a2b4c] text-gray-300 py-10 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-white text-xl font-bold mb-4"><i class="fa-solid fa-car-side"></i> NusaRent</h3>
            <p class="text-sm mb-4">Sewa Mobil Online Mudah, Aman, dan Terpercaya di Seluruh Indonesia.</p>
            <p class="text-sm opacity-75">© <?php echo date("Y"); ?> NusaRent (Sewa Mobil Online). All Rights Reserved.</p>
        </div>
    </footer>

    <!-- TOMBOL SCROLL TO TOP -->
    <a href="#top" class="fixed bottom-6 right-6 bg-[#444444] text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg hover:bg-gray-800 transition z-50 hover:-translate-y-1">
        <i class="fa-solid fa-chevron-up text-xl"></i>
    </a>

    <!-- SCRIPT AOS ANIMASI -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50 });
        
        // FUNGSI BAHASA (Sudah dikosongkan karena menggunakan link langsung)
        function changeLanguage() { }
    </script>
</body>
</html>