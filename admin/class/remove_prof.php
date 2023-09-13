<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$faculty = $_GET['faculty'] ?? null;
$id = $_GET['id'] ?? null;


if (!$faculty && !$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM prof_subjects WHERE prof_id = :faculty");
$statement->bindValue(':faculty', $faculty);
$statement->execute();
header('Location:edit_prof.php?id='.$id);

 ?>