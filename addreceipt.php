<?php
require 'conn.php';

// Fetch products from the database to populate the dropdown
$query = "SELECT * FROM products";
$stmt = $conn->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM users";
$stmt = $conn->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $valid_user = false;
    foreach ($users as $user) {
        if ($user['user_id'] == $user_id) {
            $valid_user = true;
            break;
        }
    }

    $product_id = $_POST['product_id'];
    $valid_product = false;
    foreach ($products as $product) {
        if ($product['product_id'] == $product_id) {
            $valid_product = true;
            break;
        }
    }

    if ($valid_user && $valid_product) {
        $insertQuery = "INSERT INTO receipts (user_id, product_id, transaction_id, transaction_date, price, total_price, payment_method) 
                        VALUES (:user_id, :product_id, :transaction_id, :transaction_date, :price, :total_price, :payment_method)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':user_id', $_POST['user_id']);
        $stmt->bindParam(':product_id', $_POST['product_id']);
        $stmt->bindParam(':transaction_id', $_POST['transaction_id']);
        $stmt->bindParam(':transaction_date', $_POST['transaction_date']);
        $stmt->bindParam(':price', $_POST['price']);
        $stmt->bindParam(':total_price', $_POST['total_price']);
        $stmt->bindParam(':payment_method', $_POST['payment_method']);

        if ($stmt->execute()) {
            echo '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
            echo '<script type="text/javascript">        
                $(document).ready(function(){
                    swal({
                        title: "Success!",
                        text: "Receipt added successfully",
                        type: "success",
                        timer: 2500,
                        showConfirmButton: false
                    }, function(){
                        window.location.href = "index.php";
                    });
                });                    
            </script>';
            exit();
        } else {
            echo "Error adding receipt.";
        }
    } else {
        echo "Invalid user or product.";
    }
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
        <form action="addreceipt.php" method="POST">
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></option>
                    <?php endforeach; ?>
                </select>
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
                <label for="transaction_id" class="form-label">Transaction ID</label>
                <input type="text" class="form-control" id="transaction_id" name="transaction_id" required>
            </div>
            <div class="mb-3">
                <label for="transaction_date" class="form-label">Transaction Date</label>
                <input type="datetime-local" class="form-control" id="transaction_date" name="transaction_date" required>
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
