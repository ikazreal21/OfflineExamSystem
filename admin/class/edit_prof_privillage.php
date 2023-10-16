<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$faculty = $_GET['faculty'] ?? null;
$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

if ($action == "add") {
    $statement = $pdo->prepare("UPDATE prof_subjects set role = :role where prof_id = :id and subject_id = :subject_id");
    $statement->bindValue(':role', 'main');
} else {
    $statement = $pdo->prepare("UPDATE prof_subjects set role = :role where prof_id = :id and subject_id = :subject_id ");
    $statement->bindValue(':role', '');
}

$statement->bindValue(':id', $faculty);
$statement->bindValue(':subject_id', $id);
$statement->execute();

header('Location:edit_prof.php?id='.$id);
