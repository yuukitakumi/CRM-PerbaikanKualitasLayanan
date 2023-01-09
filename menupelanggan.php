<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama Pelanggan</title>
    <link rel="stylesheet" href="style.css">
    
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <!-- cek apakah sudah login -->
	<?php 
	session_start();
    if (!isset($_SESSION['id_pelanggan'])){
        header("Location: loginpelanggan.php");
    }
    ?>
    <header>        
        
        <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
        <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pelanggan']; ?></button></a>
        <a class="cta" href="logoutpelanggan.php"><button class="button button1">Logout</button></a>
    </header>
    <p>Main Menu Pelanggan</p>
    <div class="grid-container">
        <div><a class="cta" href="isikuesioner.php"><button class="button button6">Isi Kuesioner</button></a></div>
        <div><a class="cta" href="pelanggan1.php"><button class="button button3">Pelanggan</button></a></div>
    </div>
</body>
</html>