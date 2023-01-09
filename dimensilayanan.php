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
    <title>Dimensi Layanan</title>    
    <link rel="stylesheet" href="style.css">
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
    
    <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pengguna']; ?></button></a>
        <a class="cta" href="logoutpengguna.php"><button class="button button1">Logout</button></a>
    </header>    
      <div style='vertical-align:middle; display:inline; padding: 10px;'><a>Dimensi Layanan</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","","db_babydear_laundry")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $id_dimensi_layanan=$_POST['id_dimensi_layanan'];
        $nama_dimensi=$_POST['nama_dimensi'];
        
        if(!empty($id_dimensi_layanan) || !empty($nama_dimensi)){
            $sql = "insert into dimensi_layanan ( id_dimensi_layanan, nama_dimensi)" . 
              "values ( '$id_dimensi_layanan','$nama_dimensi')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: dimensilayanan.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
       <form method="POST" action="dimensilayanan.php">
<table>
    <td>ID Dimensi Layanan<input type="text" name="id_dimensi_layanan" placeholder="ID Dimensi Layanan"  required autocomplete="off" ></td>
		<tr><td>Nama Dimensi<input type="text" name="nama_dimensi" placeholder="Nama Dimensi" required autocomplete="off"></td>                  
    <tr> 
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="dimensilayanan.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM dimensi_layanan";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>ID Dimensi Layanan</th>
        <th>Nama Dimensi</th>
        <th>Aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id_dimensi_layanan']; ?></td>
                <td><?php echo $data['nama_dimensi']; ?></td>
                <td>
                    <a href="dimensilayanan.php?aksi=update&id_dimensi_layanan=<?php echo $data['id_dimensi_layanan'];?>&nama_dimensi=<?php echo $data['nama_dimensi']; ?>">Edit</a> |
                    <a href="dimensilayanan.php?aksi=delete&id_dimensi_layanan=<?php echo $data['id_dimensi_layanan']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
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
		$id_dimensi_layanan=$_POST['id_dimensi_layanan'];
        $nama_dimensi=$_POST['nama_dimensi'];

        
      if(!empty($id_dimensi_layanan)&& !empty($nama_dimensi)){
        $sql_update = "UPDATE dimensi_layanan SET id_dimensi_layanan='$_POST[id_dimensi_layanan]',nama_dimensi='$_POST[nama_dimensi]' WHERE id_dimensi_layanan='$id_dimensi_layanan';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: dimensilayanan.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['id_dimensi_layanan'])){
        ?>  
         <div class="btn-paket"></div>
            <form action="" method="POST"  >
			<table>
		<td>ID Dimensi Layanan<input type="text" id="id_dimensi_layanan" autocomplete="off" name="id_dimensi_layanan" required value="<?php echo $_GET['id_dimensi_layanan']?>"></td>
        <tr><td>Nama Dimensi<input type="text" id="nama_dimensi" autocomplete="off" name="nama_dimensi"  placeholder="nama_dimensi" required value="<?php echo $_GET['nama_dimensi'] ?>"></td>
        <tr> 
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="dimensilayanan.php" class="button button10">Refresh</a> <a href="dimensilayanan.php?aksi=delete&dimensilayanan=<?php echo $_GET['id_dimensi_layanan'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['id_dimensi_layanan']) && isset($_GET['aksi'])){
        $id_dimensi_layanan = $_GET['id_dimensi_layanan'];
        $sql_hapus = "DELETE FROM dimensi_layanan WHERE id_dimensi_layanan='$id_dimensi_layanan'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: dimensilayanan.php');
                
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
            echo '<a href="dimensilayanan.php"> &laquo; Home</a>';
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