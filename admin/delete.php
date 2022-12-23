<?php
    session_start();
    
    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        include '../connection.php';
        if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "delete from alumni where u_id = {$id}";
        $result = mysqli_query($conn,$sql);

        if($result){
            echo "<script>alert('Data deleted');</script>";
            header("location: ./alumni.php");
        }
        }else{
            header("location: ./alumni.php");
        }
    }
?>