<?php
session_start();

$order = null;
if (isset($_GET['order_id']) && isset($_SESSION['orders'][$_GET['order_id']])) {
    $order = $_SESSION['orders'][$_GET['order_id']];
}

if (!$order) {
    // Redirect to history page if order is not found
    header("Location: pesanhalaman2.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .modal-body-custom {
            font-family: monospace;
            white-space: pre-wrap;
        }
        .receipt-box, .modal-body-custom {
            font-family: monospace;
            white-space: pre; /* Use pre to preserve all whitespace */
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Detail Pesanan</h4>
        </div>
        <div class="card-body">
            <div class="receipt-box">
                <?php
                echo "=== DETAIL PESANAN ===\n\n";
                echo "No Pesanan : " . htmlspecialchars($order['no_pesanan']) . "\n";
                echo "Tanggal    : " . htmlspecialchars($order['tanggal']) . "\n";
                echo "Nama       : " . htmlspecialchars($order['nama']) . "\n";
                echo "No HP      : " . htmlspecialchars($order['no_hp']) . "\n";
                echo "Alamat     : " . htmlspecialchars($order['alamat']) . "\n\n";
                echo "PESANAN:\n";
                
                // Calculate padding to align the subtotal
                $longest_item = 0;
                foreach ($order['items'] as $item) {
                    $longest_item = max($longest_item, strlen($item[0]));
                }
                
                foreach ($order['items'] as $item) {
                    $item_name = htmlspecialchars($item[0]);
                    $item_price = number_format($item[1], 0, ',', '.');
                    $quantity = htmlspecialchars($item[2]);
                    $subtotal = number_format($item[3], 0, ',', '.');

                    echo "- {$item_name}\n";
                    echo "  {$quantity} x Rp " . str_pad($item_price, 9, ' ', STR_PAD_LEFT) . " = Rp " . str_pad($subtotal, 9, ' ', STR_PAD_LEFT) . "\n";
                }
                
                echo str_repeat('-', 40) . "\n"; // Longer line for better look
                echo "TOTAL: Rp " . number_format($order['total'], 0, ',', '.') . "\n";
                ?>
            </div>

            <div class="mt-4 btn-group-custom">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#receiptModal">Download Struk</button>
                <a href="pesanhalaman2.php" class="btn btn-info">Lihat Riwayat Pesanan</a>
                <a href="tugashalaman1.php" class="btn btn-primary">Pesan Lagi</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="receiptModalLabel">Detail Pesanan - <?= htmlspecialchars($order['no_pesanan']) ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-body-custom">
        <?php
          echo "=== DETAIL PESANAN ===\n\n";
          echo "No Pesanan : " . htmlspecialchars($order['no_pesanan']) . "\n";
          echo "Tanggal    : " . htmlspecialchars($order['tanggal']) . "\n";
          echo "Nama       : " . htmlspecialchars($order['nama']) . "\n";
          echo "No HP      : " . htmlspecialchars($order['no_hp']) . "\n";
          echo "Alamat     : " . htmlspecialchars($order['alamat']) . "\n\n";
          echo "PESANAN:\n";

          foreach ($order['items'] as $item) {
              $item_name = htmlspecialchars($item[0]);
              $item_price = number_format($item[1], 0, ',', '.');
              $quantity = htmlspecialchars($item[2]);
              $subtotal = number_format($item[3], 0, ',', '.');
              
              echo "- {$item_name}\n";
              echo "  {$quantity} x Rp " . str_pad($item_price, 9, ' ', STR_PAD_LEFT) . " = Rp " . str_pad($subtotal, 9, ' ', STR_PAD_LEFT) . "\n";
          }
          
          echo str_repeat('-', 40) . "\n";
          echo "TOTAL Rp " . number_format($order['total'], 0, ',', '.') . "\n";
        ?>
      </div>
      <div class="modal-footer d-flex justify-content-end">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>