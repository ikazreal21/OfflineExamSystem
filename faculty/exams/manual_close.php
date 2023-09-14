<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("UPDATE examcreated set status = :status where exam_id = :id ");

$statement->bindValue(':status', 'close');
$statement->bindValue(':id', $id);
$statement->execute();
header('Location:index.php');


 ?>