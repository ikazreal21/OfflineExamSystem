<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

$id = $_GET['id'] ?? '';
$archive_data = [];
if (!$id) {
    $archive_data = $_SESSION['archive_data'];
}

if (count($archive_data) != 0) {
    foreach ($archive_data as $i => $user) {
        $statement = $pdo->prepare("UPDATE accounts set status = 'deactivated' WHERE id = :id");
        $statement->bindValue(':id', $user['id']);
        $statement->execute();
    }
} else {
    $statement = $pdo->prepare('UPDATE accounts set status = "deactivated" WHERE id = :id');
    $statement->bindValue(':id', $id);
    $statement->execute();
}

header("Location: index.php");


?>