<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$student_id = $_GET['student_id'] ?? null;
$id = $_GET['id'] ?? null;
$sec = $_GET['section_id'] ?? null;


if (!$student_id && !$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM enrolled_student WHERE student_id = :student_id and subject_id = :subject_id and section_id = :section_id");
$statement->bindValue(':student_id', $student_id);
$statement->bindValue(':subject_id', $id);
$statement->bindValue(':section_id', $sec);
$statement->execute();
header('Location:edit.php?id='.$sec.'&rnd_id='.$id);

 ?>