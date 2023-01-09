<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Pelanggan</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="shortcut icon" type="image/x-icon" href="logobaby.png">
  </head>
  <body>
  <a class="cta" href="index.php"><button class="button button1">Kembali</button></a>
  <?php 
	if(isset($_GET['pesan'])){
		if($_GET['pesan'] == "gagal"){
			echo "<div class='p1'>Login gagal! ID Pelanggan atau password salah!</div>";
		}else if($_GET['pesan'] == "belum_login"){
			echo "<p>Anda harus login untuk mengakses</p>";
		}
	}
	?>
    <div class="center">

      <div class="container">

        <div class="text">
            <img src="logobaby.png" width=300px alt=""></div>
<form action="cek_login_pelanggan.php" method="POST">
          <div class="data">
            <label>ID Pelanggan</label>
            <input type="text" name="id_pelanggan" id="id_pelanggan" required autocomplete="off">
          </div>
<div class="data">
            <label>Password</label>
            <input type="password" name="password" id="password" required autocomplete="off">
          </div>
<div class="btn">
  <div class="inner"></div>
<button type="submit" name="btn-login">login</button></div>
</div>

</div>
</body>

</html>
