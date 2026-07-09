<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'koneksi.php';

$id_booking = isset($_GET['id_booking']) ? $_GET['id_booking'] : '';

// Proses Bayar
if (isset($_POST['bayar'])) {
    $id_b = $_POST['id_booking'];
    $total = $_POST['total'];
    
    $update_status = mysqli_query($conn, "UPDATE Booking SET id_status = 3 WHERE id_booking = '$id_b'");
    $insert_invoice = mysqli_query($conn, "INSERT INTO Invoice_Spa (id_booking, total_biaya_treatment, total_biaya_produk, grand_total, status_pembayaran) VALUES ('$id_b', '$total', 0, '$total', 'Lunas')");

    if ($update_status && $insert_invoice) {
        echo "<script>alert('Pembayaran Lunas!'); window.location='tampil_booking.php';</script>";
    }
}

// Data Booking
$query_data = mysqli_query($conn, "SELECT b.*, k.nama_klien, t.harga as harga_treatment, tr.nama_terapis, t.nama_treatment 
                                   FROM Booking b 
                                   JOIN Detail_Booking db ON b.id_booking = db.id_booking 
                                   JOIN Klien k ON b.id_klien = k.id_klien 
                                   JOIN Treatment t ON db.id_treatment = t.id_treatment 
                                   JOIN Terapis tr ON db.id_terapis = tr.id_terapis 
                                   WHERE b.id_booking = '$id_booking'");
$data = mysqli_fetch_array($query_data);
$grand_total = $data['harga_treatment'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kasir Pembayaran</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background:#fffafb; font-family: 'Montserrat', sans-serif; display: flex; margin: 0; }
        .main { flex: 1; padding: 40px; display: flex; justify-content: center; }
        .pembayaran-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30pxrgba(0,0,0,0.1); width: 100%; max-width: 500px; border-top: 8px solid#ad1457; }
        .detail-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px dashed#eee; }
        .total-tagihan { background:#fce4ec; color:#ad1457; padding: 20px; text-align: center; border-radius: 10px; font-size: 1.5rem; font-weight: bold; margin: 25px 0; border: 2px dashed#ad1457; }
        button { width: 100%; padding: 15px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; margin-bottom: 10px; }
        .btn-lunas { background:#ad1457; color: white; }
        .btn-print { background:#00acc1; color: white; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main">
    <?php if ($data) { ?>
    <div class="pembayaran-card">
        <h2 style="text-align:center; color:#ad1457;">Proses Pembayaran</h2>
        
        <div class="detail-item"><span>No. Booking</span> <strong>#<?php echo $data['id_booking']; ?></strong></div>
        <div class="detail-item"><span>Nama Klien</span> <strong><?php echo $data['nama_klien']; ?></strong></div>
        <div class="detail-item"><span>Terapis</span> <strong><?php echo $data['nama_terapis']; ?></strong></div>
        <div class="detail-item"><span>Treatment</span> <strong><?php echo $data['nama_treatment']; ?></strong></div>
        
        <div class="total-tagihan">Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></div>

        <form method="POST">
            <input type="hidden" name="id_booking" value="<?php echo $data['id_booking']; ?>">
            <input type="hidden" name="total" value="<?php echo $grand_total; ?>">
            
            <label>Metode Pembayaran:</label>
            <select name="metode_bayar" style="width:100%; padding:12px; margin-top:8px; margin-bottom:20px; border-radius:8px; border:1px solid#ddd;">
                <option>Tunai / Cash</option>
                <option>Transfer Bank</option>
            </select>

            <button type="submit" name="bayar" class="btn-lunas">Konfirmasi & Lunasi</button>
            <button type="button" onclick="window.print()" class="btn-print">🖨️ Cetak Struk</button>
        </form>
    </div>
    <?php } else { echo "<p>Data tidak ditemukan.</p>"; } ?>
</div>

</body>
</html>