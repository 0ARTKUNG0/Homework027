<?php
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'], $_POST['receipt_id'])) {
    $receiptId = $_POST['receipt_id'];
    $transactionId = $_POST['transaction_id'];
    $transactionDate = $_POST['transaction_date'];
    $price = $_POST['price'];
    $totalPrice = $_POST['total_price'];
    $paymentMethod = $_POST['payment_method'];

    $updateQuery = "UPDATE Receipts SET
                    transaction_id = :transaction_id,
                    transaction_date = :transaction_date,
                    price = :price,
                    total_price = :total_price,
                    payment_method = :payment_method
                    WHERE receipt_id = :receipt_id";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bindParam(':transaction_id', $transactionId);
    $stmt->bindParam(':transaction_date', $transactionDate);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':total_price', $totalPrice);
    $stmt->bindParam(':payment_method', $paymentMethod);
    $stmt->bindParam(':receipt_id', $receiptId);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error updating record.";
    }
}

// Redirect if no receipt ID is provided
if (!isset($_GET['receipt_id'])) {
    header('Location: index.php');
    exit();
}

$receiptId = $_GET['receipt_id'];
$query = "SELECT * FROM Receipts WHERE receipt_id = :receipt_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':receipt_id', $receiptId);
$stmt->execute();
$receipt = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$receipt) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2>Update Receipt</h2>
        <form action="UpdateReceipt.php" method="post">
            <input type="hidden" name="receipt_id" value="<?= $receipt['receipt_id'] ?>">
            <div class="mb-3">
                <label for="transaction_id" class="form-label">Transaction ID</label>
                <input type="text" class="form-control" id="transaction_id" name="transaction_id" value="<?= $receipt['transaction_id'] ?>" required>
            </div>
            <div class="mb-3">
                 <label for="transaction_date" class="form-label">Transaction Date</label>
                  <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="<?= $receipt['transaction_date'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $receipt['price'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="total_price" class="form-label">Total Price</label>
                <input type="number" step="0.01" class="form-control" id="total_price" name="total_price" value="<?= $receipt['total_price'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <input type="text" class="form-control" id="payment_method" name="payment_method" value="<?= $receipt['payment_method'] ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
