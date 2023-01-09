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
    <title>Pengguna</title>    
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
        $id_pengguna=$_POST['id_pengguna'];
        $nama=$_POST['nama'];
        $jabatan=$_POST['jabatan'];
        $password=$_POST['password'];

        if(!empty($id_pengguna) || !empty($nama)|| !empty($jabatan)|| !empty($password)){
            $sql = "insert into pengguna ( id_pengguna, nama, jabatan, password)" . 
              "values ( '$id_pengguna','$nama','$jabatan','$password')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: pengguna1.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?>
    <?php 
    $query4 = mysqli_query($conn, "SELECT max(id_pengguna) as kodeTerbesar FROM pengguna");
	$data4 = mysqli_fetch_array($query4);
	$id_pengguna = $data4['kodeTerbesar'];
	$urutan = (int) substr($id_pengguna, 4, 3);
	$urutan++;
	$huruf = "PEN-";
	$id_pengguna= $huruf . sprintf("%03s", $urutan);
    ?> 
       <form method="POST" action="pengguna1.php">
<table>    
    <td>ID Pengguna<input type="text" name="id_pengguna" required="required" value="<?php echo $id_pengguna ?>" readonly></td>
	<tr><td>Nama<input type="text" name="nama" placeholder="Nama" required autocomplete="off"></td>                  
    <tr><td>Jabatan<td>
		<select name="jabatan" id="jabatan">
		 <option disabled selected> Pilih </option>
		 <option value = "Admin">Admin</option>
		</select>
    <tr><td>Password<input type="password" name="password" placeholder="Password" required autocomplete="off"></td>
        <tr>  
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="pengguna1.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM pengguna where id_pengguna = '$_SESSION[id_pengguna]'";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>ID Pengguna</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Password</th>
        <th>Aksi </th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id_pengguna']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['jabatan']; ?></td>
                <td><?php echo $data['password']; ?></td>
                <td>
                    <a href="pengguna1.php?aksi=update&id_pengguna=<?php echo $data['id_pengguna'];?>&nama=<?php echo $data['nama']; ?>&jabatan=<?php echo $data['jabatan']; ?>&password=<?php echo $data['password']; ?>">Edit</a> |
                    <a href="pengguna1.php?aksi=delete&id_pengguna=<?php echo $data['id_pengguna']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
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
		$id_pengguna=$_POST['id_pengguna'];
        $nama=$_POST['nama'];
        $jabatan=$_POST['jabatan'];
        $password=$_POST['password'];
        
      if(!empty($id_pengguna)&& !empty($nama)&& !empty($jabatan)&& !empty($password)){
        $sql_update = "UPDATE pengguna SET id_pengguna='$_POST[id_pengguna]',nama='$_POST[nama]',jabatan='$_POST[jabatan]',password='$_POST[password]' WHERE id_pengguna='$id_pengguna';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: pengguna1.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['id_pengguna'])){
        ?>  
         <div class="btn-paket"></div>
            <form action="" method="POST"  >
			<table>             
		<td>ID Pengguna<input type="text" id="id_pengguna" autocomplete="off" name="id_pengguna" required value="<?php echo $_GET['id_pengguna']?>" readonly></td>
        <tr><td>Nama<input type="text" id="nama" autocomplete="off" name="nama"  placeholder="nama" required value="<?php echo $_GET['nama'] ?>"></td>
        <tr><td>Jabatan<td>
		<select name="jabatan" id="jabatan">
		 <option disabled selected> Pilih </option>
		 <option value = "Admin">Admin</option>
		</select>
        <tr><td>Password<input type="password" name="password" placeholder="Password" required autocomplete="off"></td>
        <tr>  
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="pengguna1.php" class="button button10">Refresh</a> <a href="pengguna1.php?aksi=delete&pengguna1=<?php echo $_GET['id_pengguna'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['id_pengguna']) && isset($_GET['aksi'])){
        $id_pengguna = $_GET['id_pengguna'];
        $sql_hapus = "DELETE FROM pengguna WHERE id_pengguna='$id_pengguna'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: pengguna1.php');
                
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
            echo '<a href="pengguna1.php"> &laquo; Home</a>';
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