<?php
    session_start();

    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        include '../connection.php';
        if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "delete from users where u_id = {$id};";
        $result = mysqli_query($conn,$sql);

        if($result){
            $sql2 = "delete from alumni where u_id = {$id}";
            $result2 = mysqli_query($conn,$sql2);

            if(isset($_SESSION['user_id'])){
                if(($_SESSION['user_id']) == $id){
                    unset($_SESSION['user_id']);
                }
            }
            header("location: ./users.php");
        }
        }else{
            header("location: ./users.php");
        }
    }
?>