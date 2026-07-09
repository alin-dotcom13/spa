<?php
session_start();
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Terapis - Spa & Klinik</title>
  <link rel="stylesheet" href="style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main">
       <h2 class="page-title">Jadwal Terapis</h2>
        
        <div class="card">
            <table style="width: 95%; margin-left: 20px;">
                <thead>
                <tr>
                    <th style="padding: 15px; border-bottom: 2px solid#eee;">Nama Terapis</th>
                    <th style="padding: 15px; border-bottom: 2px solid#eee;">Status</th>
                    <th style="padding: 15px; border-bottom: 2px solid#eee;">Booking Hari Ini</th>
                </tr>
                <?php
            
                $query = mysqli_query($conn, "
                    SELECT t.id_terapis, t.nama_terapis,
                           (SELECT COUNT(*) FROM Detail_Booking db
                            JOIN Booking b ON db.id_booking = b.id_booking
                            WHERE db.id_terapis = t.id_terapis AND DATE(b.tanggal_waktu_booking) = CURDATE()
                           ) as jml_booking_hari_ini
                    FROM Terapis t
                ");

                while($row = mysqli_fetch_array($query)) {
                    $jml_booking = $row['jml_booking_hari_ini'];
                    
                    if ($jml_booking > 0) {
                        $status = "<span class='status-sibuk'>Ada Jadwal</span>";
                        $keterangan = "<strong>$jml_booking</strong> Sesi Treatment";
                    } else {
                        $status = "<span class='status-tersedia'>Tersedia (Free)</span>";
                        $keterangan = "<span style='color:#aaa;'>Belum ada jadwal</span>";
                    }

                    echo "<tr>
                        <td><strong>".$row['nama_terapis']."</strong></td>
                        <td>".$status."</td>
                        <td>".$keterangan."</td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>
</html>