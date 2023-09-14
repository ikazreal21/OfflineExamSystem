<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$faculty = $_GET['faculty'] ?? null;
$id = $_GET['id'] ?? null;


if (!$faculty && !$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM prof_subjects WHERE prof_id = :faculty and subject_id = :subject_id");
$statement->bindValue(':faculty', $faculty);
$statement->bindValue(':subject_id', $id);
$statement->execute();


$statement = $pdo->prepare("DELETE FROM examcreated WHERE prof_id = :faculty and subject_id = :subject_id");
$statement->bindValue(':faculty', $faculty);
$statement->bindValue(':subject_id', $id);
$statement->execute();
header('Location:edit_prof.php?id='.$id);

 ?>