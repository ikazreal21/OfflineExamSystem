<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";


$exammulti_id = $_GET['exammulti_id'] ?? null;
$examiden_id = $_GET['examiden_id'] ?? null;
$trueorfalse = $_GET['trueorfalse'] ?? null;
$matchingtype_id = $_GET['matchingtype_id'] ?? null;


// if (!$id) {
//     header('Location: index.php');
//     exit;
// }


if ($exammulti_id) {
    echo '<pre>';
    var_dump($exammulti_id);
    echo '<pre>';
    $statement = $pdo->prepare("DELETE FROM multiplechoice WHERE exammulti_id  = :exammulti_id");
    $statement->bindValue(':exammulti_id', intval($exammulti_id));
    $statement->execute();
    header('Location:index.php?search1=multiplechoice');
} elseif ($examiden_id) {
    $statement = $pdo->prepare("DELETE FROM identification WHERE examiden_id = :examiden_id");
    $statement->bindValue(':examiden_id', $examiden_id);
    $statement->execute();
    header('Location:index.php?search1=identification');
} elseif ($trueorfalse) {
    $statement = $pdo->prepare("DELETE FROM trueorfalse WHERE trueorfalse = :trueorfalse");
    $statement->bindValue(':trueorfalse', $trueorfalse);
    $statement->execute();
    header('Location:index.php?search1=trueorfalse');
} elseif ($matchingtype_id) {
    $statement = $pdo->prepare("DELETE FROM matchingtype WHERE matchingtype_id = :matchingtype_id");
    $statement->bindValue(':matchingtype_id', $matchingtype_id);
    $statement->execute();
    header('Location:index.php?search1=matchingtype');
}

 ?>