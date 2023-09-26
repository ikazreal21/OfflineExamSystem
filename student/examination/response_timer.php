<?php 
session_start();


require_once "../../dbconnect.php";


$from_time1 = date("Y-m-d H:i:s");
$to_time1 = $_SESSION['end_time'];

$timefirst=strtotime($from_time1);
$timesecond=strtotime($to_time1);


$diffrenceinseconds = $timesecond - $timefirst;

echo gmdate("H:i:s", $diffrenceinseconds)


 ?>