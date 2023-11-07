<?php 
session_start();

// echo '<pre>';
// var_dump($_SESSION);
// echo '<pre>';

if ($_SESSION["usertype"] == "student") {
    $_SESSION["message"] = 'Login Successfully';
    header("location:../student/");
} elseif ($_SESSION["usertype"] == "admin") {
    $_SESSION["message"] = 'Login Successfully';
    header("location:../admin/");
} elseif ($_SESSION["usertype"] == "faculty") {
    $_SESSION["message"] = 'Login Successfully';
    header("location:../faculty/");
} 
else {
    session_destroy();  
    header("location:../login.php");
}
