<?php
session_start();
require 'db.php'; // Pastikan file ini berisi koneksi database Anda

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $ticket_type = $_POST['ticket_type'] ?? 'Unknown';
    $price = $_POST['price'] ?? 0;
    $payment_method = $_POST['payment_method'] ?? 'Unknown';

    // Simpan pembelian ke database
    $stmt = $conn->prepare("INSERT INTO purchases (username, event_name, event_price, payment_method) VALUES (:username, :event_name, :event_price, :payment_method)");
    $stmt->execute([
        'username' => $username,
        'event_name' => $ticket_type,
        'event_price' => $price,
        'payment_method' => $payment_method
    ]);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventa - Pembelian Tiket Sukses</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('background.png') no-repeat center center/cover;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .confirmation-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        h1 {
            margin: 20px 0;
            font-size: 32px;
            font-weight: bold;
            color: #27ae60;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #f1f1f1;
        }

        .btn-back {
            background-color: #27ae60;
            padding: 15px 25px;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #2ecc71;
            transform: translateY(-4px);
        }

        footer {
            background: #d3d3d3;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: fixed;
            bottom: 0;
        }

        footer p {
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="confirmation-container">
        <h1>Terima Kasih, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Anda telah berhasil membeli tiket <strong><?php echo htmlspecialchars($ticket_type); ?></strong> dengan harga <strong>Rp <?php echo number_format($price, 0, ',', '.'); ?></strong> menggunakan metode pembayaran <strong><?php echo htmlspecialchars($payment_method); ?></strong>.</p>
        <p>Semoga Anda menikmati acara <strong>Eventa 2025</strong>!</p>
        <a href="eventa.php" class="btn-back">Kembali ke Eventa</a>
    </div>

    <footer>
        <p>&copy; 2025 Eventa. Semua Hak Dilindungi.</p>
    </footer>

</body>

</html>