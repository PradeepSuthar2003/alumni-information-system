<?php 
    session_start();
    
    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        
        include '../connection.php';
        
        $id = $_GET['id'];

        $sql = "update alumni set is_approved = 1 where u_id = {$id}";
        $result = mysqli_query($conn,$sql);

        if($result){
            header("location: ./alumni.php");
        }
    }
?>