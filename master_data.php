<h3>Master Data Klinik</h3>
<div style="display: flex; gap: 20px;">
    <div>
        <h4>Stok Produk</h4>
        <?php $stok = mysqli_query($conn, "SELECT * FROM Produk_Kecantikan JOIN Stok_Produk ON Produk_Kecantikan.id_produk = Stok_Produk.id_produk"); ?>
        </div>

    <div>
        <h4>Spesialisasi Terapis</h4>
        <?php $spec = mysqli_query($conn, "SELECT * FROM Spesialisasi_Terapis"); ?>
        </div>
</div>