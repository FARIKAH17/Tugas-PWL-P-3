<?php
session_start(); // Add this at the top of the file

// --- Daftar sepatu pria ---
$list = [
    "Nike Air Max"      => 1000000,
    "ADIDAS Samba"      => 2500000,
    "NEW BALANCE MR530" => 3000000,
    "VANS Old Skool"    => 4000000,
    "Nike Air Jordan"   => 5000000,
];

// --- Variabel error ---
$errors = [];
$menu_dipilih = [];
$qtys = [];

// --- Proses form jika dikirim ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama']);
    $no_hp = trim($_POST['no_hp']);
    $alamat = trim($_POST['alamat']);
    $menu_dipilih = $_POST['menu'] ?? [];
    $qtys = $_POST['qty'] ?? [];

    // Validasi sederhana
    if (empty($nama)) {
        $errors[] = "Nama wajib diisi.";
    }
    if (!preg_match('/^[0-9]{10,15}$/', $no_hp)) {
        $errors[] = "No HP harus 10–15 digit angka.";
    }
    if (empty($alamat)) {
        $errors[] = "Alamat wajib diisi.";
    }
    if (empty($menu_dipilih)) {
        $errors[] = "Minimal pilih satu sepatu.";
    }

    // Jika tidak ada error
    if (empty($errors)) {
        $no_pesanan = "ORDER-" . str_pad(rand(3, 999), 3, "0", STR_PAD_LEFT);
        $total = 0;
        $detail_items = [];

        foreach ($menu_dipilih as $item) {
            $jumlah = max(1, (int)$qtys[$item]);
            $harga = $list[$item];
            $subtotal = $harga * $jumlah;
            $total += $subtotal;
            $detail_items[] = [$item, $harga, $jumlah, $subtotal];
        }

        // Simpan pesanan ke session
        $new_order = [
            'no_pesanan' => $no_pesanan,
            'nama' => $nama,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
            'total' => $total,
            'items' => $detail_items,
            'tanggal' => date('d/m/Y H:i')
        ];

        // Tambahkan pesanan baru ke array session
        if (!isset($_SESSION['orders'])) {
            $_SESSION['orders'] = [];
        }
        $_SESSION['orders'][] = $new_order;
        
        // Redirect to the success page to avoid form resubmission
        header("Location: pesanhalaman2.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tugas Pemrograman Web Lanjut - Form Pemesanan Sepatu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Form Pemesanan Sepatu</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach($errors as $e) echo "<li>$e</li>"; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Nama Pemesan</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Pengiriman</label>
                        <textarea name="alamat" class="form-control" required><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                    </div>
                    <label>Pilih Sepatu</label><br>
                    <?php foreach ($list as $m => $harga): ?>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="menu[]" value="<?= htmlspecialchars($m) ?>" id="<?= htmlspecialchars($m) ?>" class="form-check-input"
                            <?= in_array($m, $menu_dipilih ?? []) ? 'checked' : '' ?>>
                            <label for="<?= htmlspecialchars($m) ?>" class="form-check-label">
                                <?= htmlspecialchars($m) ?> - Rp <?= number_format($harga,0,',','.') ?>
                            </label>
                            <input type="number" min="1" name="qty[<?= htmlspecialchars($m) ?>]" value="<?= htmlspecialchars($qtys[$m] ?? 1) ?>"
                                class="form-control d-inline-block ml-3" style="width:70px">
                        </div>
                    <?php endforeach; ?>
                    <button class="btn btn-primary mt-3" type="submit">Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>