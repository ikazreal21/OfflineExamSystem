<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$id = $_GET['id'] ?? null;
$prof_id = $_GET['faculty'] ?? null;


if (!$id && !$prof_id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("INSERT INTO prof_subjects (prof_id, subject_id)
VALUES (:prof_id, :subject_id)");

$statement->bindValue(':prof_id', $prof_id);
$statement->bindValue(':subject_id', $id);
$statement->execute();
header('Location:enroll_prof.php?id='.$id);


 ?>