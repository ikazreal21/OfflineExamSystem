<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$id = $_GET['id'] ?? null;


if (!$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM examcreated WHERE exam_id = :exam_id");
$statement->bindValue(':exam_id', $id);
$statement->execute();
header('Location:index.php');

 ?>