<?php
if (isset($_POST['submit'])) {
    require 'conn.php';

    $sql = "UPDATE Receipts 
            SET transaction_id = :transaction_id,
                transaction_date = :transaction_date,
                price = :price,
                total_price = :total_price,
                payment_method = :payment_method
            WHERE receipt_id = :receipt_id";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':transaction_id', $_POST['transaction_id']);
    $stmt->bindParam(':transaction_date', $_POST['transaction_date']);
    $stmt->bindParam(':price', $_POST['price']);
    $stmt->bindParam(':total_price', $_POST['total_price']);
    $stmt->bindParam(':payment_method', $_POST['payment_method']);
    $stmt->bindParam(':receipt_id', $_POST['receipt_id']);


    if ($stmt->execute()) {
        echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
        <script type="text/javascript">
            $(document).ready(function(){
                swal({
                    title: "Success!",
                    text: "Successfully updated receipt information",
                    type: "success",
                    timer: 2500,
                    showConfirmButton: false
                }, function(){
                    window.location.href = "index.php";
                });
            });
        </script>';
    } else {
        echo "Error updating record.";
    }

    $conn = null;
}
?>
