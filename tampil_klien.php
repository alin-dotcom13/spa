<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Klien & Membership</title>
    <style>
        /* Desain sama dengan halaman lain agar konsisten */
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #fffafb; display: flex; min-height: 100vh; }
        .main { flex: 1; padding: 40px; box-sizing: border-box; }
        h2 { color: #d81b60; border-bottom: 3px solid #f8bbd0; padding-bottom: 10px; margin-top: 0; font-size: 28px; }
        
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(216, 27, 96, 0.08); border-top: 5px solid #f48fb1; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #fce4ec; color: #d81b60; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #f8bbd0; color: #333; }
        
        /* Desain Badge Membership */
        .badge { padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 13px; display: inline-block; }
        .badge-silver { background: #f5f5f5; color: #757575; border: 1px solid #e0e0e0; }
        .badge-gold { background: #fff8e1; color: #f57f17; border: 1px solid #ffe082; }
        .badge-platinum { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
        
        .btn-tambah { background-color: #f06292; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; margin-bottom: 20px; }
        .btn-tambah:hover { background-color: #e91e63; }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main">
        <h2>Daftar Klien & Status Membership</h2>
        <a href="tambah_klien.php" class="btn-tambah">+ Tambah Klien Baru</a>

        <div class="card">
            <table>
                <tr>
                    <th>ID Klien</th>
                    <th>Nama Klien</th>
                    <th>Total Belanja</th>
                    <th>Status Membership</th>
                </tr>
                
                <?php
                // Query sakti untuk menggabungkan tabel Klien, Booking, dan Invoice
                $query = mysqli_query($conn, "
                    SELECT k.id_klien, k.nama_klien, 
                           COALESCE(SUM(i.grand_total), 0) as total_belanja 
                    FROM Klien k
                    LEFT JOIN Booking b ON k.id_klien = b.id_klien
                    LEFT JOIN Invoice_Spa i ON b.id_booking = i.id_booking
                    GROUP BY k.id_klien
                    ORDER BY total_belanja DESC
                ");

                while($row = mysqli_fetch_array($query)) {
                    $total = $row['total_belanja'];
                    
                    // Logika Penentuan Tier Membership
                    if ($total > 2000000) {
                        $tier = "<span class='badge badge-platinum'>👑 Platinum</span>";
                    } elseif ($total >= 500000) {
                        $tier = "<span class='badge badge-gold'>⭐ Gold</span>";
                    } else {
                        $tier = "<span class='badge badge-silver'>⚪ Silver</span>";
                    }

                    echo "<tr>
                        <td>#KLN-".$row['id_klien']."</td>
                        <td><strong>".$row['nama_klien']."</strong></td>
                        <td>Rp ".number_format($total, 0, ',', '.')."</td>
                        <td>".$tier."</td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>
</html>