<?php
    session_start();
    
    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        include './base.php';
        include '../connection.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users : </h5>
                    <p class="card-text"><?php
                    $sql = "select * from users";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_num_rows($result);
                     echo $row;                   ?></p>
                    <a href="./users.php" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Students : </h5>
                    <p class="card-text"><?php
                    $sql1 = "select * from alumni";
                    $result1 = mysqli_query($conn,$sql1);
                    $row1 = mysqli_num_rows($result1);
                     echo $row1;                   ?></p>
                    <a href="./alumni.php" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }
?>