<?php
require 'koneksi.php';

$fullname = $_POST["Fullname"];
$email = $_POST["Email"];
$password = $_POST["Password"];

$query_sql = "INSERT INTO tbl_users (fullname, username, institution, email, password)
              VALUES ('$fullname', '$email', '$password')";

if (mysqli_query($conn, $query_sql)) {
    header("Location: index.html");
} else {
    echo "Pendaftaran Gagal : " . mysqli_error($conn);
}
?>