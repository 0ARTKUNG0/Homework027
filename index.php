<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Receipts Steam</title>
    <style>

        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 1rem;
            margin-left: 0.25rem;
            border: none;
            border-radius: 0.25rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            transition: background-color 0.15s ease-in-out;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #0056b3;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: #0056b3;
            color: white;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background-color: #6c757d;
            color: white;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right;
        }
    </style>
</head>



<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="steam.png" width="50px" height="50" alt="Your Image" class="img-fluid mb-3">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <br>
                <a href="addreceipt.php" class="btn btn-info float-end">+ Add Receipt</a>
                <a href="addproduct.php" class="btn btn-success float-end me-2">+ Add Product</a>
                <a href="addusers.php" class="btn btn-success float-end me-2">+ Add Users</a>
                </h3>
                <table id="ReceiptTable" class="display table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Receipt ID</th>
                            <th>Username</th>
                            <th>Product Name</th>
                            <th>Transaction Date</th>
                            <th>Total Price</th>
                            <th>Payment Method</th>
                            <th>Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'conn.php';
                        $query = "SELECT r.receipt_id, u.username, p.product_name, r.transaction_id, r.transaction_date, r.price, r.total_price, r.payment_method, p.products_image
                        FROM receipts r
                        JOIN Users u ON r.user_id = u.user_id
                        JOIN Products p ON r.product_id = p.product_id";              
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        foreach ($result as $row) { ?>
                            <tr>
                                <td><?= $row['receipt_id'] ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['product_name'] ?></td>
                                <td><?= $row['transaction_date'] ?></td>
                                <td><?= $row['total_price'] ?></td>
                                <td><?= $row['payment_method'] ?></td>
                                <td><img src="./picture/<?= $row['products_image']; ?>" width="50px" height="50" alt="image"></td>
                                <td><a href="UpdateReceiptForm.php?receipt_id=<?= $row['receipt_id'] ?>" class="btn btn-warning">Edit</a></td>
                                <td><a href="DeleteReceipt.php?receipt_id=<?= $row['receipt_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this receipt?');">Delete</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#ReceiptTable').DataTable();
        });
    </script>
</body>
</html>
