<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Riwayat Pemesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Riwayat Pesanan</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['orders'])) {
                        // Display orders in reverse chronological order
                        $orders = $_SESSION['orders'];
                        $reversed_orders = array_reverse($orders);

                        // Use a counter to maintain the correct index for the original array
                        $count = count($orders) - 1;
                        foreach ($reversed_orders as $order) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($order['no_pesanan']) . "</td>";
                            echo "<td>" . htmlspecialchars($order['tanggal']) . "</td>";
                            echo "<td>" . htmlspecialchars($order['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($order['no_hp']) . "</td>";
                            echo "<td>Rp " . number_format($order['total'], 0, ',', '.') . "</td>";
                            echo "<td><a href='detailhalaman3.php?order_id=" . $count . "' class='btn btn-info btn-sm'>Lihat Detail</a></td>";
                            echo "</tr>";
                            $count--;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Belum ada riwayat pesanan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="tugashalaman1.php" class="btn btn-primary mt-3">Pesan Baru</a>
        </div>
    </div>
</div>

</body>
</html>