<?php
// Start session to get logged-in user data
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page in the test folder
    header("Location: test/index.php");
    exit();
}

// Include database connection
include("test/connect.php"); 

$nama_user = "Customer"; // Default

// Get user data based on email stored in session
$email = $_SESSION['email'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No 1 Online Car Rental in Indonesia - NusaRent</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Roboto Font to match Indoloka style -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- AOS CSS (Scroll Animation) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background-color: #ffffff; scroll-behavior: smooth; overflow-x: hidden; }
        .bg-indoloka-blue { background-color: #0076D6; }
        .btn-indoloka-blue { background-color: #006BFE; }
        

        /* Search Form */
        .search-box-glass { background-color: rgba(255, 255, 255, 0.85); padding: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); position: relative; }
        .search-box-header { background-color: rgba(255, 255, 255, 0.95); padding: 8px 12px; font-style: italic; font-weight: bold; color: #555; margin-bottom: 10px; display: inline-block; width: 100%; border-bottom: 2px solid #ccc; }
        .input-group { position: relative; margin-bottom: 12px; }
        .input-group i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #0076D6; }
        .input-group input, .input-group select { width: 100%; padding: 8px 10px 8px 35px; border: 1px solid #ccc; border-radius: 2px; font-size: 14px; outline: none; background-color: #fff; }
        .input-group input:focus, .input-group select:focus { border-color: #0076D6; }
        .form-label { font-size: 13px; font-weight: 600; color: #333; margin-bottom: 4px; display: block; }

        select { appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 10px center; background-size: 1em; }

        /* Hero Image Slider */
        .hero-slider { background-image: url('https://images.unsplash.com/photo-1549473889-14f410d83298?q=80&w=2000&auto=format&fit=crop'); background-size: cover; background-position: center 20%; height: 520px; position: relative; transition: background-image 0.6s ease-in-out; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.2) 40%, rgba(0,0,0,0) 100%); }
        .slider-arrow { position: absolute; top: 50%; transform: translateY(-50%); color: white; font-size: 40px; cursor: pointer; text-shadow: 0 2px 6px rgba(0,0,0,0.6); opacity: 0.8; z-index: 30; transition: opacity 0.3s, transform 0.2s; }
        .slider-arrow:hover { opacity: 1; transform: translateY(-50%) scale(1.1); }
        .arrow-left { left: 30px; } .arrow-right { right: 30px; }
        .slider-dots { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 30; }
        .dot { width: 12px; height: 12px; background-color: rgba(255,255,255,0.5); border-radius: 50%; cursor: pointer; transition: background-color 0.3s; }
        .dot.active { background-color: white; box-shadow: 0 0 5px rgba(0,0,0,0.5); }

        /* =========================================================
           ADDITIONAL EFFECTS FOR FLEET SHOWCASE ANIMATION
           ========================================================= */
        .tab-btn {
            position: relative;
            transition: all 0.3s ease;
            background: transparent;
            border: none;
        }
        .tab-btn::after {
            content: ''; position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%);
            width: 0; height: 3px; background-color: #0076D6; border-radius: 4px; transition: all 0.3s ease;
        }
        .tab-btn.active { color: #0076D6; font-weight: 700; }
        .tab-btn.active::after { width: 100%; }
        
        .car-showcase-enter { 
            animation: carEnter 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; 
        }
        @keyframes carEnter {
            0% { opacity: 0; transform: scale(0.85) translateX(50px); filter: blur(4px); }
            100% { opacity: 1; transform: scale(1) translateX(0); filter: blur(0); }
        }
        
        .stage-floor {
            transform: rotateX(70deg);
            background: radial-gradient(ellipse at center, rgba(0, 118, 214, 0.2) 0%, transparent 70%);
        }
    </style>
</head>
<body class="antialiased" id="top">

    <!-- TOP NAVBAR -->
    <nav class="bg-indoloka-blue border-indoloka-yellow text-white w-full fixed top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex items-center space-x-8">
                    <div class="flex flex-col cursor-pointer" data-aos="fade-right" onclick="window.location.href='dashboard_eng.php'">
                        <div class="flex items-center text-3xl font-bold tracking-tight">
                            <i class="fa-solid fa-car-side mr-2"></i> NusaRent<span class="text-sm font-normal pt-2">.com</span>
                        </div>
                        <span class="text-xs font-medium tracking-wide">No 1 Online Car Rental in Indonesia</span>
                    </div>
                    
                    <div class="hidden md:flex items-center space-x-6 pt-2" data-aos="fade-down" data-aos-delay="100">
                        <a href="dashboard_eng.php" class="text-sm font-medium hover:text-gray-200 transition">Home</a>
                        <a href="sewa_mobil_eng.php" class="bg-blue-500/50 px-3 py-1 rounded text-sm font-medium hover:bg-blue-600 transition">Car Rental</a>
                        <a href="hubungi_kami_eng.php" class="text-sm font-medium hover:text-gray-200 transition">Contact Us</a>
                        <div class="flex items-center space-x-3 text-lg border-l border-white/30 pl-4 ml-2">
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-whatsapp"></i></a>
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-6 pt-2 text-sm font-medium" data-aos="fade-left">
                    <div class="relative group cursor-pointer">
                        <div class="flex items-center hover:opacity-80 transition">
                            <span class="uppercase">HELLO, <?php echo htmlspecialchars($nama_user); ?></span> 
                            <i class="fa-solid fa-caret-down ml-1"></i>
                        </div>
                        <div class="absolute hidden group-hover:block pt-3 w-32 right-0 z-50">
                            <div class="bg-white text-black rounded shadow-lg p-2 border border-gray-100">
                                <a href="test/logout.php" class="block px-4 py-2 hover:bg-gray-100 text-red-600 font-bold transition rounded"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative group cursor-pointer">
                        <div class="flex items-center hover:opacity-80 transition" id="lang-trigger">
                            <img src="https://flagcdn.com/w20/gb.png" alt="EN Flag" id="current-flag" class="mr-2 h-3 border border-gray-300">
                            <span id="current-lang">ENG</span> 
                            <i class="fa-solid fa-caret-down ml-1"></i>
                        </div>
                        <div class="absolute hidden group-hover:block pt-3 w-36 right-0 z-50">
                            <div class="bg-white text-black rounded shadow-lg py-2 border border-gray-100">
                                <a href="dashboard.php" class="flex items-center px-4 py-2 hover:bg-blue-50 font-semibold transition"><img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="mr-2 h-3 border border-gray-300"> Indonesia</a>
                                <a href="dashboard_eng.php" class="flex items-center px-4 py-2 hover:bg-blue-50 font-semibold transition"><img src="https://flagcdn.com/w20/gb.png" alt="EN Flag" class="mr-2 h-3 border border-gray-300"> English</a>
                            </div>
                        </div>
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
            
            <div class="absolute top-6 md:top-10 left-0 md:left-4 w-full md:w-[420px] px-4 md:px-0 z-20" data-aos="fade-right" data-aos-duration="1000">
                <div class="search-box-glass">
                    <div class="search-box-header">
                        NusaRent Car Rental
                    </div>
                    
                    <form action="sewa_mobil_eng.php" method="GET">
                        <!-- Pick-up Location -->
                        <div class="mb-3">
                            <label class="form-label">Pick-up Location</label>
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

                        <!-- Car Type -->
                        <div class="mb-3">
                            <label class="form-label">Rental Car Type</label>
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

                        <!-- Date & Duration -->
                        <div class="flex gap-2 mb-3">
                            <div class="w-1/2">
                                <label class="form-label">Rental Date</label>
                                <div class="input-group">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <input type="date" name="tanggal" class="!pl-[35px] !pr-[5px]"> 
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label class="form-label">Duration</label>
                                <div class="input-group">
                                    <i class="fa-regular fa-clock"></i>
                                    <select name="lama_sewa">
                                        <option value="1">1 Day</option>
                                        <option value="2">2 Days</option>
                                        <option value="3">3 Days</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Units & Package -->
                        <div class="flex gap-2 mb-4">
                            <div class="w-1/2">
                                <label class="form-label">Number of Units</label>
                                <div class="input-group">
                                    <i class="fa-solid fa-car"></i>
                                    <select name="jumlah">
                                        <option value="1">1 Unit</option>
                                        <option value="2">2 Units</option>
                                        <option value="3">3 Units</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label class="form-label">Package</label>
                                <div class="input-group">
                                    <i class="fa-solid fa-box"></i>
                                    <select name="paket">
                                        <option value="semua">All Packages</option>
                                        <option value="lepas_kunci">Self Drive</option>
                                        <option value="all_in">All In</option>
                                        <option value="diluar_operasional">Exclude Operational Costs</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-indoloka-blue text-white font-bold py-3 px-4 flex items-center justify-center gap-2 hover:bg-blue-700 transition transform hover:scale-[1.02]">
                            SEARCH NOW <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- PROMO TEXT Right Center -->
            <div class="hidden md:flex absolute top-1/2 -translate-y-1/2 right-0 w-[55%] flex-col items-center justify-center text-white text-center z-20" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                <h2 id="promo-title" class="text-[3.5rem] font-bold drop-shadow-lg mb-1 transition-all duration-300">Bandung</h2>
                <h3 id="promo-subtitle" class="text-2xl drop-shadow-md mb-6 transition-all duration-300">Bandung Car Rental</h3>
                <a href="sewa_mobil_eng.php" class="btn-indoloka-blue px-8 py-3 text-xl font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1">BOOK NOW !</a>
            </div>

            <div id="promo-location" class="absolute bottom-5 right-0 text-white text-lg font-medium italic drop-shadow-lg z-20">
                Location : Pasupati Bridge
            </div>

        </div>

        <div class="slider-dots" id="slider-dots-container"></div>
    </section>

    <!-- BOTTOM CONTENT (LET'S TRAVEL) -->
    <section class="py-12 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg font-bold text-gray-800 mb-6 uppercase border-b border-gray-300 pb-2 inline-block" data-aos="fade-up">LET'S TRAVEL TO THESE INTERESTING CITIES</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
                <a href="sewa_mobil_eng.php" class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="0">
                    <img src="gambar/jakarta.jpg" alt="Jakarta" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Jakarta</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">More than 400 rentals</p></div>
                </a>

                <a href="sewa_mobil_eng.php" class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800&auto=format&fit=crop" alt="Bali" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Bali</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">More than 400 rentals</p></div>
                </a>

                <a href="sewa_mobil_eng.php" class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1549473889-14f410d83298?q=80&w=800&auto=format&fit=crop" alt="Bandung" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Bandung</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">More than 400 rentals</p></div>
                </a>

                <a href="sewa_mobil_eng.php" class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="0">
                    <img src="gambar/malang.jpg" alt="Malang" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Malang</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">More than 400 rentals</p></div>
                </a>

                <a href="sewa_mobil_eng.php" class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="100">
                    <img src="gambar/jogja.PNG" alt="Yogyakarta" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Yogyakarta</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">More than 400 rentals</p></div>
                </a>

                <a href="sewa_mobil_eng.php" class="relative group cursor-pointer overflow-hidden shadow-sm hover:shadow-lg transition" data-aos="zoom-in-up" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=800&auto=format&fit=crop" alt="Surabaya" class="w-full h-56 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 p-2 flex flex-col items-center justify-center translate-y-0 group-hover:-translate-y-2 transition duration-300"><p class="text-white text-2xl font-normal tracking-wide">Surabaya</p><p class="text-gray-300 text-xs italic mt-1 opacity-0 group-hover:opacity-100 transition duration-300">More than 400 rentals</p></div>
                </a>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         NEW SECTION: INTERACTIVE FLEET SHOWCASE WITH FORMAL YET LUXURIOUS STYLE
         ========================================================================= -->
    <section class="py-16 bg-gray-50 relative overflow-hidden border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <h2 class="text-xl font-bold text-gray-800 mb-2 uppercase" data-aos="fade-down">OUR BEST FLEET SELECTION</h2>
            <!-- Indoloka signature line positioned in the center -->
            <div class="w-24 h-[3px] bg-[#0076D6] mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>

            <!-- VEHICLE CATEGORY TABS (Elegant) -->
            <div class="flex flex-wrap justify-center gap-4 md:gap-8 mt-6" data-aos="fade-up" data-aos-delay="200">
                <button onclick="filterFleet('MPV', this)" class="tab-btn active px-4 py-2 text-gray-500 text-lg uppercase tracking-wide cursor-pointer focus:outline-none hover:text-[#0076D6]">MPV</button>
                <button onclick="filterFleet('SUV', this)" class="tab-btn px-4 py-2 text-gray-500 text-lg uppercase tracking-wide cursor-pointer focus:outline-none hover:text-[#0076D6]">SUV</button>
                <button onclick="filterFleet('Luxury', this)" class="tab-btn px-4 py-2 text-gray-500 text-lg uppercase tracking-wide cursor-pointer focus:outline-none hover:text-[#0076D6]">Luxury</button>
                <button onclick="filterFleet('Commercial', this)" class="tab-btn px-4 py-2 text-gray-500 text-lg uppercase tracking-wide cursor-pointer focus:outline-none hover:text-[#0076D6]">Commercial</button>
            </div>

            <!-- 3D STAGE -->
            <div class="mt-12 relative w-full max-w-4xl mx-auto" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1200">
                
                <!-- 3D Stage Floor (Transparent Reflection) -->
                <div class="absolute bottom-16 left-1/2 -translate-x-1/2 w-3/4 h-32 stage-floor -z-10"></div>
                
                <div class="flex items-center justify-between">
                    <!-- Left Arrow Button -->
                    <button onclick="prevCar()" class="w-12 h-12 bg-white text-[#0076D6] rounded-full shadow-lg hover:bg-[#0076D6] hover:text-white transition-all duration-300 z-20 flex items-center justify-center text-xl border border-gray-100 transform hover:scale-110 hover:-translate-x-2">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    
                    <!-- Car Display Stage -->
                    <div class="flex-1 px-4 relative h-[360px] flex flex-col items-center justify-center">
                        <div id="showcase-container" class="w-full flex flex-col items-center">
                            <!-- Drop-shadow gives the effect of the car having a shadow on the floor -->
                            <img id="showcase-car-img" src="gambar/toyota all new avanza.jpg" alt="Car" class="max-h-[200px] object-contain drop-shadow-2xl transition-transform hover:scale-[1.15] duration-500">
                            
                            <div class="mt-10">
                                <h3 id="showcase-car-name" class="text-3xl font-bold text-gray-800 tracking-tight">Toyota All New Avanza</h3>
                                <p id="showcase-car-desc" class="text-[#0076D6] font-medium mt-2 text-lg">Comfortable for family, fuel efficient.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Arrow Button -->
                    <button onclick="nextCar()" class="w-12 h-12 bg-white text-[#0076D6] rounded-full shadow-lg hover:bg-[#0076D6] hover:text-white transition-all duration-300 z-20 flex items-center justify-center text-xl border border-gray-100 transform hover:scale-110 hover:translate-x-2">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Action Button -->
                <div class="mt-4 relative z-30" data-aos="fade-up" data-aos-delay="400">
                    <a href="sewa_mobil_eng.php" class="inline-flex items-center gap-2 btn-indoloka-blue text-white px-8 py-3 rounded text-lg font-bold shadow-md hover:bg-blue-700 transition transform hover:-translate-y-1">
                        <i class="fa-solid fa-car"></i> BOOK THIS VEHICLE 
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY RENT A CAR SECTION -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12" data-aos="fade-in">
        <div class="flex h-1.5 w-full mb-8"><div class="w-1/3 bg-[#1ba0e2]"></div><div class="w-1/3 bg-[#ffb400]"></div><div class="w-1/3 bg-[#ff4b00]"></div></div>
    </div>
    
    <section class="pb-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold text-gray-900 mb-8 uppercase text-left" data-aos="fade-right">WHY RENT A CAR AT NUSARENT.COM?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature -->
                <div class="border border-gray-200 p-6 flex flex-col items-center text-center bg-white hover:shadow-xl hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-[100px] h-[100px] rounded-full bg-[#1ba0e2] flex items-center justify-center text-white mb-5 relative hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-car text-5xl"></i>
                        <div class="absolute top-1 right-0 bg-[#1ba0e2] rounded-full w-10 h-10 flex flex-col items-center justify-center border-2 border-white shadow-sm">
                            <span class="text-[8px] leading-tight font-bold">Rp</span><span class="text-[6px] leading-tight font-bold text-yellow-300">BEST<br>PRICE</span>
                        </div>
                    </div>
                    <h3 class="text-[#1ba0e2] font-bold text-lg mb-2">Crazy Price</h3>
                    <p class="text-gray-600 text-sm px-2">Very competitive and cheap prices, prove it...</p>
                </div>
                <div class="border border-gray-200 p-6 flex flex-col items-center text-center bg-white hover:shadow-xl hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-[100px] h-[100px] rounded-full bg-[#1ba0e2] flex items-center justify-center text-white mb-5 hover:scale-110 transition duration-300"><i class="fa-regular fa-clock text-[55px]"></i></div>
                    <h3 class="text-[#1ba0e2] font-bold text-lg mb-2">Easy to Order</h3><p class="text-gray-600 text-sm px-2">Online ordering is fast, easy & cheap.</p>
                </div>
                <div class="border border-gray-200 p-6 flex flex-col items-center text-center bg-white hover:shadow-xl hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-[100px] h-[100px] rounded-full bg-[#1ba0e2] flex items-center justify-center text-white mb-5 hover:scale-110 transition duration-300">
                        <div class="flex flex-col items-center justify-center mt-3"><i class="fa-solid fa-car text-2xl -mb-1"></i><div class="flex gap-1"><i class="fa-solid fa-car text-3xl"></i><i class="fa-solid fa-car text-3xl"></i></div></div>
                    </div>
                    <h3 class="text-[#1ba0e2] font-bold text-lg mb-2">10,000+ Cars in 90 Cities</h3><p class="text-gray-600 text-[13px] leading-relaxed">NusaRent car rental has more than 10,000 cars. NusaRent car rental is available in 90 cities in Indonesia.</p>
                </div>
                <div class="border border-gray-200 p-6 flex flex-col items-center text-center bg-white hover:shadow-xl hover:-translate-y-2 transition duration-300" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-[100px] h-[100px] rounded-full bg-[#1ba0e2] flex flex-col items-center justify-center text-white mb-5 pt-2 hover:scale-110 transition duration-300">
                        <div class="flex gap-0.5 text-[10px] mb-1 text-white"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <i class="fa-solid fa-car text-3xl mb-1"></i><i class="fa-solid fa-hand-holding text-2xl"></i>
                    </div>
                    <h3 class="text-[#1ba0e2] font-bold text-lg mb-2">Premier Service:</h3>
                    <div class="text-gray-600 text-sm text-left w-full pl-3"><p class="mb-1">• experienced drivers.</p><p class="mb-1">• flexible pick-up times & locations.</p><p>• drink & tissue ordering facilities.</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Simple Footer -->
    <footer class="bg-[#1a2b4c] text-gray-300 py-10 mt-10 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-white text-xl font-bold mb-4"><i class="fa-solid fa-car-side"></i> NusaRent</h3>
            <p class="text-sm mb-4">Easy, Safe, and Trusted Online Car Rental throughout Indonesia.</p>
            <p class="text-sm opacity-75">© <?php echo date("Y"); ?> NusaRent (Online Car Rental). All Rights Reserved.</p>
        </div>
    </footer>

    <!-- SCROLL TO TOP BUTTON -->
    <a href="#top" class="fixed bottom-6 right-6 bg-[#444444] text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg hover:bg-gray-800 transition z-50 hover:-translate-y-1">
        <i class="fa-solid fa-chevron-up text-xl"></i>
    </a>

    <!-- AOS ANIMATION SCRIPT -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- JAVASCRIPT FOR SLIDER ANIMATION, AOS INIT & LANGUAGE -->
    <script>
        // Initialize AOS (Scroll Animation)
        AOS.init({ once: true, offset: 50 });

        // Data for each slide
        const slides = [
            { image: "url('https://images.unsplash.com/photo-1549473889-14f410d83298?q=80&w=2000&auto=format&fit=crop')", title: "Bandung", subtitle: "Bandung Car Rental", location: "Location : Pasupati Bridge" },
            { image: "url('gambar/jakarta.jpg')", title: "Jakarta", subtitle: "Jakarta Car Rental", location: "Location : National Monument" },
            { image: "url('gambar/jogja.PNG')", title: "Yogyakarta", subtitle: "Yogyakarta Car Rental", location: "Location : Prambanan Temple" },
            { image: "url('gambar/malang.jpg')", title: "Malang", subtitle: "Malang Car Rental", location: "Location : Mount Bromo" },
            { image: "url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=2000&auto=format&fit=crop')", title: "Bali", subtitle: "Bali Car Rental", location: "Location : Ulun Danu Temple" }
        ];

        let currentIndex = 0;
        const heroSlider = document.getElementById('hero-slider');
        const promoTitle = document.getElementById('promo-title');
        const promoSubtitle = document.getElementById('promo-subtitle');
        const promoLocation = document.getElementById('promo-location');
        const dotsContainer = document.getElementById('slider-dots-container');

        function setupDots() {
            slides.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.classList.add('dot');
                if (index === 0) dot.classList.add('active');
                dot.addEventListener('click', () => goToSlide(index));
                dotsContainer.appendChild(dot);
            });
        }

        function updateSlider() {
            heroSlider.style.backgroundImage = slides[currentIndex].image;
            
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

            document.querySelectorAll('.dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        function nextSlide() { currentIndex = (currentIndex === slides.length - 1) ? 0 : currentIndex + 1; updateSlider(); }
        function prevSlide() { currentIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1; updateSlider(); }
        function goToSlide(index) { currentIndex = index; updateSlider(); }

        document.getElementById('btn-next').addEventListener('click', nextSlide);
        document.getElementById('btn-prev').addEventListener('click', prevSlide);

        setInterval(nextSlide, 5000);
        setupDots();

        // ==========================================================
        // FLEET GALLERY LOGIC FUNCTION (INTERACTIVE SHOWCASE)
        // ==========================================================
        const fleetData = [
            // MPV Category
            { category: 'MPV', name: 'Toyota All New Avanza', img: 'gambar/toyota all new avanza.jpg', desc: 'Reliable family car with high efficiency.' },
            { category: 'MPV', name: 'Mitsubishi Xpander', img: 'gambar/mitshubishi xpander.jpg', desc: 'Tough futuristic design with super spacious cabin.' },
            { category: 'MPV', name: 'Daihatsu All New Xenia', img: 'gambar/daihatsu all newxenia.jpg', desc: 'Economical, reliable, and highly functional.' },
            { category: 'MPV', name: 'Toyota All New Veloz', img: 'gambar/toyota veloz.jpg', desc: 'Premium MPV with advanced and luxurious features.' },
            
            // SUV Category
            { category: 'SUV', name: 'Toyota Rush GR Sport', img: 'gambar/toyota rush.jpg', desc: 'Sporty & stylish, ready to tackle any terrain.' },
            { category: 'SUV', name: 'Toyota Raize', img: 'gambar/toyota raize.jpg', desc: 'Agile compact SUV for urbanites.' },
            { category: 'SUV', name: 'Mitsubishi Pajero Sport', img: 'gambar/mitshubishi pajero.jpg', desc: 'Fierce engine performance, luxurious & masculine.' },
            
            // Luxury Category
            { category: 'Luxury', name: 'Toyota Alphard', img: 'gambar/toyota alphard.jpg', desc: 'Symbol of success with VIP comfort.' },
            { category: 'Luxury', name: 'Toyota Innova Reborn', img: 'gambar/toyota innova reborn.jpg', desc: 'Legendary extra comfort for long trips.' },
            { category: 'Luxury', name: 'Toyota Innova Zenix Hybrid', img: 'gambar/toyota zenix.jpg', desc: 'Future hybrid technology, eco-friendly.' },
            
            // Commercial Category
            { category: 'Commercial', name: 'Toyota Hiace Commuter', img: 'gambar/toyota hiace.jpg', desc: 'Maximum capacity for tour groups.' },
            { category: 'Commercial', name: 'Toyota Hiace Premio', img: 'gambar/toyota hiace premio.jpg', desc: 'Executive Van for luxurious big family tours.' }
        ];

        let currentCategory = 'MPV';
        let currentCarIndex = 0;
        let filteredFleet = fleetData.filter(car => car.category === currentCategory);

        const carDisplayContainer = document.getElementById('showcase-container');
        const carDisplayImg = document.getElementById('showcase-car-img');
        const carDisplayName = document.getElementById('showcase-car-name');
        const carDisplayDesc = document.getElementById('showcase-car-desc');

        function animateCarChange(callback) {
            carDisplayContainer.classList.remove('car-showcase-enter');
            void carDisplayContainer.offsetWidth; // trigger reflow
            callback();
            carDisplayContainer.classList.add('car-showcase-enter');
        }

        function updateShowcaseData() {
            const car = filteredFleet[currentCarIndex];
            carDisplayImg.src = car.img;
            carDisplayName.textContent = car.name;
            carDisplayDesc.textContent = car.desc;
        }

        function filterFleet(category, btnElement) {
            currentCategory = category;
            filteredFleet = fleetData.filter(car => car.category === category);
            currentCarIndex = 0;
            
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            btnElement.classList.add('active');
            
            animateCarChange(updateShowcaseData);
        }

        function nextCar() {
            currentCarIndex = (currentCarIndex + 1) % filteredFleet.length;
            animateCarChange(updateShowcaseData);
        }

        function prevCar() {
            currentCarIndex = (currentCarIndex - 1 + filteredFleet.length) % filteredFleet.length;
            animateCarChange(updateShowcaseData);
        }
    </script>
</body>
</html>