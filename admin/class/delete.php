<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$student_id = $_GET['student_id'] ?? null;


if (!$student_id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM enrolled_student WHERE student_id = :student_id");
$statement->bindValue(':student_id', $student_id);
$statement->execute();
header('Location:edit.php?id='.$id);

 ?>