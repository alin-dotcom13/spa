<?php 
session_start(); 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Utama</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <h2 class="page-title">Dashboard Utama</h2>
        
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:30px;">
            <div style="background:white; padding:25px; border-radius:10px; box-shadow:0 4px 10pxrgba(0,0,0,0.05); border-top:6px solid#ec407a;">
                <h3 style="color:#880e4f; margin:0; font-size:16px;">PENDAPATAN HARI INI</h3>
                <p style="font-size:28px; font-weight:700; margin:10px 0 0 0;">Rp <?php echo number_format($total_pendapatan ?? 0, 0, ',', '.'); ?></p>
            </div>
            <div style="background:white; padding:25px; border-radius:10px; box-shadow:0 4px 10pxrgba(0,0,0,0.05); border-top:6px solid#ec407a;">
                <h3 style="color:#880e4f; margin:0; font-size:16px;">TOTAL BOOKING HARI INI</h3>
                <p style="font-size:28px; font-weight:700; margin:10px 0 0 0;"><?php echo $total_booking ?? 0; ?> Klien</p>
            </div>
        </div>

        <div style="background:white; padding:25px; border-radius:10px; box-shadow:0 4px 10pxrgba(0,0,0,0.05); border-top:6px solid#ff9800;">
            <h3 style="color:#e65100; margin-top:0;">PERINGATAN STOK MENIPIS</h3>
            <table style="width:100%; border-collapse:collapse; margin-top:15px;">
                <tr style="background:#fff3e0; color:#e65100;">
                    <th style="padding:12px; text-align:left;">Nama Produk</th>
                    <th style="padding:12px; text-align:left;">Sisa Stok</th>
                    <th style="padding:12px; text-align:left;">Batas Min.</th>
                </tr>
                <?php
                $q_stok = mysqli_query($conn, "SELECT * FROM Produk_Kecantikan WHERE stok_saat_ini <= stok_minimum");
                while($s = mysqli_fetch_array($q_stok)) {
                    echo "<tr>
                        <td style='padding:12px; border-bottom:1px solid#eee;'>".$s['nama_produk']."</td>
                        <td style='padding:12px; border-bottom:1px solid#eee; color:red; font-weight:bold;'>".$s['stok_saat_ini']."</td>
                        <td style='padding:12px; border-bottom:1px solid#eee;'>".$s['stok_minimum']."</td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>