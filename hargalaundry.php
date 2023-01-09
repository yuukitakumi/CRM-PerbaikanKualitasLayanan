<?php
// Include config file
require_once "koneksi.php";
session_start();
    if (!isset($_SESSION['id_pengguna'])){
        header("Location: loginpengguna.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harga Laundry</title>    
    <link rel="stylesheet" href="style.css">
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
    
    <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pengguna']; ?></button></a>
        <a class="cta" href="logoutpengguna.php"><button class="button button1">Logout</button></a>
    </header>    
      <div style='vertical-align:middle; display:inline; padding: 10px;'><a>Harga Laundry</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","","db_babydear_laundry")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $id_harga_laundry=$_POST['id_harga_laundry'];
        $nama_barang=$_POST['nama_barang'];
        $harga_regular=$_POST['harga_regular'];
        $harga_khusus=$_POST['harga_khusus'];
        $id_pengguna=$_POST['id_pengguna'];
        
        if(!empty($id_harga_laundry) || !empty($nama_barang)||!empty($harga_regular)||!empty($harga_khusus)|| !empty($id_pengguna)){
            $sql = "insert into harga_laundry ( id_harga_laundry, nama_barang,harga_regular,harga_khusus, id_pengguna)" . 
              "values ( '$id_harga_laundry','$nama_barang','$harga_regular','$harga_khusus','$id_pengguna')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: hargalaundry.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
       <form method="POST" action="hargalaundry.php">
<table>    
    <td>ID Harga Laundry<input type="text" name="id_harga_laundry" placeholder="ID Data Layanan"  required autocomplete="off" ></td>
	<tr><td>Nama Barang<input type="text" name="nama_barang" placeholder="Nama Layanan" required autocomplete="off"></td>
    <tr><td>Harga Regular<input type="text" name="harga_regular" placeholder="Harga Regular" required autocomplete="off"></td>
    <tr><td>Harga Khusus<input type="text" name="harga_khusus" placeholder="Harga Khusus" required autocomplete="off"></td>
    <tr><td>ID Pengguna<td>
		<select name="id_pengguna" id="id_pengguna">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql2 = "SELECT * FROM pengguna";
			  $query2 = mysqli_query($conn, $sql2);
			  while($data2 = mysqli_fetch_array($query2)){
		 ?>
			  <option value="<?php echo $data2['id_pengguna']?>"><?php echo $data2['id_pengguna']?></option> 
		 <?php
		  }
		 ?>
		</select> 
        <tr>  
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="hargalaundry.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM harga_laundry";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>ID Harga Laundry</th>
        <th>Nama Barang/th>
        <th>Harga Regular/th>
        <th>Harga Khusus/th>
        <th>ID Pengguna</th>
        <th>Aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id_harga_laundry']; ?></td>
                <td><?php echo $data['nama_barang']; ?></td>
                <td><?php echo $data['harga_regular']; ?></td>
                <td><?php echo $data['harga_khusus']; ?></td>
                <td><?php echo $data['id_pengguna']; ?></td>
                <td>
                    <a href="hargalaundry.php?aksi=update&id_harga_laundry=<?php echo $data['id_harga_laundry'];?>&nama_barang=<?php echo $data['nama_barang'];?>&harga_regular=<?php echo $data['harga_regular'];?>&harga_khusus=<?php echo $data['harga_khusus']; ?>?>&id_pengguna=<?php echo $data['id_pengguna']; ?>">Edit</a> |
                    <a href="hargalaundry.php?aksi=delete&id_harga_laundry=<?php echo $data['id_harga_laundry']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
}
// --- Tutup Fungsi Baca Data (Read)
// --- Fungsi Ubah Data (Update)
function ubah($conn){
    // ubah data
    if(isset($_POST['btn_ubah'])){
		$id_harga_laundry=$_POST['id_harga_laundry'];
        $nama_barang=$_POST['nama_barang'];
        $harga_regular=$_POST['harga_regular'];
        $harga_khusus=$_POST['harga_khusus'];
        $id_pengguna=$_POST['id_pengguna'];
        
        if(!empty($id_harga_laundry) || !empty($nama_barang)||!empty($harga_regular)||!empty($harga_khusus)|| !empty($id_pengguna)){
        $sql_update = "UPDATE harga_laundry SET id_harga_laundry='$_POST[id_harga_laundry]',nama_barang='$_POST[nama_barang]',harga_regular='$_POST[harga_regular]',harga_khusus='$_POST[harga_khusus]',id_pengguna='$_POST[id_pengguna]' WHERE id_harga_laundry='$id_harga_laundry';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: hargalaundry.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['id_harga_laundry'])){
        ?>  
         <div class="btn-paket"></div>
            <form action="" method="POST"  >
			<table>             
		<td>ID Harga Laundry<input type="text" id="id_harga_laundry" autocomplete="off" name="id_harga_laundry" required value="<?php echo $_GET['id_harga_laundry']?>"></td>
        <tr><td>Nama Barang<input type="text" id="nama_barang" autocomplete="off" name="nama_barang"  placeholder="Nama Barang" required value="<?php echo $_GET['nama_barang'] ?>"></td>
        <tr><td>Harga Regular<input type="text" id="harga_regular" autocomplete="off" name="harga_regular"  placeholder="Harga Regular" required value="<?php echo $_GET['harga_regular'] ?>"></td>
        <tr><td>Harga Khusus<input type="text" id="harga_khusus" autocomplete="off" name="harga_khusus"  placeholder="Harga Khusus" required value="<?php echo $_GET['harga_khusus'] ?>"></td>
        <tr><td>ID Pengguna<td>
		<select name="id_pengguna" id="id_pengguna">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql2 = "SELECT * FROM pengguna";
			  $query2 = mysqli_query($conn, $sql2);
			  while($data2 = mysqli_fetch_array($query2)){
		 ?>
			  <option value="<?php echo $data2['id_pengguna']?>"><?php echo $data2['id_pengguna']?></option> 
		 <?php
		  }
		 ?>
		</select> 
        <tr>  
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="hargalaundry.php" class="button button10">Refresh</a> <a href="hargalaundry.php?aksi=delete&datalayanan=<?php echo $_GET['id_harga_laundry'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['id_harga_laundry']) && isset($_GET['aksi'])){
        $id_harga_laundry = $_GET['id_harga_laundry'];
        $sql_hapus = "DELETE FROM harga_laundry WHERE id_harga_laundry='$id_harga_laundry'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: hargalaundry.php');
                
            }
        }
    }
    
}
// --- Tutup Fungsi Hapus
// ===================================================================
// --- Program Utama
if (isset($_GET['aksi'])){
    switch($_GET['aksi']){
        case "create":
            echo '<a href="hargalaundry.php"> &laquo; Home</a>';
            tambah($conn); 
            break;
        case "read":
            tampil_data($conn);
            break;
        case "update":
            ubah($conn);
            tampil_data($conn);
            break;
        case "delete":
            hapus($conn);
            tambah($conn);
            tampil_data($conn); 
            break;
        default:
            echo "<h3>Aksi<i>".$_GET['aksi']."</i> tidak ada!</h3>";
            tambah($conn);
            tampil_data($conn);
    }
} else {
    tambah($conn);
    tampil_data($conn);
    
}
?>
</body>
<br>
<a class="cta" href="halamanadmin.php"><button class="button button1">Kembali</button></a>
</html>