<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['submit'])) {
        
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            require 'conn.php'; 

           
            $username = htmlspecialchars($_POST['username']);

          
            $sql = "INSERT INTO users (username) VALUES (:username)";
            $stmt = $conn->prepare($sql);

           
            $stmt->bindParam(':username', $username);

            if ($stmt->execute()) {
            
                echo '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
                echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
                echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
                echo '<script type="text/javascript">        
                    $(document).ready(function(){
                        swal({
                            title: "Success!",
                            text: "User added successfully",
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
              
                $error_message = "Error adding user.";
            }
        } else {
           
            $error_message = "Username cannot be empty.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Add User</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
