<?php 
session_start();
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Klien</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="center-container">
            <div class="login-card">
                <h2 style="color:#d81b60; margin-top: 0; text-align: center;">Registrasi Klien Baru</h2>
                
                <form action="" method="POST">
                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 600;">Nama Klien</label>
                        <input type="text" name="nama" required style="width: 100%; padding: 12px; margin-top: 8px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    
                    <div style="margin-bottom: 25px;">
                        <label style="font-weight: 600;">Nomor HP</label>
                        <input type="text" name="hp" required style="width: 100%; padding: 12px; margin-top: 8px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    
                    <button type="submit" name="submit" class="btn-aksi" style="width: 100%;">Simpan Klien</button>
                </form>
                
                <div style="margin-top: 20px; text-align: center;">
                    <a href="index.php" style="color: #d81b60; text-decoration: none; font-size: 14px;">← Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
if(isset($_POST['submit'])){
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $hp = mysqli_real_escape_string($conn, $_POST['hp']);
        
        // Sesuaikan nama tabel 'Klien' dengan yang ada di database Anda
        $query = "INSERT INTO Klien (nama_klien, no_hp, saldo_poin) VALUES ('$nama', '$hp', 0)";
        
        if(mysqli_query($conn, $query)){
           echo "<script>alert('Klien berhasil didaftarkan!'); window.location='tambah_klien.php';</script>";
        } else {
           echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
        }
    }
    ?>
</html>