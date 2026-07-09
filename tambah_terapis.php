<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Terapis</title>
    <link rel="stylesheet" href="style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Tema Warna Pink & Putih - Posisi Tengah (Card Design) */
        body { 
            background-color: #fffafb; 
            font-family: Arial, sans-serif; 
            color: #333333; 
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }
        
        .form-container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
            border-top: 5px solid #f06292; 
            width: 100%;
            max-width: 350px;
            text-align: center; 
        }

        h2 { 
            color: #d81b60; 
            border-bottom: 2px solid #f8bbd0; 
            padding-bottom: 10px; 
            margin-top: 0;
            margin-bottom: 20px;
        }

        input, select { 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #f48fb1; 
            border-radius: 5px; 
            width: 100%; 
            box-sizing: border-box;
            background-color: white;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #d81b60;
            box-shadow: 0 0 5px #f8bbd0;
        }

        button { 
            background-color: #f06292; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 20px; 
            cursor: pointer; 
            font-weight: bold; 
            width: 100%; 
            margin-top: 10px;
        }
        button:hover { 
            background-color: #e91e63; 
        }

        .btn-back {
            display: block;
            margin-top: 15px;
            color: #d81b60;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Tambah Terapis Baru</h2>
        <form method="POST">
            <input type="text" name="nama_terapis" placeholder="Nama Terapis (misal: Sinta)" required>
            <input type="text" name="no_hp" placeholder="No. HP / WhatsApp" required>
            
            <select name="id_spesialisasi" required>
                <option value="">-- Pilih Spesialisasi --</option>
                <?php
                $query_spesialisasi = mysqli_query($conn, "SELECT * FROM Spesialisasi_Terapis ORDER BY nama_spesialisasi ASC");
                while($sp = mysqli_fetch_array($query_spesialisasi)){
                    echo "<option value='".$sp['id_spesialisasi']."'>".$sp['nama_spesialisasi']."</option>";
                }
                ?>
            </select>

            <button type="submit" name="submit">Simpan Terapis</button>
        </form>
        <a href="index.php" class="btn-back">Kembali ke Dashboard</a>
    </div>

    <?php
    if(isset($_POST['submit'])){
        $nama = $_POST['nama_terapis'];
        $hp = $_POST['no_hp'];
        $id_spesialisasi = $_POST['id_spesialisasi'];
        
        // Simpan ke tabel Terapis
        $query_insert = "INSERT INTO Terapis (nama_terapis, no_hp, id_spesialisasi) VALUES ('$nama', '$hp', '$id_spesialisasi')";
        
        if(mysqli_query($conn, $query_insert)){
            echo "<script>alert('Data Terapis berhasil ditambahkan!'); window.location='tambah_terapis.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan: " . mysqli_error($conn) . "');</script>";
        }
    }
    ?>

</body>
</html>