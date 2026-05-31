?php
// Memulai session untuk mendeteksi status login dari database
session_start();

// Cek apakah user sudah login, jika belum kembalikan ke halaman login (index.php di dalam folder test)
if(!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
} else {
    // JIKA BERHASIL LOGIN: Lempar langsung ke dashboard utama di luar folder test
    header("Location: ../dashboard.php");
    exit();
}
?>
<!DOCTYPE html> 
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - NusaRent</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col items-center justify-center">

    <div class="bg-white p-10 rounded-2xl shadow-lg text-center max-w-md">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Hello :)</h1>
        
        <p class="text-xl text-gray-600 mb-8">
            Selamat datang, 
            <span class="font-bold text-blue-600">
                <?php 
                // Mengambil data user berdasarkan email yang tersimpan di session
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
                
                if($row = mysqli_fetch_assoc($query)){
                    // Jika kolom di database kamu namanya 'nama_lengkap', gunakan ini:
                    if(isset($row['nama_lengkap'])){
                        echo $row['nama_lengkap'];
                    } 
                    // Jika di database kamu dipisah fName dan lName (ikut tutorial YouTube), gunakan ini:
                    else if(isset($row['fName'])){
                        echo $row['fName'] . " " . ($row['lName'] ?? '');
                    }
                    // Jika masih error, tampilkan email saja
                    else {
                        echo $row['email'];
                    }
                }
                ?>
            </span>
        </p>

        <a href="logout.php" class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
            Logout
        </a>
    </div>

</body>
</html>