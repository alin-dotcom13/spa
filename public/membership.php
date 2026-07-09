<?php 
session_start(); include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Status Membership</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <h2 class="page-title">Status Membership Klien</h2>
        </h2>

        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama klien..." 
               style="width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid#ddd; border-radius: 8px;">
        
        <table id="membershipTable">
            <tr>
                <th>Nama Klien</th>
                <th>Total Poin</th>
                <th>Level</th>
                <th>Progress</th> <th>Aksi</th>
            </tr>
            <?php
            $query = mysqli_query($conn, "SELECT id_klien, nama_klien, saldo_poin FROM Klien ORDER BY saldo_poin DESC");
            while($d = mysqli_fetch_array($query)) {
                $poin = $d['saldo_poin'];
                // Logika Level & Progress
                if ($poin >= 1000) { $level = "Platinum"; $class = "badge-platinum"; $target = 1000; $persen = 100; }
                elseif ($poin >= 500) { $level = "Gold"; $class = "badge-gold"; $target = 1000; $persen = ($poin/1000)*100; }
                else { $level = "Silver"; $class = "badge-silver"; $target = 500; $persen = ($poin/500)*100; }

                echo "<tr>
                        <td style='font-weight: 700; color: #333;'>".$d['nama_klien']."</td>
                        <td style='color: #666;'>⭐ ".$poin." Poin</td>
                        <td><span class='$class' style='padding: 6px 15px; border-radius: 50px;'>$level</span></td>
                        <td style='width: 150px;'>
                            <div style='background:#eee; height:8px; border-radius:4px; width:100%;'>
                                <div style='background:#ec407a; height:8px; border-radius:4px; width:".$persen."%;'></div>
                            </div>
                        </td>
                        <td>
                            <a href='riwayat_poin.php?id=".$d['id_klien']."' style='background:#fce4ec; color:#880e4f; padding:6px 12px; border-radius:5px; text-decoration:none; font-size:12px;'>Lihat</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>

    <script>
    function filterTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("membershipTable");
        let tr = table.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                let txtValue = td.textContent || td.innerText;
                tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }
    </script>
</body>
</html>