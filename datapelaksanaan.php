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
    <title>Data Pelaksanaan</title>    
    <link rel="stylesheet" href="style.css">
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
    
    <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pengguna']; ?></button></a>
        <a class="cta" href="logoutpengguna.php"><button class="button button1">Logout</button></a>
    </header>    
      <div style='vertical-align:middle; display:inline; padding: 10px;'><a>Data Pelaksanaan</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","","db_babydear_laundry")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $id_pelaksanaan=$_POST['id_pelaksanaan'];
        $tanggal=$_POST['tanggal'];
        $jumlah_responden=$_POST['jumlah_responden'];
        
        if(!empty($id_pelaksanaan) || !empty($tanggal)|| !empty($jumlah_responden)){
            $sql = "insert into data_pelaksanaan ( id_pelaksanaan, tanggal, jumlah_responden)" . 
              "values ( '$id_pelaksanaan','$tanggal','$jumlah_responden')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: datapelaksanaan.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
       <form method="POST" action="datapelaksanaan.php">
<table>    
    <td>ID Data Layanan<input type="text" name="id_pelaksanaan" placeholder="ID Data Layanan"  required autocomplete="off" ></td>
	<tr><td>Nama Layanan<input type="date" name="tanggal" placeholder="Nama Layanan" required autocomplete="off"></td> 
    <tr><td>Jumlah Responden<input type="text" name="jumlah_responden" placeholder="jumlah responden" required autocomplete="off"></td>                   
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="datapelaksanaan.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM data_pelaksanaan";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>ID Pelaksanaan</th>
        <th>Tanggal</th>
        <th>Jumlah Responden</th>
        <th>Aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id_pelaksanaan']; ?></td>
                <td><?php echo $data['tanggal']; ?></td>
                <td><?php echo $data['jumlah_responden']; ?></td>
                <td>
                    <a href="datapelaksanaan.php?aksi=update&id_pelaksanaan=<?php echo $data['id_pelaksanaan'];?>&tanggal=<?php echo $data['tanggal']; ?>?>&jumlah_responden=<?php echo $data['jumlah_responden']; ?>">Edit</a> |
                    <a href="datapelaksanaan.php?aksi=delete&id_pelaksanaan=<?php echo $data['id_pelaksanaan']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
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
		$id_pelaksanaan=$_POST['id_pelaksanaan'];
        $tanggal=$_POST['tanggal'];
        $jumlah_responden=$_POST['jumlah_responden'];
        
      if(!empty($id_pelaksanaan)&& !empty($tanggal)&& !empty($jumlah_responden)){
        $sql_update = "UPDATE data_pelaksanaan SET id_pelaksanaan='$_POST[id_pelaksanaan]',tanggal='$_POST[tanggal]',jumlah_responden='$_POST[jumlah_responden]' WHERE id_pelaksanaan='$id_pelaksanaan';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: datapelaksanaan.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['id_pelaksanaan'])){
        ?>  
         <div class="btn-paket"></div>
            <form action="" method="POST"  >
			<table>             
		<td>ID Data Layanan<input type="text" id="id_pelaksanaan" autocomplete="off" name="id_pelaksanaan" required value="<?php echo $_GET['id_pelaksanaan']?>"></td>
        <tr><td>Tanggal<input type="date" id="tanggal" autocomplete="off" name="tanggal"  placeholder="tanggal" required value="<?php echo $_GET['tanggal'] ?>"></td>
        <tr><td>Jumlah Responden<input type="text" id="jumlah_responden" autocomplete="off" name="jumlah_responden"  placeholder="jumlah_responden" required value="<?php echo $_GET['jumlah_responden'] ?>"></td>
         
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="datapelaksanaan.php" class="button button10">Refresh</a> <a href="datapelaksanaan.php?aksi=delete&datapelaksanaan=<?php echo $_GET['id_pelaksanaan'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['id_pelaksanaan']) && isset($_GET['aksi'])){
        $id_pelaksanaan = $_GET['id_pelaksanaan'];
        $sql_hapus = "DELETE FROM data_pelaksanaan WHERE id_pelaksanaan='$id_pelaksanaan'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: datapelaksanaan.php');
                
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
            echo '<a href="datapelaksanaan.php"> &laquo; Home</a>';
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