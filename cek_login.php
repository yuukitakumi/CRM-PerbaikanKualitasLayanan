<?php
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
include 'koneksi.php';
 
// menangkap data yang dikirim dari form
$id_pengguna = $_POST['id_pengguna'];
$password = $_POST['password'];
 
// menyeleksi data admin dengan username dan password yang sesuai
$login = mysqli_query($conn,"select * from pengguna where id_pengguna='$id_pengguna' and password='$password'");
 
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);
 
// cek apakah username dan password di temukan pada database
if($cek > 0){
 
	$data = mysqli_fetch_assoc($login);
 
	// cek jika user login sebagai admin
	if($data['jabatan']=="Admin"){
 
		// buat session login dan username
		$_SESSION['id_pengguna'] = $id_pengguna;
		$_SESSION['jabatan'] = "Admin";
		$_SESSION['status'] = "login";
		// alihkan ke halaman dashboard admin
		header("location:halamanadmin.php");
 
	// cek jika user login sebagai pemilik
	}else if($data['jabatan']=="Pemilik"){
		// buat session login dan username
		$_SESSION['id_pengguna'] = $id_pengguna;
		$_SESSION['jabatan'] = "Pemilik";
		$_SESSION['status'] = "login";
		// alihkan ke halaman dashboard pegawai
		header("location:halamanpemilik.php");
	}else{
 
		// alihkan ke halaman login kembali
		header("location:loginpengguna.php?pesan=gagal");
	}	
}else{
	header("location:loginpengguna.php?pesan=gagal");
}
 
?>