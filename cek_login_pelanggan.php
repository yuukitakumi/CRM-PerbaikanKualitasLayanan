<?php
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
include 'koneksi.php';
 
// menangkap data yang dikirim dari form
$id_pelanggan = $_POST['id_pelanggan'];
$password = $_POST['password'];
 
// menyeleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($conn,"select * from pelanggan where id_pelanggan='$id_pelanggan' and password='$password'");
 
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);
 
if($cek > 0){
	$_SESSION['id_pelanggan'] = $id_pelanggan;
	$_SESSION['status'] = "login";
	header("location:menupelanggan.php");
}else{
	header("location:loginpelanggan.php?pesan=gagal");
}
?>