<?php
require 'conn.php';

// Fetch products from the database to populate the dropdown
$query = "SELECT * FROM products";
$stmt = $conn->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction_id = $_POST['transaction_id'];
    $transaction_date = $_POST['transaction_date'];
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];

    $insertQuery = "INSERT INTO receipts (transaction_id, transaction_date, product_id, price, total_price, payment_method) 
                    VALUES (:transaction_id, :transaction_date, :product_id, :price, :total_price, :payment_method)";

    $stmt = $conn->prepare($insertQuery);

    $stmt->bindParam(':transaction_id', $transaction_id);
    $stmt->bindParam(':transaction_date', $transaction_date);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':total_price', $total_price);
    $stmt->bindParam(':payment_method', $payment_method);

    try {
        if ($stmt->execute()) {
            echo '
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                <script type="text/javascript">        
                    $(document).ready(function(){
                        swal({
                            title: "Success!",
                            text: "Successfully added customer",
                            type: "success",
                            timer: 2500,
                            showConfirmButton: false
                        }, function(){
                            window.location.href = "index.php";
                        });
                    });                    
                </script>
            ';
        } else {
            $message = 'Failed to add new Queue';
        }
    } catch (PDOException $e) {
        echo 'Fail! I Repeat Fail!' . $e->getMessage();
    }
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Receipt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Add Receipt</h2>
        <form action="add_receipt.php" method="POST">
            <div class="mb-3">
                <label for="transaction_id" class="form-label">Transaction ID</label>
                <input type="text" class="form-control" id="transaction_id" name="transaction_id" required>
            </div>
            <div class="mb-3">
                <label for="transaction_date" class="form-label">Transaction Date</label>
                <input type="datetime-local" class="form-control" id="transaction_date" name="transaction_date" required>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Select Product</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="total_price" class="form-label">Total Price</label>
                <input type="number" step="0.01" class="form-control" id="total_price" name="total_price" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <input type="text" class="form-control" id="payment_method" name="payment_method" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Receipt</button>
        </form>
    </div>
</body>
</html>
