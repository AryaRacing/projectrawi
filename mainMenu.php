<?php
session_start();

if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php'); // Mengarahkan ke halaman login setelah logout
    exit; // Menghentikan eksekusi skrip
}
function getTotalCount($conn, $table) {
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['total'];
    } else {
        return 0;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <?php
        include "./adminHeader.php";
        include "./sidebar.php";
    ?>
    
    <div class="container">
        <div class="row">
        <div class="container">
    <div class="row">
        <div class="col">
            <a href="?logout" class="btn btn-danger float-right">Logout</a>
        </div>
    </div>
</div>

        </div>
    </div>
    
    <!-- Rest of your content -->
    <div id="main-content" class="container allContent-section py-4">
        <div class="row">
            <div class="col-sm-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <i class="fa fa-users mb-2" style="font-size: 80px;"></i>
                        <h4>Total customer</h4>
                        <h5><?php echo getTotalCount($conn, 'customer'); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <i class="fa fa-th-large mb-2" style="font-size: 70px;"></i>
                        <h4>Total Categories</h4>
                        <h5><?php echo getTotalCount($conn, 'category'); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <i class="fa fa-th mb-2" style="font-size: 70px;"></i>
                        <h4>Total Products</h4>
                        <h5><?php echo getTotalCount($conn, 'product'); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <i class="fa fa-list mb-2" style="font-size: 70px;"></i>
                        <h4>Total Orders</h4>
                        <h5><?php echo getTotalCount($conn, 'orders'); ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        if (isset($_GET['category']) && $_GET['category'] == "success") {
            echo '<script> alert("Category Successfully Added")</script>';
        } else if (isset($_GET['category']) && $_GET['category'] == "error") {
            echo '<script> alert("Adding Unsuccessful")</script>';
        }
        if (isset($_GET['size']) && $_GET['size'] == "success") {
            echo '<script> alert("Size Successfully Added")</script>';
        } else if (isset($_GET['size']) && $_GET['size'] == "error") {
            echo '<script> alert("Adding Unsuccessful")</script>';
        }
        if (isset($_GET['variation']) && $_GET['variation'] == "success") {
            echo '<script> alert("Variation Successfully Added")</script>';
        } else if (isset($_GET['variation']) && $_GET['variation'] == "error") {
            echo '<script> alert("Adding Unsuccessful")</script>';
        }
    ?>

    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>