<?php
// Start session to get logged-in user data
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
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
    <title>Car Rental List - NusaRent</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Roboto Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- AOS CSS (Scroll Animation) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background-color: #f9f9f9; scroll-behavior: smooth; overflow-x: hidden; }
        .bg-indoloka-blue { background-color: #0076D6; }
        .btn-indoloka-blue { background-color: #006BFE; }
        .border-indoloka-yellow { border-bottom: 4px solid #FFC107; }

        /* Search Form */
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

    <!-- TOP NAVBAR -->
    <nav class="bg-indoloka-blue border-indoloka-yellow text-white w-full fixed top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-8">
                    <!-- Logo directed to dashboard_eng.php -->
                    <a href="dashboard_eng.php" class="flex flex-col cursor-pointer hover:opacity-90 transition">
                        <div class="flex items-center text-3xl font-bold tracking-tight">
                            <i class="fa-solid fa-car-side mr-2"></i> NusaRent<span class="text-sm font-normal pt-2">.com</span>
                        </div>
                        <span class="text-xs font-medium tracking-wide">No 1 Online Car Rental in Indonesia</span>
                    </a>
                    
                    <div class="hidden md:flex items-center space-x-6 pt-2">
                        <a href="dashboard_eng.php" class="text-sm font-medium hover:text-gray-200 transition">Home</a>
                        <!-- Active styling on Car Rental menu -->
                        <a href="sewa_mobil_eng.php" class="bg-blue-500/50 px-3 py-1 rounded text-sm font-medium hover:bg-blue-600 transition">Car Rental</a>
                        <a href="hubungi_kami_eng.php" class="text-sm font-medium hover:text-gray-200 transition">Contact Us</a>
                        <div class="flex items-center space-x-3 text-lg border-l border-white/30 pl-4 ml-2">
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-whatsapp"></i></a>
                            <a href="#" class="hover:text-gray-300 transition hover:scale-110"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-6 pt-2 text-sm font-medium">
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
                                <a href="sewa_mobil.php" class="flex items-center px-4 py-2 hover:bg-blue-50 font-semibold transition"><img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="mr-2 h-3 border border-gray-300"> Indonesia</a>
                                <a href="sewa_mobil_eng.php" class="flex items-center px-4 py-2 hover:bg-blue-50 font-semibold transition"><img src="https://flagcdn.com/w20/gb.png" alt="EN Flag" class="mr-2 h-3 border border-gray-300"> English</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- HEADER & SEARCH FORM -->
    <section class="pt-28 pb-12 bg-[#005ea6]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-down" data-aos-duration="800">
            <div class="search-box-glass">
                <div class="search-box-header">Change Your Search Criteria</div>
                
                <form action="#" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Pick-up Location -->
                        <div>
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
                        <div>
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
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Rental Date -->
                        <div>
                            <label class="form-label">Rental Date</label>
                            <div class="input-group">
                                <i class="fa-regular fa-calendar-days"></i>
                                <input type="date" name="tanggal" class="!pl-[38px]"> 
                            </div>
                        </div>
                        
                        <!-- Duration -->
                        <div>
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

                        <!-- Number of Units -->
                        <div>
                            <label class="form-label">Number of Units</label>
                            <div class="input-group">
                                <i class="fa-solid fa-car"></i>
                                <select name="jumlah">
                                    <option value="1">1 Unit</option><option value="2">2 Units</option><option value="3">3 Units</option>
                                </select>
                            </div>
                        </div>

                        <!-- Package -->
                        <div>
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

                    <!-- Search Button -->
                    <div class="mt-2">
                        <button type="submit" class="w-full bg-[#ff9800] text-white font-bold py-3 px-4 rounded shadow hover:bg-[#e68a00] transition transform hover:scale-[1.01] flex items-center justify-center gap-2">
                            <i class="fa-solid fa-magnifying-glass"></i> FIND CAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- SEARCH RESULTS: FLEET LIST -->
    <section id="daftar-mobil" class="pb-20 pt-8 bg-[#f9f9f9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold text-gray-800" data-aos="fade-right">12 CARS FOUND</h2>
                <div class="flex items-center gap-2 text-sm text-gray-600" data-aos="fade-left">
                    <span class="font-medium">Sort by:</span>
                    <select class="border border-gray-300 rounded px-3 py-1.5 bg-white outline-none cursor-pointer focus:border-blue-500">
                        <option>Lowest Price</option>
                        <option>Recommendation</option>
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
                    <p class="text-gray-500 text-sm mb-4">Car Year 2020-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake" title="AC"></i>
                        <i class="fa-solid fa-users" title="7 Passengers"></i>
                        <i class="fa-solid fa-suitcase" title="2 Suitcases"></i>
                        <i class="fa-solid fa-gas-pump" title="Petrol"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> NusaRent car rental</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Usage within 40 km radius</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Driver / Drop-off</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-xs text-gray-400 line-through mb-1">Rp. 500,000</p>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 450,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 450,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 2: Xpander -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/mitshubishi xpander.jpg" alt="Mitsubishi Xpander" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Mitsubishi Xpander</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2021-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> NusaRent car rental</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Usage within 40 km radius</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Driver / Drop-off</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-xs text-gray-400 line-through mb-1">Rp. 550,000</p>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 480,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 480,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 3: Innova Reborn -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota innova reborn.jpg" alt="Toyota Innova Reborn" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Innova Reborn</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2018-2022</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> NusaRent premium rental</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> In-town & Out-of-town Usage</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Driver / Drop-off</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-xs text-gray-400 line-through mb-1">Rp. 850,000</p>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 750,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 750,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 4: Alphard -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota alphard.jpg" alt="Toyota Alphard" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Alphard</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2021-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> VIP VVIP Service</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> In-town Usage</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Exclusive Driver</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 2,500,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 2,500,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 5: Hiace -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota hiace.jpg" alt="Toyota Hiace" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Hiace Commuter</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2019-2022</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users" title="15 Passengers"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Large Capacity (15 People)</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Tour / Sightseeing Usage</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Tour Driver</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 1,400,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 1,400,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 6: Hiace Premio -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota hiace premio.jpg" alt="Toyota Hiace Premio" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Hiace Premio</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2022-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users" title="12 Passengers"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Executive Van (Captain Seat)</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Luxury Family Tour</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Professional Driver</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 1,800,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 1,800,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 7: Pajero Sport -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/mitshubishi pajero.jpg" alt="Mitsubishi Pajero Sport" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Mitsubishi Pajero Sport</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2021-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Tough Premium SUV</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Suitable for All Terrains</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Driver</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 1,500,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 1,500,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 8: Daihatsu Xenia -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/daihatsu all newxenia.jpg" alt="Daihatsu All New Xenia" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Daihatsu All New Xenia</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2022-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Economical Family Car</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Fuel Efficient</li>
                        <li><i class="fa-solid fa-key text-gray-700 mr-2 w-4"></i> Self-Drive / With Driver</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <p class="text-xs text-gray-400 line-through mb-1">Rp. 450,000</p>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 350,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 350,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 9: Toyota Raize -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota raize.jpg" alt="Toyota Raize" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Raize</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2022-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users" title="5 Passengers"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Trendy Compact SUV</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Agile in the City</li>
                        <li><i class="fa-solid fa-key text-gray-700 mr-2 w-4"></i> Self-Drive Available</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 450,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 450,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 10: Toyota Rush -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota rush.jpg" alt="Toyota Rush" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Rush GR Sport</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2021-2023</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> 7-Seater Sporty SUV</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> High Ground Clearance</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Driver</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 550,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 550,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 11: Toyota Veloz -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota veloz.jpg" alt="Toyota Veloz" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota All New Veloz</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2022-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Comfortable & Advanced MPV</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Comfortable for Long Trips</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Driver</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 500,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 500,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

            <!-- List Mobil 12: Toyota Zenix -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6 mb-6 shadow-sm hover:shadow-lg transition duration-300" data-aos="fade-up">
                <div class="w-full md:w-1/4 flex items-center justify-center p-4">
                    <img src="gambar/toyota zenix.jpg" alt="Toyota Innova Zenix" class="w-full h-auto object-contain transform hover:scale-110 transition duration-500">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800">Toyota Innova Zenix Hybrid</h3>
                    <p class="text-gray-500 text-sm mb-4">Car Year 2023-2024</p>
                    <div class="flex gap-4 text-gray-400 mb-4 text-lg">
                        <i class="fa-solid fa-snowflake"></i><i class="fa-solid fa-users"></i><i class="fa-solid fa-suitcase"></i><i class="fa-solid fa-leaf text-green-500" title="Hybrid"></i>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><i class="fa-solid fa-check text-green-500 mr-2 w-4"></i> Very Quiet & Spacious Cabin</li>
                        <li><i class="fa-solid fa-location-crosshairs text-blue-500 mr-2 w-4"></i> Very Fuel Efficient (Hybrid)</li>
                        <li><i class="fa-solid fa-user-tie text-gray-700 mr-2 w-4"></i> Includes Exclusive Driver</li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center items-end text-right">
                    <span class="bg-blue-100 text-blue-800 text-[11px] font-bold px-3 py-1 rounded mb-3 flex items-center gap-1"><i class="fa-solid fa-bolt"></i> INSTANT BOOKING</span>
                    <p class="text-2xl font-bold text-[#ff4b00] mb-1">Rp. 900,000 <span class="text-xs font-normal text-gray-500">/ 12 Hours</span></p>
                    <p class="text-xs text-gray-500 mb-5">Total Price: Rp. 900,000</p>
                    <button class="bg-[#ff9800] hover:bg-[#e68a00] text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105 w-full">BOOK NOW</button>
                </div>
            </div>

        </div>
    </section>

    <!-- Simple Footer -->
    <footer class="bg-[#1a2b4c] text-gray-300 py-10 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-white text-xl font-bold mb-4"><i class="fa-solid fa-car-side"></i> NusaRent</h3>
            <p class="text-sm mb-4">Easy, Safe, and Trusted Online Car Rental throughout Indonesia.</p>
            <p class="text-sm opacity-75">© <?php echo date("Y"); ?> NusaRent. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- SCROLL TO TOP BUTTON -->
    <a href="#top" class="fixed bottom-6 right-6 bg-[#444444] text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg hover:bg-gray-800 transition z-50 hover:-translate-y-1">
        <i class="fa-solid fa-chevron-up text-xl"></i>
    </a>

    <!-- AOS ANIMATION SCRIPT -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- JAVASCRIPT FOR ANIMATION & LANGUAGE -->
    <script>
        // Initialize AOS (Scroll Animation)
        AOS.init({ once: true, offset: 50 });

        // Change Language Function
        function changeLanguage(flagCode, langText, event) {
            event.preventDefault();
            document.getElementById('current-flag').src = `https://flagcdn.com/w20/${flagCode}.png`;
            document.getElementById('current-lang').innerText = langText;
            
            const trigger = document.getElementById('lang-trigger');
            trigger.parentElement.classList.remove('group');
            setTimeout(() => { trigger.parentElement.classList.add('group'); }, 100);
        }
    </script>
</body>
</html>