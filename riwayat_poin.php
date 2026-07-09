<?php 
session_start(); 
include 'koneksi.php'; 

if (!isset($_GET['id'])) {
    echo "<script>alert('ID Klien tidak ditemukan!'); window.location='membership.php';</script>";
    exit;
}

$id_klien = $_GET['id'];
$query_klien = mysqli_query($conn, "SELECT nama_klien FROM Klien WHERE id_klien = '$id_klien'");
$data_klien = mysqli_fetch_array($query_klien);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Poin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div style="margin-bottom: 25px;">
            <a href="membership.php" style="color:#ec407a; text-decoration: none; font-size: 14px; font-weight: 600;">← Kembali ke Daftar Membership</a>
            <h2 style="color:#880e4f; margin-top: 15px; border-left: 5px solid#ec407a; padding-left: 15px;">
                Riwayat Poin: <?php echo $data_klien['nama_klien']; ?>
            </h2>
        </div>

        <table>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan Transaksi</th>
                <th>Perubahan Poin</th>
            </tr>
            <?php
            $query_riwayat = mysqli_query($conn, "SELECT * FROM Riwayat_Poin WHERE id_klien = '$id_klien' ORDER BY tanggal DESC");
            
            // Cek apakah ada data di dalam tabel
            if(mysqli_num_rows($query_riwayat) > 0) {
                while($row = mysqli_fetch_array($query_riwayat)) {
                    // Logika warna untuk tambah/kurang poin
                    $warna = ($row['jumlah'] > 0) ? "#2e7d32" : "#c62828"; // Hijau untuk +, Merah untuk -
                    $bg_warna = ($row['jumlah'] > 0) ? "#e8f5e9" : "#ffebee";
                    $tanda = ($row['jumlah'] > 0) ? "+" : "";
                    
                    echo "<tr>
                            <td style='color:#555;'>".date('d M Y, H:i', strtotime($row['tanggal']))."</td>
                            <td style='font-weight: 500;'>".$row['keterangan']."</td>
                            <td>
                                <span style='background: $bg_warna; color: $warna; padding: 6px 12px; border-radius: 5px; font-weight: bold;'>
                                    $tanda ".$row['jumlah']." Poin
                                </span>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr>
                        <td colspan='3' style='text-align: center; padding: 40px; color: #888; font-style: italic;'>
                            Belum ada riwayat transaksi poin untuk klien ini.
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>