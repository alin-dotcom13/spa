<?php

include 'koneksi.php';

// 1. Menghitung Pendapatan Hari Ini (Hanya yang sudah Lunas)
$query_pendapatan = mysqli_query($conn, "
    SELECT COALESCE(SUM(i.grand_total), 0) AS total_hari_ini 
    FROM Invoice_Spa i
    JOIN Booking b ON i.id_booking = b.id_booking
    WHERE DATE(b.tanggal_waktu_booking) = CURDATE() AND i.status_pembayaran = 'Lunas'
");
$pendapatan = mysqli_fetch_assoc($query_pendapatan);

// 2. Menghitung Jumlah Booking Hari Ini
$query_booking = mysqli_query($conn, "
    SELECT COUNT(id_booking) AS total_booking 
    FROM Booking 
    WHERE DATE(tanggal_waktu_booking) = CURDATE()
");
$booking = mysqli_fetch_assoc($query_booking);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Klinik Kecantikan & Spa</title>
    <link rel="stylesheet" href="style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
    @keyframes shimmerEffect {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    .sidebar {
        background: linear-gradient(135deg, #f48fb1 0%, #ffc1e3 50%, #f48fb1 100%);
        background-size: 200% 200%;
        animation: shimmerEffect 6s ease infinite;
    }
</style> <head>
<body style="font-family: Arial, sans-serif; padding: 20px;">

    <h2>Selamat Datang di Dashboard Admin Spa</h2>
    
    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div style="border: 1px solid#ccc; padding: 15px; border-radius: 8px; background-color:#e8f5e9; width: 250px;">
            <h4 style="margin: 0; color:#2e7d32;">Pendapatan Hari Ini</h4>
            <h1 style="margin: 10px 0 0 0;">Rp <?php echo number_format($pendapatan['total_hari_ini'], 0, ',', '.'); ?></h1>
        </div>
        <div style="border: 1px solid#ccc; padding: 15px; border-radius: 8px; background-color:#e3f2fd; width: 250px;">
            <h4 style="margin: 0; color:#1565c0;">Total Booking Hari Ini</h4>
            <h1 style="margin: 10px 0 0 0;"><?php echo $booking['total_booking']; ?> Klien</h1>
        </div>
    </div>

    <h3 style="color:#c62828;">Peringatan Stok Produk Menipis</h3>
    <?php
    $query_stok = mysqli_query($conn, "SELECT * FROM stok_produk_menipis");
    
    if (mysqli_num_rows($query_stok) > 0) {
        echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse; width: 50%;'>
                <tr style='background-color:#ffebee;'>
                    <th>Nama Produk</th>
                    <th>Stok Saat Ini</th>
                    <th>Batas Minimum</th>
                </tr>";
        while($stok = mysqli_fetch_array($query_stok)){
            echo "<tr>
                    <td>".$stok['nama_produk']."</td>
                    <td style='color: red; font-weight: bold; text-align: center;'>".$stok['stok_saat_ini']."</td>
                    <td style='text-align: center;'>".$stok['stok_minimum']."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: green; font-weight: bold;'> Semua stok produk dalam kondisi aman!</p>";
    }
    ?>

    <br>

    <h3> Jadwal Terapis Hari Ini</h3>
    <?php
    $query_jadwal = mysqli_query($conn, "SELECT * FROM jadwal_terapis_hari_ini");
    
    if (mysqli_num_rows($query_jadwal) > 0) {
        echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse; width: 70%;'>
                <tr style='background-color:#f3e5f5;'>
                    <th>Jam Mulai</th>
                    <th>Nama Terapis</th>
                    <th>Klien</th>
                    <th>Treatment</th>
                </tr>";
        while($jadwal = mysqli_fetch_array($query_jadwal)){
        }
    }