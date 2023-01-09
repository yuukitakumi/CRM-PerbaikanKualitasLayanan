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
    <title>Pelanggan</title>    
    <link rel="stylesheet" href="style.css">
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
    
    <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pengguna']; ?></button></a>
        <a class="cta" href="logoutpengguna.php"><button class="button button1">Logout</button></a>
    </header>    
      <div style='vertical-align:middle; display:inline; padding: 10px;'><a>Pelanggan</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","","db_babydear_laundry")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $id_pelanggan=$_POST['id_pelanggan'];
        $nama_pelanggan=$_POST['nama_pelanggan'];
        $no_wa=$_POST['no_wa'];
        $alamat=$_POST['alamat'];
        $password=$_POST['password'];

        if(!empty($id_pelanggan) || !empty($nama_pelanggan)|| !empty($no_wa)|| !empty($alamat)|| !empty($password)){
            $sql = "insert into pelanggan ( id_pelanggan, nama_pelanggan, no_wa, alamat, password)" . 
              "values ( '$id_pelanggan','$nama_pelanggan','$no_wa','$alamat','$password')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: pelanggan.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
    <?php 
    $query4 = mysqli_query($conn, "SELECT max(id_pelanggan) as kodeTerbesar FROM pelanggan");
	$data4 = mysqli_fetch_array($query4);
	$id_pelanggan = $data4['kodeTerbesar'];
	$urutan = (int) substr($id_pelanggan, 4, 3);
	$urutan++;
	$huruf = "PEL-";
	$id_pelanggan= $huruf . sprintf("%03s", $urutan);
    ?> 
       <form method="POST" action="pelanggan.php">
<table>    
    <td>ID Pelanggan<input type="text" name="id_pelanggan" required="required" value="<?php echo $id_pelanggan ?>" readonly></td>
	<tr><td>Nama Pelanggan<input type="text" name="nama_pelanggan" placeholder="nama pelanggan" required autocomplete="off"></td>                  
    <tr><td>No Wa<input type="text" name="no_wa" placeholder="no wa" required autocomplete="off">
    <tr><td>Alamat<input type="text" name="alamat" placeholder="alamat" required autocomplete="off">		
    <tr><td>Password<input type="password" name="password" placeholder="Password" required autocomplete="off"></td>
        <tr>  
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="pelanggan.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM pelanggan";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>ID Pelanggan</th>
        <th>Nama Pelanggan</th>
        <th>No Wa</th>
        <th>Alamat</th>
        <th>Password</th>
        <th>Aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id_pelanggan']; ?></td>
                <td><?php echo $data['nama_pelanggan']; ?></td>
                <td><?php echo $data['no_wa']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['password']; ?></td>
                <td>
                    <a href="pelanggan.php?aksi=update&id_pelanggan=<?php echo $data['id_pelanggan'];?>&nama_pelanggan=<?php echo $data['nama_pelanggan']; ?>&no_wa=<?php echo $data['no_wa']; ?>&alamat=<?php echo $data['alamat']; ?>&password=<?php echo $data['password']; ?>">Edit</a> |
                    <a href="pelanggan.php?aksi=delete&id_pelanggan=<?php echo $data['id_pelanggan']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
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
		$id_pelanggan=$_POST['id_pelanggan'];
        $nama_pelanggan=$_POST['nama_pelanggan'];
        $no_wa=$_POST['no_wa'];
        $alamat=$_POST['alamat'];
        $password=$_POST['password'];

        if(!empty($id_pelanggan) || !empty($nama_pelanggan)|| !empty($no_wa)|| !empty($alamat)|| !empty($password)){
        $sql_update = "UPDATE pelanggan SET id_pelanggan='$_POST[id_pelanggan]',nama_pelanggan='$_POST[nama_pelanggan]',no_wa='$_POST[no_wa]',alamat='$_POST[alamat]',password='$_POST[password]' WHERE id_pelanggan='$id_pelanggan';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: pelanggan.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['id_pelanggan'])){
        ?>  
         <div class="btn-paket"></div>
            <form action="" method="POST"  >
			<table>             
		<td>ID Pelanggan<input type="text" id="id_pelanggan" autocomplete="off" name="id_pelanggan" required value="<?php echo $_GET['id_pelanggan']?>" readonly></td>
        <tr><td>Nama Pelanggan<input type="text" id="nama_pelanggan" autocomplete="off" name="nama_pelanggan"  placeholder="nama_pelanggan" required value="<?php echo $_GET['nama_pelanggan'] ?>"></td>
        <tr><td>No WA<input type="text" id="no_wa" autocomplete="off" name="no_wa"  placeholder="no wa" required value="<?php echo $_GET['no_wa'] ?>"></td>
		<tr><td>Alamat<input type="text" id="alamat" autocomplete="off" name="alamat"  placeholder="alamat" required value="<?php echo $_GET['alamat'] ?>"></td>
        <tr><td>Password<input type="password" name="password" placeholder="Password" required autocomplete="off" required value="<?php echo $_GET['password'] ?>"></td>
        <tr>  
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="pelanggan.php" class="button button10">Refresh</a> <a href="pelanggan.php?aksi=delete&pengguna=<?php echo $_GET['id_pelanggan'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['id_pelanggan']) && isset($_GET['aksi'])){
        $id_pelanggan = $_GET['id_pelanggan'];
        $sql_hapus = "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: pelanggan.php');
                
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
            echo '<a href="pelanggan.php"> &laquo; Home</a>';
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