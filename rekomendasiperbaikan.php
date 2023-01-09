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
    <title>Rekomendasi Perbaikan</title>    
    <link rel="stylesheet" href="style.css">
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
    
    <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pengguna']; ?></button></a>
        <a class="cta" href="logoutpengguna.php"><button class="button button1">Logout</button></a>
    </header>    
      <div style='vertical-align:middle; display:inline; padding: 10px;'><a>Pengguna</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","","db_babydear_laundry")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $id_rekomendasi=$_POST['id_rekomendasi'];
        $id_data_layanan=$_POST['id_data_layanan'];
        $rekomendasi_perbaikan=$_POST['rekomendasi_perbaikan'];
        $id_pengguna=$_POST['id_pengguna'];

        if(!empty($id_rekomendasi) || !empty($id_data_layanan)|| !empty($rekomendasi_perbaikan)|| !empty($id_pengguna)){
            $sql = "insert into rekomendasi_perbaikan ( id_rekomendasi, id_data_layanan, rekomendasi_perbaikan, id_pengguna)" . 
              "values ( '$id_rekomendasi','$id_data_layanan','$rekomendasi_perbaikan','$id_pengguna')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: rekomendasiperbaikan.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?>
    <?php 
    $query4 = mysqli_query($conn, "SELECT max(id_rekomendasi) as kodeTerbesar FROM rekomendasi_perbaikan");
	$data4 = mysqli_fetch_array($query4);
	$id_rekomendasi = $data4['kodeTerbesar'];
	$urutan = (int) substr($id_rekomendasi, 4, 3);
	$urutan++;
	$huruf = "REK-";
	$id_rekomendasi= $huruf . sprintf("%03s", $urutan);
    ?> 
       <form method="POST" action="rekomendasiperbaikan.php">
<table>    
    <td>ID Rekomendasi<input type="text" name="id_rekomendasi" required="required" value="<?php echo $id_rekomendasi ?>" readonly></td>
    <tr><td>ID Data Layanan<td>
		<tr><td><select name="id_data_layanan" id="id_data_layanan">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql2 = "SELECT * FROM data_layanan";
			  $query2 = mysqli_query($conn, $sql2);
			  while($data2 = mysqli_fetch_array($query2)){
		 ?>
			  <option value="<?php echo $data2['id_data_layanan']?>"><?php echo $data2['nama_layanan']?></option> 
		 <?php
		  }
		 ?>
		</select>
    <tr><td>Rekomendasi Perbaikan<input type="text" name="rekomendasi_perbaikan" placeholder="rekomendasi perbaikan" required autocomplete="off">
	<tr><td>ID Pengguna<input type="text" name="id_pengguna" required="required" value="<?php echo $_SESSION['id_pengguna'] ?>" readonly></td>                  
      
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="rekomendasiperbaikan.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM rekomendasi_perbaikan";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>ID Rekomendasi</th>
        <th>ID Data Layanan</th>
        <th>Rekomendasi Perbaikan</th>
        <th>ID Pengguna</th>
        <th>Aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id_rekomendasi']; ?></td>
                <td><?php echo $data['id_data_layanan']; ?></td>
                <td><?php echo $data['rekomendasi_perbaikan']; ?></td>
                <td><?php echo $data['id_pengguna']; ?></td>
                <td>
                    <a href="rekomendasiperbaikan.php?aksi=update&id_rekomendasi=<?php echo $data['id_rekomendasi'];?>&id_data_layanan=<?php echo $data['id_data_layanan']; ?>?>&rekomendasi_perbaikan=<?php echo $data['rekomendasi_perbaikan']; ?>?>?>&id_pengguna=<?php echo $data['id_pengguna']; ?>">Edit</a> |
                    <a href="rekomendasiperbaikan.php?aksi=delete&id_rekomendasi=<?php echo $data['id_rekomendasi']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
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
		$id_rekomendasi=$_POST['id_rekomendasi'];
        $id_data_layanan=$_POST['id_data_layanan'];
        $rekomendasi_perbaikan=$_POST['rekomendasi_perbaikan'];
        $id_pengguna=$_POST['id_pengguna'];
        
      if(!empty($id_rekomendasi)&& !empty($id_data_layanan)&& !empty($rekomendasi_perbaikan)&& !empty($id_pengguna)){
        $sql_update = "UPDATE rekomendasi_perbaikan SET id_rekomendasi ='$_POST[id_rekomendasi]',id_data_layanan='$_POST[id_data_layanan]',rekomendasi_perbaikan='$_POST[rekomendasi_perbaikan]',id_pengguna='$_POST[id_pengguna]' WHERE id_rekomendasi='$id_rekomendasi';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: rekomendasiperbaikan.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['id_rekomendasi'])){
        ?>  
         <div class="btn-paket"></div>
            <form action="" method="POST"  >
			<table>    
    <td>ID Rekomendasi<input type="text" id="id_rekomendasi" autocomplete="off" name="id_rekomendasi" required value="<?php echo $_GET['id_rekomendasi']?>"></td>
    <tr><td>ID Data Layanan<td>
		<tr><td><select name="id_data_layanan" id="id_data_layanan">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql2 = "SELECT * FROM data_layanan";
			  $query2 = mysqli_query($conn, $sql2);
			  while($data2 = mysqli_fetch_array($query2)){
		 ?>
			  <option value="<?php echo $data2['id_data_layanan'];?>"><?php echo $data2['id_data_layanan'];?> - <?php echo $data2['nama_layanan'];?></option> 
		 <?php
		  }
		 ?>
		</select>
    <tr><td>Rekomendasi Perbaikan<input type="text" name="rekomendasi_perbaikan" placeholder="rekomendasi perbaikan" required autocomplete="off">
	<tr><td>ID Pengguna<input type="text" name="id_pengguna" required="required" value="<?php echo $_SESSION['id_pengguna'] ?>" readonly></td>
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="rekomendasiperbaikan.php" class="button button10">Refresh</a> <a href="rekomendasiperbaikan.php?aksi=delete&pengguna=<?php echo $_GET['id_rekomendasi'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['id_rekomendasi']) && isset($_GET['aksi'])){
        $id_rekomendasi = $_GET['id_rekomendasi'];
        $sql_hapus = "DELETE FROM rekomendasi_perbaikan WHERE id_rekomendasi='$id_rekomendasi'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: rekomendasiperbaikan.php');
                
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
            echo '<a href="rekomendasiperbaikan.php"> &laquo; Home</a>';
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
<a class="cta" href="halamanpemilik.php"><button class="button button1">Kembali</button></a>
</html>