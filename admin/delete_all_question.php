<?php 

require_once "../dbconnect.php";
require_once "../others/function.php";


$statement = $pdo->prepare("DELETE FROM examcreated");
$statement->execute();

$statement = $pdo->prepare("DELETE FROM identification");
$statement->execute();

$statement = $pdo->prepare("DELETE FROM matchingtype");
$statement->execute();

$statement = $pdo->prepare("DELETE FROM multiplechoice");
$statement->execute();

$statement = $pdo->prepare("DELETE FROM trueorfalse");
$statement->execute();

header('Location:index.php');

 ?>