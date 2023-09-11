<?php 
session_start();

// echo '<pre>';
// var_dump($_SESSION);
// echo '<pre>';

if ($_SESSION["usertype"] == "student") {
    header("location:../student/");
} elseif ($_SESSION["usertype"] == "admin") {
    header("location:../admin/");
} elseif ($_SESSION["usertype"] == "faculty") {
    header("location:../faculty/");
} 
// else {
//     session_destroy();  
//     header("location:../login.php");
// }
