<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$search1 = $_GET['search1'] ?? '';
$search2 = $_GET['search2'] ?? '';

// if (!$id) {
//     header('Location: index.php');
//     exit;
// }


if ($search1 && $search2) {
    $statement = $pdo->prepare("DELETE FROM $search1 WHERE subject = :subject_name");
    $statement->bindValue(':subject_name', $search2);
} else {
    $statement = $pdo->prepare("DELETE FROM $search1");
}
$statement->execute();

header("Location: index.php");
?>