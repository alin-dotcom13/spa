<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id_booking = isset($_GET['id_booking']) ? $_GET['id_booking'] : '';

// Mengambil rincian booking menggunakan nama tabel yang BENAR (Booking & Detail_Booking)
$query_info = mysqli_query($conn, "
    SELECT b.id_booking, k.nama_klien, t.nama_treatment
    FROM Booking b
    JOIN Detail_Booking db ON b.id_booking = db.id_booking
    JOIN Klien k ON b.id_klien = k.id_klien
    JOIN Treatment t ON db.id_treatment = t.id_treatment
    WHERE b.id_booking = '$id_booking'
");

$info = mysqli_fetch_array($query_info);

if (isset($_POST['simpan_selesai'])) {
    $id_b = $_POST['id_booking'];
    $durasi = $_POST['durasi_aktual'];
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan_terapis']);
    $id_produk = $_POST['id_produk'];
    $jumlah_beli = $_POST['jumlah_produk'];

    // 1. Catat penggunaan produk (Menggunakan id_booking dan qty_dipakai)
    mysqli_query($conn, "INSERT INTO Penggunaan_Produk (id_booking, id_produk, qty_dipakai) VALUES ('$id_b', '$id_produk', '$jumlah_beli')");

    // 2. Kurangi stok produk secara manual
    mysqli_query($conn, "UPDATE Produk_Kecantikan SET stok_saat_ini = stok_saat_ini - '$jumlah_beli' WHERE id_produk = '$id_produk'");

    // Langsung alihkan ke halaman kasir
    echo "<script>alert('Detail perawatan berhasil dicatat!'); window.location='kasir.php?id_booking=".$id_b."';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Perawatan Selesai</title>
    <link rel="stylesheet" href="style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color:#fffafb; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-container { background: white; padding: 30px 40px; border-radius: 10px; box-shadow: 0 4px 10pxrgba(0, 0, 0, 0.1); border-top: 5px solid#f06292; width: 100%; max-width: 400px; }
        h2 { color:#d81b60; border-bottom: 2px solid#f8bbd0; padding-bottom: 10px; margin-top: 0; text-align: center; }
        .info-box { background:#fce4ec; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; color:#333; line-height: 1.5; }
        input, select, textarea { padding: 10px; margin-bottom: 15px; border: 1px solid#f48fb1; border-radius: 5px; width: 100%; box-sizing: border-box; background-color: white; }
        input:focus, select:focus, textarea:focus { outline: none; border-color:#d81b60; }
        button { background-color:#f06292; color: white; padding: 12px; border: none; border-radius: 20px; cursor: pointer; font-weight: bold; width: 100%; }
        button:hover { background-color:#e91e63; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color:#d81b60; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Pencatatan Selesai</h2>
        
        <div class="info-box">
            <strong>Klien:</strong> <?php echo isset($info['nama_klien']) ? $info['nama_klien'] : '-'; ?><br>
            <strong>Treatment:</strong> <?php echo isset($info['nama_treatment']) ? $info['nama_treatment'] : '-'; ?>
        </div>

        <form method="POST">
            <input type="hidden" name="id_booking" value="<?php echo $id_booking; ?>">

            <label style="font-size:14px; font-weight:bold; color:#d81b60;">Durasi Aktual (Menit):</label>
            <input type="number" name="durasi_aktual" placeholder="Contoh: 60" required>

            <label style="font-size:14px; font-weight:bold; color:#d81b60;">Catatan Terapis:</label>
            <textarea name="catatan_terapis" rows="3" placeholder="Kondisi kulit klien atau saran..." required></textarea>

            <label style="font-size:14px; font-weight:bold; color:#d81b60;">Produk yang Digunakan:</label>
            <select name="id_produk" required>
                <option value="">-- Pilih Produk --</option>
                <?php
                $produk = mysqli_query($conn, "SELECT * FROM Produk_Kecantikan");
                if($produk) {
                    while($p = mysqli_fetch_array($produk)){
                        echo "<option value='".$p['id_produk']."'>".$p['nama_produk']."</option>";
                    }
                }
                ?>
            </select>

            <label style="font-size:14px; font-weight:bold; color:#d81b60;">Jumlah Produk Terpakai:</label>
            <input type="number" name="jumlah_produk" value="1" min="1" required>

            <button type="submit" name="simpan_selesai">Simpan & Lanjut ke Kasir</button>
        </form>
        <a href="tampil_booking.php" class="btn-back">Kembali ke Antrean</a>
    </div>

</body>
</html>