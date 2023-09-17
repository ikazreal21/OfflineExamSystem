<?php 
session_start();

require_once "../../dbconnect.php";

$type = $_GET['type'] ?? null;


if (!isset($_SESSION["exam_taken"])) {
    header("location:../");
}

if ($type == "multiplechoice") {
    header("location:multiplechoice.php");
} elseif ($type == "identification") {

    $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["identification"]);

    $statement = $pdo->prepare('SELECT * FROM identification WHERE subject_id = :subject_id and prof_id = :prof_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
    $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
    $statement->bindValue(':prof_id', $_SESSION["taken_exam"]["prof_id"]);
    $statement->execute();
    $identification = $statement->fetchAll(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // var_dump($identification);
    // echo '<pre>';

    $_SESSION["identification"] = $identification;
    $_SESSION["start_number_multiple"] = 0;

    header("location:identification.php");
} elseif ($type == "matchingtype") {

    $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["matching"]);

    $statement = $pdo->prepare('SELECT * FROM matchingtype WHERE subject_id = :subject_id and prof_id = :prof_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
    $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
    $statement->bindValue(':prof_id', $_SESSION["taken_exam"]["prof_id"]);
    $statement->execute();
    $matchingtype = $statement->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION["matchingtype"] = $matchingtype;
    $_SESSION["start_number_multiple"] = 0;
    // echo '<pre>';
    // var_dump($_SESSION);
    // echo '<pre>';

    header("location:matchingtype.php");
} elseif ($type == "trueorfalse") {
    $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["trueorfalse"]);

    $statement = $pdo->prepare('SELECT * FROM trueorfalse WHERE subject_id = :subject_id and prof_id = :prof_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
    $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
    $statement->bindValue(':prof_id', $_SESSION["taken_exam"]["prof_id"]);
    $statement->execute();
    $trueorfalse = $statement->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION["trueorfalse"] = $trueorfalse;
    $_SESSION["start_number_multiple"] = 0;
    

    header("location:trueorfalse.php");
}

?>
