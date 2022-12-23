<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("location: ./index.php");
    }else{
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        header("location: ./index.php");
    }
?>