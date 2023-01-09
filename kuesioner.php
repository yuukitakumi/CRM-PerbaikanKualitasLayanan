<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner</title>
    <link rel="stylesheet" href="style.css">
    
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <!-- cek apakah sudah login -->
	<?php 
	session_start();
	if($_SESSION['status']!="login"){
		header("location:../loginpengguna.php?pesan=belum_login");
	}
    ?>
    <header>        
        
        <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
        <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pengguna']; ?></button></a>
        <a class="cta" href="loginpengguna.php"><button class="button button1">Logout</button></a>
    </header>
    <p>Menu Kuesioner</p>
    <div class="grid-container">
        <div><a class="cta" href="dimensilayanan.php"><button class="button button6">Dimensi Layanan</button></a></div>
        <div><a class="cta" href="datalayanan.php"><button class="button button6">Data Layanan</button></a></div>
    </div>
</body>
<a class="cta" href="halamanadmin.php"><button class="button button1">Kembali</button></a>
</html>