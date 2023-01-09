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
    <title>Data Penilaian</title>    
    <link rel="stylesheet" href="style.css">
    <link href="logobaby.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="logobaby.png" alt="logo" width="100px" height="200px">
    
    <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['id_pengguna']; ?></button></a>
        <a class="cta" href="logoutpengguna.php"><button class="button button1">Logout</button></a>
    </header>    
      <div style='vertical-align:middle; display:inline; padding: 10px;'><a></div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","","db_babydear_laundry")or die(mysqli_error());

function tambah($conn){ 
    if (isset($_POST['simpan'])){
        $id_penilaian = $_POST['id_penilaian'];
        $id_data_layanan = $_POST['id_data_layanan'];

        if(!empty($id_penilaian)){
            $sql = "INSERT INTO data_penilaian (id_penilaian, bobot_kenyataan,
            bobot_harapan, rata_kenyataan, rata_harapan, id_data_layanan)
           SELECT
           '$id_penilaian' AS id_penilaian,
           SUM(kenyataan), 
           SUM(harapan), 
           AVG(kenyataan), 
           AVG(harapan),
           jawaban_kuesioner.id_data_layanan
           FROM jawaban_kuesioner 
           WHERE jawaban_kuesioner.id_data_layanan = $id_data_layanan ";
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
    $query1 = mysqli_query($conn, "SELECT max(id_penilaian) as kodeTerbesar FROM data_penilaian");
	$data1 = mysqli_fetch_array($query1);
	$id_penilaian = $data1['kodeTerbesar'];
	$urutan = (int) substr($id_penilaian, 4, 3);
	$urutan++;
	$huruf = "IAN-";
	$id_penilaian= $huruf . sprintf("%03s", $urutan);
    ?>
     <?php 
    $query2 = mysqli_query($conn, "SELECT max(id_data_layanan) as idbesar FROM data_penilaian");
	$data2 = mysqli_fetch_array($query2);
	$id_data_layanan = $data2['idbesar'];
	$id_data_layanan++;
    ?>
       <form method="POST" action="datapenilaian.php">
<table>    
    <td>ID Penilaian<input type="text" name="id_penilaian" required="required" value="<?php echo $id_penilaian ?>" readonly></td>
    <td>ID Data Layanan<input type="text" name="id_data_layanan" required="required" value="<?php echo $id_data_layanan ?>" readonly></td>
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Hitung</button>
</div>
                
        </form>
    <?php
}

function tampil_data($conn){
    $sql4 = "SELECT * FROM data_penilaian";
    $query4 = mysqli_query($conn, $sql4);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>ID Penilaian</th>
        <th>Bobot Kenyataan</th>
        <th>Bobot Harapan</th>
        <th>Rata-Rata Kenyataan</th>
        <th>Rata-Rata Harapan</th>
        <th>ID Data Layanan</th>
        <th>Aksi</th>
        </tr>";
    
    while($data4 = mysqli_fetch_array($query4)){
        ?>
            <tr>
                <td><?php echo $data4['id_penilaian']; ?></td>
                <td><?php echo $data4['bobot_kenyataan']; ?></td>
                <td><?php echo $data4['bobot_harapan']; ?></td>
                <td><?php echo $data4['rata_kenyataan']; ?></td>
                <td><?php echo $data4['rata_harapan']; ?></td>
                <td><?php echo $data4['id_data_layanan']; ?></td>
                <td>
                <a href="datapenilaian.php?aksi=delete&id_penilaian=<?php echo $data4['id_penilaian']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
}

function hapus($conn){
    if(isset($_GET['id_penilaian']) && isset($_GET['aksi'])){
        $id_penilaian = $_GET['id_penilaian'];
        $sql_hapus = "DELETE FROM data_penilaian WHERE id_penilaian='$id_penilaian'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: datapenilaian.php');
                
            }
        }
    }  
}

// --- Program Utama
if (isset($_GET['aksi'])){
    switch($_GET['aksi']){
        case "create":
            echo '<a href="datapenilaian.php"> &laquo; Home</a>';
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