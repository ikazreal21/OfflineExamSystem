<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$id = $_GET['id'] ?? null;
$rnd_id = $_GET['rnd_id'] ?? null;


if (!$id) {
    header('Location: index.php');
    exit;
}


$statement = $pdo->prepare("DELETE FROM section WHERE section_id = :section_id");
$statement->bindValue(':section_id', $id);
$statement->execute();

$statement = $pdo->prepare('DELETE FROM enrolled_student WHERE section_id  = :section_id');
$statement->bindValue(':section_id', $id);
$statement->execute();

header('Location:section.php?id='.$rnd_id);

 ?>