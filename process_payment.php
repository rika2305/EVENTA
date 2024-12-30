<?php
// Mulai sesi untuk mendapatkan data pengguna
session_start();

// Periksa apakah sesi sudah ada
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Ambil data dari formulir pembayaran
$ticket_type = $_POST['ticket_type'];
$price = $_POST['price'];
$payment_method = $_POST['payment_method'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation - Eventa</title>
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

        .payment-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        h1 {
            margin: 10px 0;
            font-size: 28px;
        }

        h2 {
            font-size: 24px;
            margin-top: 20px;
            color: #27ae60;
        }

        .confirmation-message {
            background-color: #2ecc71;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 18px;
        }

        .detail {
            margin-top: 10px;
            font-size: 18px;
            line-height: 1.5;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #ccc;
        }

        .btn-back {
            background-color: #3498db;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
        }

        .btn-back:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <div class="payment-container">
        <div class="logo">
            <img src="2.png" alt="Eventa Logo">
        </div>
        <h1>Payment Confirmation</h1>

        <h2>Thank you for your purchase, <?php echo $_SESSION['username']; ?>!</h2>

        <div class="confirmation-message">
            <p>You selected:</p>
            <p><strong><?php echo $ticket_type; ?></strong> for <strong><?php echo number_format($price, 0, ',', '.'); ?> IDR</strong>.</p>
            <p>Payment method: <strong><?php echo $payment_method; ?></strong></p>
            <p>Your payment has been successfully processed using <strong><?php echo $payment_method; ?></strong>.</p>
        </div>

        <div class="detail">
            <p>If you have any questions, feel free to contact us.</p>
            <a href="eventa.php" class="btn-back">Back to Home</a>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Eventa. All Rights Reserved.</p>
    </div>

</body>

</html>