<?php
// Redirect if receipt_id is not provided or not numeric
if (!isset($_GET['receipt_id']) || !is_numeric($_GET['receipt_id'])) {
    header('Location: index.php');
    exit();
}

require 'conn.php';

$receipt_id = $_GET['receipt_id'];
$sql = "DELETE FROM receipts WHERE receipt_id = :receipt_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':receipt_id', $receipt_id);

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
                    text: "Successfully deleted receipt",
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
        $message = 'Failed to delete receipt';
    }
} catch (PDOException $e) {
    echo 'Failed! ' . $e->getMessage();
}

$conn = null;
?>
