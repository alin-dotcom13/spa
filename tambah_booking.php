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
    <title>Booking Spa & Treatment</title>
    <link rel="stylesheet" href="style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Tema Warna Pink & Putih - Posisi Tengah (Centered) */
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
        
        /* Desain Kotak Form (Card) */
        .form-container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
            border-top: 5px solid #f06292; 
            width: 100%;
            max-width: 400px;
            text-align: center; 
        }

        h2 { 
            color: #d81b60; 
            border-bottom: 2px solid #f8bbd0; 
            padding-bottom: 10px; 
            margin-top: 0;
            margin-bottom: 20px;
        }

        /* Desain Input dan Dropdown */
        input, select { 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #f48fb1; 
            border-radius: 5px; 
            width: 100%; 
            box-sizing: border-box;
            background-color: white;
            color: #333;
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

        /* Desain link kembali */
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
        <h2>Booking Treatment</h2>
        <form method="POST">
            <select name="id_klien" required>
                <option value="">-- Pilih Klien --</option>
                <?php
                $klien = mysqli_query($conn, "SELECT * FROM Klien ORDER BY nama_klien ASC");
                while($k = mysqli_fetch_array($klien)){
                    echo "<option value='".$k['id_klien']."'>".$k['nama_klien']." (".$k['no_hp'].")</option>";
                }
                ?>
            </select>

            <select name="id_treatment" required>
                <option value="">-- Pilih Treatment --</option>
                <?php
                $treatment = mysqli_query($conn, "SELECT * FROM Treatment ORDER BY nama_treatment ASC");
                while($t = mysqli_fetch_array($treatment)){
                    echo "<option value='".$t['id_treatment']."'>".$t['nama_treatment']." - Rp ".number_format($t['harga'],0,',','.')."</option>";
                }
                ?>
            </select>

            <select name="id_terapis" required>
                <option value="">-- Pilih Terapis --</option>
                <?php
                $terapis = mysqli_query($conn, "SELECT * FROM Terapis ORDER BY nama_terapis ASC");
                while($tr = mysqli_fetch_array($terapis)){
                    echo "<option value='".$tr['id_terapis']."'>".$tr['nama_terapis']."</option>";
                }
                ?>
            </select>

            <input type="datetime-local" name="waktu_booking" required>

            <button type="submit" name="submit">Simpan Booking</button>
        </form>
        
        <a href="tampil_booking.php" class="btn-back">Kembali ke Daftar Antrean</a>
    </div>

    <?php
    if(isset($_POST['submit'])){
        $id_klien = $_POST['id_klien'];
        $id_treatment = $_POST['id_treatment'];
        $id_terapis = $_POST['id_terapis'];
        $waktu_booking = $_POST['waktu_booking'];
        
        // 1. Simpan ke tabel Booking (Asumsi id_status = 1 untuk 'Booking Baru')
        $query_booking = "INSERT INTO Booking (id_klien, tanggal_waktu_booking, id_status) VALUES ('$id_klien', '$waktu_booking', 1)";
        
        if(mysqli_query($conn, $query_booking)){
            // Ambil ID Booking yang baru saja terbuat
            $id_booking_baru = mysqli_insert_id($conn);
            
            // 2. Simpan ke tabel Detail_Booking
            $query_detail = "INSERT INTO Detail_Booking (id_booking, id_treatment, id_terapis) VALUES ('$id_booking_baru', '$id_treatment', '$id_terapis')";
            
            if(mysqli_query($conn, $query_detail)){
                echo "<script>alert('Booking berhasil disimpan!'); window.location='tampil_booking.php';</script>";
            } else {
                echo "<script>alert('Gagal simpan detail: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Gagal simpan booking: " . mysqli_error($conn) . "');</script>";
        }
    }
    ?>

</body>
</html>