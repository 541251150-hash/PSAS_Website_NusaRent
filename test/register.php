<?php 
include 'connect.php';

if(isset($_POST['signUp'])){
    // mysqli_real_escape_string digunakan agar aman dari karakter aneh / hacker
    $firstName = mysqli_real_escape_string($conn, $_POST['fName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $password = md5($password);

     $checkEmail = "SELECT * From users where email='$email'";
     $result = $conn->query($checkEmail);
     
     if($result->num_rows > 0){
        // Munculkan pop-up alert lalu kembalikan ke form
        echo "<script>alert('Email sudah terdaftar! Gunakan email lain.'); window.location.href='index.php';</script>";
     }
     else{
        $insertQuery = "INSERT INTO users(firstName,lastName,email,password)
                       VALUES ('$firstName','$lastName','$email','$password')";
            if($conn->query($insertQuery) == TRUE){
                // Munculkan pop-up sukses lalu arahkan untuk login
                echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location.href='index.php';</script>";
            }
            else{
                echo "Error:".$conn->error;
            }
     }
}

if(isset($_POST['signIn'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $password = md5($password);
   
   $sql = "SELECT * FROM users WHERE email='$email' and password='$password'";
   $result = $conn->query($sql);
   
   if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        
        // Login berhasil, masuk ke dashboard utama
        header("Location: ../dashboard.php");
        exit();
   }
   else{
        // Munculkan pop-up alert jika salah sandi lalu kembalikan ke form
        echo "<script>alert('Email atau Password Salah! Silakan coba lagi.'); window.location.href='index.php';</script>";
   }
}
?>