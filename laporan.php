<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Analitik - Spa & Klinik</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color:#fffafb; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .main-content { padding: 30px; }
        
        /* Layout */
        .header-section { text-align: center; margin-bottom: 30px; }
        .stat-card { background: linear-gradient(135deg,#ad1457,#880e4f); color: white; padding: 30px; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 10px 20px rgba(173, 20, 87, 0.2); }
        .grid-laporan { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15pxrgba(0,0,0,0.05); }
        
        /* Tabel */
        .tabel-laporan { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .tabel-laporan th { color:#880e4f; padding: 12px; text-align: left; border-bottom: 2px solid#fce4ec; }
        .tabel-laporan td { padding: 12px; border-bottom: 1px solid#f9f9f9; }
        
        h3 { color:#ad1457; margin-top: 0; }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="header-section">
            <h2 class="page-title">Laporan Analitik Klinik</h2>
        </div>

        <div class="stat-card">
            <p style="margin:0; opacity: 0.9;">Total Pendapatan Keseluruhan</p>
            <?php
            $q1 = mysqli_query($conn, "SELECT SUM(grand_total) as total FROM Invoice_Spa");
            $d1 = mysqli_fetch_array($q1);
            ?>
            <h1 style="margin: 10px 0 0 0; font-size: 3rem;">Rp <?php echo number_format($d1['total'], 0, ',', '.'); ?></h1>
        </div>

        <div class="grid-laporan">
            <div class="card">
                <h3>2. Performa Terapis</h3>
                <table class="tabel-laporan">
                    <tr><th>Nama Terapis</th><th style="text-align:right;">Sesi</th></tr>
                    <?php
                    $q2 = mysqli_query($conn, "SELECT tr.nama_terapis, COUNT(db.id_terapis) as sesi FROM Terapis tr JOIN Detail_Booking db ON tr.id_terapis = db.id_terapis GROUP BY tr.id_terapis");
                    while($d2 = mysqli_fetch_array($q2)) {
                        echo "<tr><td>".$d2['nama_terapis']."</td><td style='text-align:right;'>".$d2['sesi']." Sesi</td></tr>";
                    }
                    ?>
                </table>
            </div>

            <div class="card">
                <h3>3. Top Spender (Klien Loyal)</h3>
                <table class="tabel-laporan">
                    <tr><th>Nama Klien</th><th style="text-align:right;">Pengeluaran</th></tr>
                    <?php
                    $q3 = mysqli_query($conn, "SELECT k.nama_klien, SUM(i.grand_total) as total FROM Klien k JOIN Booking b ON k.id_klien = b.id_klien JOIN Invoice_Spa i ON b.id_booking = i.id_booking GROUP BY k.id_klien ORDER BY total DESC LIMIT 5");
                    $rank = 1;
                    while ($r = mysqli_fetch_array($q3)) {
                        $icon = ($rank == 1) ? "👑 " : "";
                        echo "<tr><td>$icon ".$r['nama_klien']."</td><td style='text-align:right;'>Rp ".number_format($r['total'],0,',','.')."</td></tr>";
                        $rank++;
                    }
                    ?>
                </table>
            </div>

            <div class="card" style="grid-column: span 2;"> <h3>4. Treatment Paling Populer</h3>
                <table class="tabel-laporan">
                    <tr><th>Nama Treatment</th><th>Dipesan</th></tr>
                    <?php
                    $q4 = mysqli_query($conn, "SELECT t.nama_treatment, COUNT(db.id_treatment) as jml FROM Treatment t JOIN Detail_Booking db ON t.id_treatment = db.id_treatment GROUP BY t.id_treatment ORDER BY jml DESC");
                    while ($r = mysqli_fetch_array($q4)) {
                        echo "<tr><td>".$r['nama_treatment']."</td><td>".$r['jml']." kali</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>