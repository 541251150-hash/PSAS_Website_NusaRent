<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: test/index.php");
    exit();
}

// Include database connection
include("test/connect.php"); 

$nama_user = "Customer"; // Default
$email_user = $_SESSION['email']; // To be auto-filled in the form

// Get user data
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - NusaRent</title>
    
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

    <!-- TOP NAVBAR -->
    <nav class="bg-indoloka-blue border-indoloka-yellow text-white w-full fixed top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex items-center space-x-8">
                    <div class="flex flex-col cursor-pointer" onclick="window.location.href='dashboard_eng.php'">
                        <div class="flex items-center text-3xl font-bold tracking-tight">
                            <i class="fa-solid fa-car-side mr-2"></i> NusaRent<span class="text-sm font-normal pt-2">.com</span>
                        </div>
                        <span class="text-xs font-medium tracking-wide">No 1 Online Car Rental in Indonesia</span>
                    </div>
                    
                    <div class="hidden md:flex items-center space-x-6 pt-2">
                        <!-- HOME MENU -->
                        <a href="dashboard_eng.php" class="text-sm font-medium hover:text-gray-200 transition">Home</a>
                        
                        <!-- CAR RENTAL MENU -->
                        <a href="sewa_mobil_eng.php" class="text-sm font-medium hover:text-gray-200 transition">Car Rental</a>
                        
                        <!-- CONTACT US MENU (Active State) -->
                        <a href="hubungi_kami_eng.php" class="bg-blue-500/50 px-3 py-1 rounded text-sm font-medium hover:bg-blue-600 transition">Contact Us</a>
                        
                        <!-- SOCIAL MEDIA ICONS (WhatsApp & Instagram) -->
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
            <h1 class="text-4xl font-bold mb-4 uppercase tracking-wide">Customer Service Center</h1>
            <p class="text-lg text-blue-100 max-w-2xl mx-auto">We are ready to help you 24/7. Please do not hesitate to contact us for questions, complaints, or booking assistance.</p>
        </div>
    </section>

    <!-- QUICK CONTACT CARDS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="contact-card text-center" data-aos="fade-up" data-aos-delay="0">
                <div class="w-16 h-16 mx-auto bg-blue-100 text-indoloka-blue rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Call Center Service</h3>
                <p class="text-gray-500 text-sm mb-3">Available 24/7 every day</p>
                <p class="text-2xl font-bold text-indoloka-blue">0881-1336-160</p>
            </div>
            
            <div class="contact-card text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Official WhatsApp</h3>
                <p class="text-gray-500 text-sm mb-3">Quick chat for reservations</p>
                <p class="text-2xl font-bold text-green-600">0817-7001-3416
            </div>

            <div class="contact-card text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 mx-auto bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Support Email</h3>
                <p class="text-gray-500 text-sm mb-3">For partnerships & complaints</p>
                <p class="text-lg font-bold text-gray-800">irvantrans14@gmail.com
            </div>
        </div>
    </section>

    <!-- MAIN SECTION (CONTACT FORM & LOCATIONS) -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-10">
                
                <!-- LEFT COLUMN: CONTACT FORM -->
                <div class="w-full lg:w-7/12 bg-white p-8 rounded-lg shadow-sm border border-gray-200" data-aos="fade-right">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2 border-b-2 border-indoloka-yellow pb-2 inline-block">Send a Direct Message</h2>
                    <p class="text-gray-500 text-sm mb-6 mt-2">Fill out the form below and our Customer Service team will reply to your message within 1x24 hours.</p>
                    
                    <form action="#" method="POST" onsubmit="alert('Your message has been sent successfully! Our team will contact you shortly.'); return false;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" class="form-input" value="<?php echo htmlspecialchars($nama_user); ?>" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" class="form-input" value="<?php echo htmlspecialchars($email_user); ?>" readonly style="background-color:#eee; cursor:not-allowed;">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Phone / WhatsApp Number *</label>
                            <input type="text" class="form-input" placeholder="Example: 0812xxxxxx" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Message Subject *</label>
                            <select class="form-input" required>
                                <option value="">-- Select Subject --</option>
                                <option value="Bantuan Sewa">Reservation / Rental Assistance</option>
                                <option value="Keluhan">Service Complaint</option>
                                <option value="Kerjasama">Partnership / Corporate Offer</option>
                                <option value="Lainnya">Other</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Message Details *</label>
                            <textarea class="form-input" rows="5" placeholder="Write your questions or complaints here..." required></textarea>
                        </div>

                        <button type="submit" class="btn-indoloka-blue text-white font-bold py-3 px-8 rounded shadow hover:bg-blue-700 transition transform hover:scale-[1.02]">
                            <i class="fa-regular fa-paper-plane mr-2"></i> SEND MESSAGE
                        </button>
                    </form>
                </div>

                <!-- RIGHT COLUMN: OPERATIONAL LOCATIONS -->
                <div class="w-full lg:w-5/12" data-aos="fade-left">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-indoloka-yellow pb-2 inline-block">Garage / Branch Office Locations</h2>
                    
                    <div class="location-item">
                        <h4 class="font-bold text-lg text-gray-800"><i class="fa-solid fa-building text-indoloka-blue mr-2"></i> Jakarta Head Office</h4>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">NusaRent Tower Building 5th Floor, Jl. Jend. Sudirman Kav. 52, Senayan, South Jakarta, 12190.</p>
                    </div>

                    <div class="location-item">
                        <h4 class="font-bold text-lg text-gray-800"><i class="fa-solid fa-map-pin text-indoloka-blue mr-2"></i> Bandung Branch</h4>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">Jl. Pasteur No. 11A, Pamoyanan, Cicendo, Bandung City, West Java 40173.</p>
                    </div>

                    <div class="location-item">
                        <h4 class="font-bold text-lg text-gray-800"><i class="fa-solid fa-map-pin text-indoloka-blue mr-2"></i> Bali Branch</h4>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">Jl. By Pass Ngurah Rai No. 88, Tuban, Kuta, Badung Regency, Bali 80361.</p>
                    </div>
                    
                    <div class="location-item">
                        <h4 class="font-bold text-lg text-gray-800"><i class="fa-solid fa-map-pin text-indoloka-blue mr-2"></i> Surabaya Branch</h4>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">Jl. Ahmad Yani No. 288, Gayungan, Surabaya City, East Java 60235.</p>
                    </div>

                    <!-- Google Maps Embed -->
                    <div class="mt-6 border border-gray-200 rounded p-1 bg-white">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.24037562095!2d106.75878436402099!3d-6.229746536098048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1714486518134!5m2!1sid!2sid" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SOCIAL MEDIA SECTION -->
    <section class="py-12 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-xl font-bold text-gray-800 mb-6 uppercase">Follow News & Promos on Our Social Media</h2>
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

    <!-- Simple Footer -->
    <footer class="bg-[#1a2b4c] text-gray-300 py-10 border-t border-gray-200">
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
    <script>
        AOS.init({ once: true, offset: 50 });

        // LANGUAGE FUNCTION
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