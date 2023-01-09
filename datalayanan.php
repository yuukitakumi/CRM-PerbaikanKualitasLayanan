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
    <title>Data Layanan</title>    
    <link rel="stylesheet" href="style.css">
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
    
    <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pengguna']; ?></button></a>
        <a class="cta" href="logoutpengguna.php"><button class="button button1">Logout</button></a>
    </header>    
      <div style='vertical-align:middle; display:inline; padding: 10px;'><a>Data Layanan</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","","db_babydear_laundry")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $id_data_layanan=$_POST['id_data_layanan'];
        $nama_layanan=$_POST['nama_layanan'];
        $id_dimensi_layanan=$_POST['id_dimensi_layanan'];
        
        if(!empty($id_data_layanan) || !empty($nama_layanan)|| !empty($id_dimensi_layanan)){
            $sql = "insert into data_layanan ( id_data_layanan, nama_layanan, id_dimensi_layanan)" . 
              "values ( '$id_data_layanan','$nama_layanan','$id_dimensi_layanan')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: datalayanan.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
    <?php 
    $query4 = mysqli_query($conn, "SELECT max(id_data_layanan) as kodeTerbesar FROM data_layanan");
	$data4 = mysqli_fetch_array($query4);
	$id_data_layanan = $data4['kodeTerbesar']+1;
    ?> 
       <form method="POST" action="datalayanan.php">
<table>    
    <td>ID Data Layanan<input type="text" name="id_data_layanan" required="required" value="<?php echo $id_data_layanan ?>" readonly></td>
	<tr><td>Nama Layanan<input type="text" name="nama_layanan" placeholder="Nama Layanan" required autocomplete="off"></td>                  
    <tr><td>Nama Dimensi<td>
		<select name="id_dimensi_layanan" id="id_dimensi_layanan">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql2 = "SELECT * FROM dimensi_layanan";
			  $query2 = mysqli_query($conn, $sql2);
			  while($data2 = mysqli_fetch_array($query2)){
		 ?>
			  <option value="<?php echo $data2['id_dimensi_layanan']?>"><?php echo $data2['id_dimensi_layanan']?></option> 
		 <?php
		  }
		 ?>
		</select> 
        <tr>  
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="datalayanan.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM data_layanan";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>ID Data Layanan</th>
        <th>Nama Layanan</th>
        <th>ID Dimensi</th>
        <th>Aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id_data_layanan']; ?></td>
                <td><?php echo $data['nama_layanan']; ?></td>
                <td><?php echo $data['id_dimensi_layanan']; ?></td>
                <td>
                    <a href="datalayanan.php?aksi=update&id_data_layanan=<?php echo $data['id_data_layanan'];?>&nama_layanan=<?php echo $data['nama_layanan']; ?>?>&id_dimensi_layanan=<?php echo $data['id_dimensi_layanan']; ?>">Edit</a> |
                    <a href="datalayanan.php?aksi=delete&id_data_layanan=<?php echo $data['id_data_layanan']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
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
		$id_data_layanan=$_POST['id_data_layanan'];
        $nama_layanan=$_POST['nama_layanan'];
        $id_dimensi_layanan=$_POST['id_dimensi_layanan'];
        
      if(!empty($id_data_layanan)&& !empty($nama_layanan)&& !empty($id_dimensi_layanan)){
        $sql_update = "UPDATE data_layanan SET id_data_layanan='$_POST[id_data_layanan]',nama_layanan='$_POST[nama_layanan]',id_dimensi_layanan='$_POST[id_dimensi_layanan]' WHERE id_data_layanan='$id_data_layanan';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: datalayanan.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['id_data_layanan'])){
        ?>  
         <div class="btn-paket"></div>
            <form action="" method="POST"  >
			<table>             
		<td>ID Data Layanan<input type="text" id="id_data_layanan" autocomplete="off" name="id_data_layanan" required value="<?php echo $_GET['id_data_layanan']?>"readonly></td>
        <tr><td>Nama Layanan<input type="text" id="nama_layanan" autocomplete="off" name="nama_layanan"  placeholder="nama_layanan" required value="<?php echo $_GET['nama_layanan'] ?>"></td>
        <tr><td>Nama Dimensi<td>
		<select name="id_dimensi_layanan" id="id_dimensi_layanan">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql2 = "SELECT * FROM dimensi_layanan";
			  $query2 = mysqli_query($conn, $sql2);
			  while($data2 = mysqli_fetch_array($query2)){
		 ?>
			  <option value="<?php echo $data2['id_dimensi_layanan']?>"><?php echo $data2['id_dimensi_layanan']?></option> 
		 <?php
		  }
		 ?>
		</select> 
        <tr>  
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="datalayanan.php" class="button button10">Refresh</a> <a href="datalayanan.php?aksi=delete&datalayanan=<?php echo $_GET['id_data_layanan'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['id_data_layanan']) && isset($_GET['aksi'])){
        $id_data_layanan = $_GET['id_data_layanan'];
        $sql_hapus = "DELETE FROM data_layanan WHERE id_data_layanan='$id_data_layanan'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: datalayanan.php');
                
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
            echo '<a href="datalayanan.php"> &laquo; Home</a>';
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
<a class="cta" href="kuesioner.php"><button class="button button1">Kembali</button></a>
</html>