<?php
    session_start();

    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        unset($_SESSION['admin_name']);
        header("location: ../index.php");    
    }
?>