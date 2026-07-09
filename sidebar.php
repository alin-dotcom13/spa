<style>
    @keyframes luxuryPulse {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .sidebar {
        /* Warna Rose Gold Glam */
        background: linear-gradient(135deg, #880e4f, #ec407a, #fce4ec, #880e4f) !important;
        background-size: 300% 300% !important;
        animation: luxuryPulse 10s ease infinite !important;
        width: 250px;
        height: 100vh;
        padding: 20px;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    .sidebar h2 { 
        color: #ffffff; 
        border-bottom: 2px solid rgba(255,255,255,0.3); 
        padding-bottom: 10px; 
    }

    .sidebar a { 
        display: block; 
        color: #fff; 
        padding: 12px 15px; 
        margin-bottom: 5px; 
        text-decoration: none; 
        font-weight: 500;
        transition: 0.3s;
        border-radius: 5px;
    }

    .sidebar a:hover { 
        background: rgba(255, 255, 255, 0.2) !important; 
    }

    /* Penanda menu yang sedang dibuka */
    .active {
        background: rgba(255, 255, 255, 0.3) !important;
        border-left: 5px solid #ffffff;
        font-weight: bold !important;
    }
</style>

<?php $page = basename($_SERVER['PHP_SELF']); ?>
<nav class="sidebar">
    <h2 style="font-size: 22px; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 10px;">Menu Utama</h2>
    
    <?php $file = basename($_SERVER['SCRIPT_NAME']); ?>
    
    <a href="index.php" class="<?php if($file == 'index.php') echo 'menu-active'; ?>">Dashboard</a>
    <a href="tambah_klien.php" class="<?php if($file == 'tambah_klien.php') echo 'menu-active'; ?>">Tambah Klien</a>
    <a href="membership.php" class="<?php if($file == 'membership.php') echo 'menu-active'; ?>">Status Membership</a>
    <a href="tampil_booking.php" class="<?php if($file == 'tampil_booking.php') echo 'menu-active'; ?>">Antrean & Kasir</a>
    <a href="laporan.php" class="<?php if($file == 'laporan.php') echo 'menu-active'; ?>">Laporan Analitik</a>
    <a href="jadwal_terapis.php" class="<?php if($file == 'jadwal_terapis.php') echo 'menu-active'; ?>">Jadwal Terapis</a>
    <a href="tambah_produk.php" class="<?php if($file == 'tambah_produk.php') echo 'menu-active'; ?>">Tambah Produk</a>
    
    <div style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">
        <a href="logout.php">Logout</a>
    </div>
</nav>