<?php
session_start();
include 'koneksi.php';

// Proses Simpan Data
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $stok = intval($_POST['stok']);
    $min  = intval($_POST['min_stok']);
    $harga = intval($_POST['harga']); 

    $query = mysqli_query($conn, "INSERT INTO Produk_Kecantikan (nama_produk, stok_saat_ini, stok_minimum, harga_satuan, harga_jual) 
                                  VALUES ('$nama', '$stok', '$min', '$harga', '$harga')");

    if ($query) {
        echo "<script>alert('Produk berhasil ditambahkan.'); window.location='tambah_produk.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Produk - Spa & Klinik</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Layout Utama */
        .container-produk { display: flex; gap: 30px; padding: 20px; align-items: flex-start; }
        .form-container, .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-container { flex: 1; }
        .card { flex: 2; }
        
        /* Tabel Modern */
        .table-produk { width: 100%; border-collapse: collapse; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .table-produk th { background-color: #ad1457; color: white; padding: 16px; text-align: left; }
        .table-produk td { padding: 16px; border-bottom: 1px solid #f0f0f0; }
        .table-produk td:nth-child(2), .table-produk td:nth-child(3) { text-align: right; padding-right: 20px; }
        .table-produk th:nth-child(2), .table-produk th:nth-child(3) { text-align: right; padding-right: 20px; }

        /* Label Status */
        .stok-warning { background: #ffebee; color: #c62828; padding: 4px 8px; border-radius: 5px; font-weight: bold; }
        .stok-aman { color: #2e7d32; font-weight: 600; }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main" style="padding: 20px;">
        <h2 class="page-title">Master Manajemen Produk</h2>
        
        <div class="container-produk">
            <div class="form-container">
                <h3>Tambah Produk Baru</h3>
                <form method="POST">
                    <div style="margin-bottom: 15px;">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" required style="width:100%; padding:10px; border-radius:5px; border:1px solid #ddd;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                        <div><label>Harga (Rp)</label><input type="number" name="harga" required style="width:100%; padding:10px; border-radius:5px; border:1px solid #ddd;"></div>
                        <div><label>Stok</label><input type="number" name="stok" required style="width:100%; padding:10px; border-radius:5px; border:1px solid #ddd;"></div>
                        <div><label>Min Stok</label><input type="number" name="min_stok" required style="width:100%; padding:10px; border-radius:5px; border:1px solid #ddd;"></div>
                    </div>
                    <button type="submit" name="simpan" style="width:100%; padding:12px; background:#ad1457; color:white; border:none; border-radius:5px; cursor:pointer;">Simpan</button>
                </form>
            </div>

            <div class="card">
                <h3>Daftar Produk di Klinik</h3>
                <table class="table-produk">
                    <thead><tr><th>Nama Produk</th><th>Harga</th><th>Stok</th></tr></thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM Produk_Kecantikan ORDER BY id_produk DESC");
                        while ($row = mysqli_fetch_array($query)) {
                            $status = ($row['stok_saat_ini'] <= $row['stok_minimum']) 
                                      ? "<span class='stok-warning'>".$row['stok_saat_ini']." (Menipis)</span>" 
                                      : "<span class='stok-aman'>".$row['stok_saat_ini']."</span>";
                            
                            echo "<tr>
                                    <td><strong>".$row['nama_produk']."</strong></td>
                                    <td>Rp ".number_format($row['harga_jual'], 0, ',', '.')."</td>
                                    <td>".$status."</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>