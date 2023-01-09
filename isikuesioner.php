<?php
// Include config file
require_once "koneksi.php";
    session_start();
    if (!isset($_SESSION['id_pelanggan'])){
        header("Location: loginpelanggan.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Kuesioner</title>    
    <link rel="stylesheet" href="style.css">
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
    
    <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pelanggan']; ?></button></a>
        <a class="cta" href="logoutpelanggan.php"><button class="button button1">Logout</button></a>
    </header>    
      <div style='vertical-align:middle; display:inline; padding: 10px;'><a>Isi Kuesioner</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","","db_babydear_laundry")or die(mysqli_error());
// --- Tutup Fungsi tambah data
function tambah($conn){
    if (isset($_POST['simpan'])){
        $id_jawaban=$_POST['id_jawaban'];
        $id_data_layanan=$_POST['id_data_layanan'];
        $kenyataan=$_POST['kenyataan'];
        $harapan=$_POST['harapan'];
        
        
        if(!empty($id_data_layanan) || !empty($kenyataan)|| !empty($harapan)|| !empty($id_jawaban)){
            $sql = "insert into jawaban_kuesioner ( id_jawaban, id_data_layanan, kenyataan, harapan, id_pelanggan)" . 
              "values ( '$id_jawaban','$id_data_layanan','$kenyataan','$harapan','$_SESSION[id_pelanggan]')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: isikuesioner.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
    <?php 
    $query4 = mysqli_query($conn, "SELECT max(id_jawaban) as kodeTerbesar FROM jawaban_kuesioner");
	$data4 = mysqli_fetch_array($query4);
	$id_jawaban = $data4['kodeTerbesar'];
	$urutan = (int) substr($id_jawaban, 3, 3);
	$urutan++;
	$huruf = "JWB";
	$id_jawaban= $huruf . sprintf("%03s", $urutan);
    ?>
       <form method="POST" action="isikuesioner.php">
<table>
<tr><td>ID Jawaban<td><input type="text" name="id_jawaban" required="required" value="<?php echo $id_jawaban ?>" readonly>
<tr><td>ID Data Layanan<td>
		<select name="id_data_layanan" id="id_data_layanan">
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

    <tr><td>Kenyataan</td>
    <tr><td><input type="radio" name="kenyataan" value=1>1
    <input type="radio" name="kenyataan" value=2>2
    <input type="radio" name="kenyataan" value=3>3
    <input type="radio" name="kenyataan" value=4>4
    <input type="radio" name="kenyataan" value=5>5</td>
    
    <tr><td>Harapan</td></tr>
    <td><input type="radio" name="harapan" value=1>1
    <input type="radio" name="harapan" value=2>2
    <input type="radio" name="harapan" value=3>3
    <input type="radio" name="harapan" value=4>4
    <input type="radio" name="harapan" value=5>5</td></tr>                 
    <tr> 
</table>
<div class="btn-customer">
    <br>
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="isikuesioner.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data

// --- Tutup Fungsi Baca Data (Read)
function tampil_data_jawaban($conn){
    $sql3 = "SELECT * FROM jawaban_kuesioner where id_pelanggan = '$_SESSION[id_pelanggan]'";
    $query3 = mysqli_query($conn, $sql3);
       
    echo "<table id='customers'>";
    echo "<tr>
    <tr><th>Tabel Jawaban </tr>
        <th>ID Jawaban</th>
        <th>Kenyataan</th>
        <th>Harapan</th>
        <th>ID Pelanggan</th>
        <th>ID Data Layanan</th>
        <th> Aksi</th>
        </tr>";
    
    while($data3 = mysqli_fetch_array($query3)){
        ?>
            <tr>
                <td><?php echo $data3['id_jawaban']; ?></td>
                <td><?php echo $data3['kenyataan']; ?></td>
                <td><?php echo $data3['harapan']; ?></td>
                <td><?php echo $data3['id_pelanggan']; ?></td>
                <td><?php echo $data3['id_data_layanan']; ?></td>
                <td><a href="isikuesioner.php?aksi=delete&id_jawaban=<?php echo $data3['id_jawaban']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['id_jawaban']) && isset($_GET['aksi'])){
        $id_jawaban = $_GET['id_jawaban'];
        $sql_hapus = "DELETE FROM jawaban_kuesioner WHERE id_jawaban='$id_jawaban'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: isikuesioner.php');
                
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
 
            tampil_data_jawaban($conn);
            break;
        case "update":
            //ubah($conn);

            tampil_data_jawaban($conn);
            break;
        case "delete":
            hapus($conn);
            tambah($conn);

            tampil_data_jawaban($conn);
            break;
        default:
            echo "<h3>Aksi<i>".$_GET['aksi']."</i> tidak ada!</h3>";
            tambah($conn);

            tampil_data_jawaban($conn);
    }
} else {
    tambah($conn);

    tampil_data_jawaban($conn);
    
}
?>
</body><br>
<a class="cta" href="menupelanggan.php"><button class="button button1">Kembali</button></a>
</html>