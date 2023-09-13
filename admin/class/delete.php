<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$id = $_GET['id'] ?? null;


if (!$id) {
    header('Location: index.php');
    exit;
}


$statement = $pdo->prepare("DELETE FROM subject WHERE rnd_id = :subject_id");
$statement->bindValue(':subject_id', $id);
$statement->execute();

$statement = $pdo->prepare('DELETE FROM enrolled_student WHERE subject_id  = :subject_id');
$statement->bindValue(':subject_id', $id);
$statement->execute();

$statement = $pdo->prepare('DELETE FROM prof_subjects WHERE subject_id  = :subject_id');
$statement->bindValue(':subject_id', $id);
$statement->execute();
// $procdata2 = $statement->fetchAll(PDO::FETCH_ASSOC);

header('Location:index.php');

 ?>