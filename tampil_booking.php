<?php 
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Antrean & Kasir - Spa & Klinik</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Gaya Judul Seragam */
        .page-title { color: #ad1457; font-size: 28px; font-weight: 700; margin-bottom: 25px; padding-bottom: 10px; border-left: 6px solid #ad1457; padding-left: 15px; }

        /* Tabel Profesional */
        .tabel-booking { 
            width: 100%; border-collapse: collapse; margin-top: 20px; background: white; 
            border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 5px solid #ad1457;
        }
        .tabel-booking th { background: #ad1457; color: white; padding: 16px; text-align: left; font-size: 0.9rem; }
        .tabel-booking td { padding: 16px; border-bottom: 1px solid #fdf2f6; vertical-align: middle; }
        
        .col-id { width: 80px; }
        .col-waktu { width: 110px; }
        .col-status { width: 150px; text-align: center; }
        .col-aksi { width: 140px; text-align: center; }

        /* Badge & Tombol */
        .badge { padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 11px; display: inline-block; }
        .btn-kasir { 
            background: #ad1457; color: white; padding: 8px 15px; border-radius: 6px; 
            text-decoration: none; font-size: 12px; font-weight: bold; display: inline-block;
        }
        .btn-kasir:hover { background: #880e4f; }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content" style="padding: 30px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <h2 class="page-title">Daftar Booking</h2>
            <a href="tambah_booking.php" 
   style="background-color: #d81b60; 
          color: white; 
          width: 50px; 
          height: 50px; 
          display: flex; 
          align-items: center; 
          justify-content: center; 
          text-decoration: none; 
          border-radius: 50%; /* Membuat tombol bulat sempurna */
          font-weight: bold; 
          font-size: 24px; 
          box-shadow: 0 4px 6px rgba(173, 20, 87, 0.3);">
    +
</a>
        </div>

        <?php
        $sql = "SELECT b.id_booking, k.nama_klien, t.nama_treatment, tr.nama_terapis, b.tanggal_waktu_booking, sb.nama_status 
                FROM Booking b
                JOIN Detail_Booking db ON b.id_booking = db.id_booking 
                JOIN Klien k ON b.id_klien = k.id_klien 
                JOIN Treatment t ON db.id_treatment = t.id_treatment 
                JOIN Terapis tr ON db.id_terapis = tr.id_terapis 
                JOIN Status_Booking sb ON b.id_status = sb.id_status 
                ORDER BY b.tanggal_waktu_booking DESC";

        $query = mysqli_query($conn, $sql);

        if (!$query) {
            echo "<p style='color:red;'>Error query: " . mysqli_error($conn) . "</p>";
        } elseif (mysqli_num_rows($query) == 0) {
            echo "<div style='padding:40px; text-align:center; background:white; border-radius:10px;'>Tidak ada antrean saat ini.</div>";
        } else {
            echo "<table class='tabel-booking'>
                    <tr> 
                        <th class='col-id'>No.</th>
                        <th class='col-waktu'>Waktu</th>
                        <th>Nama Klien</th>
                        <th>Treatment</th>
                        <th>Terapis</th>
                        <th class='col-status'>Status</th>
                        <th class='col-aksi'>Aksi</th>
                    </tr>";
            
            $no = 1;
            while($data = mysqli_fetch_array($query)){
                $dt = new DateTime($data['tanggal_waktu_booking']);
                $tgl = $dt->format('d/m/Y');
                $jam = $dt->format('H:i');

                if ($data['nama_status'] == 'Selesai') {
                    $badge = "<span class='badge' style='background:#e8f5e9; color:#2e7d32; border:1px solid #c8e6c9;'>✔ SELESAI</span>";
                    $aksi = "<span style='color:#999; font-size:12px; font-style:italic;'>Selesai</span>"; 
                } else {
                    $badge = "<span class='badge' style='background:#fff3e0; color:#ef6c00; border:1px solid #ffe0b2;'>⏳ MENUNGGU</span>";
                    $aksi = "<a href='kasir.php?id_booking=".$data['id_booking']."' class='btn-kasir'>Proses Kasir</a>";
                }
                
                echo "<tr>
                        <td><strong>".$no."</strong></td> <td>".$tgl."<br><small style='color:#666;'>".$jam."</small></td>
                        <td>".$data['nama_klien']."</td>
                        <td>".$data['nama_treatment']."</td>
                        <td>".$data['nama_terapis']."</td>
                        <td style='text-align:center;'>".$badge."</td>
                        <td style='text-align:center;'>".$aksi."</td>
                      </tr>";
            $no++;
            }
            echo "</table>";
        }
        ?>
    </div>
</body>
</html>