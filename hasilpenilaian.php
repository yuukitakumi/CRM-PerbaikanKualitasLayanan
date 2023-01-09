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
    <title>Hasil Penilaian</title>    
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
        $id_hasil = $_POST['id_hasil'];
        $id_penilaian = $_POST['id_penilaian'];
        $id_rekomendasi = $_POST['id_rekomendasi'];
        $nomor = $_POST['nomor'];


        if(!empty($id_hasil)){
            $sql = "INSERT INTO hasil_penilaian (id_hasil, id_penilaian,
            gap, id_rekomendasi)
           SELECT
           '$id_hasil' AS id_hasil,
           '$id_penilaian' AS id_penilaian,
           (rata_kenyataan-rata_harapan) AS gap,
           '$id_rekomendasi' AS id_rekomendasi
           FROM data_penilaian INNER JOIN rekomendasi_perbaikan
           ON rekomendasi_perbaikan.id_data_layanan = data_penilaian.id_data_layanan 
           WHERE rekomendasi_perbaikan.id_data_layanan = $nomor ";

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
    $query1 = mysqli_query($conn, "SELECT max(id_hasil) as kodeTerbesar FROM hasil_penilaian");
	$data1 = mysqli_fetch_array($query1);
	$id_hasil = $data1['kodeTerbesar'];
	$urutan = (int) substr($id_hasil, 4, 3);
	$urutan++;
	$huruf = "HAP-";
	$id_hasil= $huruf . sprintf("%03s", $urutan);
    ?>
     <?php 
    $query2 = mysqli_query($conn, "SELECT max(id_penilaian) as kodeTerbesar1 FROM hasil_penilaian");
	$data2 = mysqli_fetch_array($query2);
	$id_penilaian = $data2['kodeTerbesar1'];
	$urutan2 = (int) substr($id_penilaian, 4, 3);
	$urutan2++;
	$huruf2 = "IAN-";
	$id_penilaian= $huruf2 . sprintf("%03s", $urutan2);
    ?>
     <?php 
    $query3 = mysqli_query($conn, "SELECT max(id_rekomendasi) as kodeTerbesar2 FROM hasil_penilaian");
	$data3 = mysqli_fetch_array($query3);
	$id_rekomendasi = $data3['kodeTerbesar2'];
	$urutan3 = (int) substr($id_rekomendasi, 4, 3);
	$urutan3++;
	$huruf3 = "REK-";
	$id_rekomendasi= $huruf3 . sprintf("%03s", $urutan3);
    ?>
     <?php 
    $query5 = mysqli_query($conn, "SELECT COUNT(id_hasil) as idbesar FROM hasil_penilaian");
	$data5 = mysqli_fetch_array($query5);
	$nomor = $data5['idbesar'];
	$nomor++;
    ?>
       <form method="POST" action="hasilpenilaian.php">
<table>
    <td>Nomor<input type="text" name="nomor" required="required" value="<?php echo $nomor ?>" readonly></td>    
    <td>ID Hasil<input type="text" name="id_hasil" required="required" value="<?php echo $id_hasil ?>" readonly></td>
    <td>ID Penilaian<input type="text" name="id_penilaian" required="required" value="<?php echo $id_penilaian ?>" readonly></td>
    <td>ID Rekomendasi<input type="text" name="id_rekomendasi" required="required" value="<?php echo $id_rekomendasi ?>" readonly></td>
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Hitung</button>
</div>
                
        </form>
    <?php
}

function tampil_data($conn){
    $sql4 = "SELECT id_hasil, data_layanan.nama_layanan AS Layanan, 
     gap, rekomendasi_perbaikan.rekomendasi_perbaikan AS nama_rekomendasi 
        FROM hasil_penilaian 
       INNER JOIN rekomendasi_perbaikan
       ON rekomendasi_perbaikan.id_rekomendasi = hasil_penilaian.id_rekomendasi
       INNER JOIN data_layanan
       ON data_layanan.id_data_layanan = rekomendasi_perbaikan.id_data_layanan
       ORDER BY gap ASC LIMIT 3;";
    $query4 = mysqli_query($conn, $sql4);
       
    echo "<table id='customers'>";
    echo "<tr>
    <th>Rekomendasi Perbaikan</th>
<tr>
        <th>ID Hasil</th>
        <th>Nama Layanan</th>
        <th>Nilai Gap Tertinggi</th>
        <th>Rekomendasi Perbaikan</th>
        </tr>";
    
    while($data4 = mysqli_fetch_array($query4)){
        ?>
            <tr>
                <td><?php echo $data4['id_hasil']; ?></td>
                <td><?php echo $data4['Layanan']; ?></td>
                <td><?php echo $data4['gap']; ?></td>
                <td><?php echo $data4['nama_rekomendasi']; ?></td>
                <td>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
}


// --- Program Utama
if (isset($_GET['aksi'])){
    switch($_GET['aksi']){
        case "create":
            echo '<a href="hasilpenilaian.php"> &laquo; Home</a>';
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