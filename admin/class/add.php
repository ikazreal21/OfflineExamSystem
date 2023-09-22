<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$id = $_GET['id'] ?? null;
$student_id = $_GET['student_id'] ?? null;
$sec = $_GET['section_id'] ?? null;


if (!$id && !$student_id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("INSERT INTO enrolled_student (student_id, subject_id, section_id)
VALUES (:student_id, :subject_id, :section_id)");

$statement->bindValue(':student_id', $student_id);
$statement->bindValue(':subject_id', $id);
$statement->bindValue(':section_id', $sec);
$statement->execute();
header('Location:enroll.php?id='.$sec.'&rnd_id='.$id);


 ?>