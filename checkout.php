<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) === 0) {
    echo "<p>Keranjang belanja Anda kosong.</p>";
    exit;
}

// Tangani metode pembayaran, nomor rekening, dan opsi kredit
if (isset($_POST['metode_pembayaran']) && isset($_POST['nomor_rekening'])) {
    $metodePembayaran = $_POST['metode_pembayaran'];
    $nomorRekening = $_POST['nomor_rekening'];
    $_SESSION['metode_pembayaran'] = $metodePembayaran;
    $_SESSION['nomor_rekening'] = $nomorRekening;
} else {
    echo "<p>Anda belum memilih metode pembayaran atau memasukkan nomor rekening.</p>";
    exit;
}

// Salin isi keranjang ke variabel lain untuk menampilkan kuitansi
$keranjang = $_SESSION['keranjang'];

// Kosongkan keranjang belanja
unset($_SESSION['keranjang']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembelian</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h1>Kuitansi Pembelian</h1>
        </header>
        <main>
            <section class="card p-4">
                <h2 class="card-title text-center">Terima Kasih atas Pembelian Anda!</h2>
                <p>Berikut adalah rincian pembelian Anda:</p>
                <?php
                $total = 0;
                foreach ($keranjang as $produk) {
                    echo "<div class='item border-bottom mb-3 pb-2'>";
                    echo "<p>";
                    echo "Nama: " . htmlspecialchars($produk['nama']) . "<br>";
                    echo "Harga: Rp." . number_format($produk['harga'], 0, ',', '.') . "<br>";
                    
                    if ($produk['kredit'] > 0) {
                        echo "Opsi Kredit: " . $produk['kredit'] . " Bulan";
                    } else {
                        echo "Opsi Kredit: Tanpa Kredit";
                    }
                
                    echo "</p>";
                    echo "</div>";
                    $total += $produk['harga'];
                }
                
                ?>
                <p class="total font-weight-bold">Total Harga: Rp.<?php echo number_format($total, 0, ',', '.'); ?></p>
                <p class="payment-method">Metode Pembayaran: <?php echo ucfirst(htmlspecialchars($_SESSION['metode_pembayaran'])); ?></p>
                <p class="account-number">Nomor Rekening: <?php echo htmlspecialchars($_SESSION['nomor_rekening']); ?></p>

            </section>
            <div class="text-center mt-4">
                <a href="produk.php" class="btn btn-primary">Kembali ke Produk</a>
                <a href="logout.php" class="btn btn-danger">Keluar</a>
            </div>
        </main>
        <footer class="text-center mt-4">
            <p>&copy; 2024 Dwi Agung Septian</p>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
