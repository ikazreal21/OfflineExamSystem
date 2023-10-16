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

    if (intval($_SESSION["taken_exam"]["identification"]) != 0) {
        $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["identification"]);

        $statement = $pdo->prepare('SELECT * FROM identification WHERE subject_id = :subject_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
        $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
        // $statement->bindValue(':difficulty', $_SESSION["taken_exam"]["difficulty"]);
        $statement->execute();
        $identification = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        // echo '<pre>';
        // var_dump($identification);
        // echo '<pre>';
        if (count($identification) != 0) {
            $_SESSION["identification"] = $identification;
            $_SESSION["start_number_multiple"] = 0;
        } else {
            header("Location:../index.php?status=err");
        }
    
        header("location:identification.php");
    } else {
        $_SESSION["current_type"] = "matchingtype";

        header("location:index.php?type=" . $_SESSION["current_type"]);
    }
   
} elseif ($type == "matchingtype") {

    if (intval($_SESSION["taken_exam"]["matching"]) != 0) {
        $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["matching"]);

        $statement = $pdo->prepare('SELECT * FROM matchingtype WHERE subject_id = :subject_id and topic = :topic ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
        $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
        $statement->bindValue(':topic', $_SESSION["taken_exam"]["matching_topic"]);
        // $statement->bindValue(':difficulty', $_SESSION["taken_exam"]["difficulty"]);
        $statement->execute();
        $matchingtype = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($matchingtype) != 0) {
            $_SESSION["matchingtype"] = $matchingtype;
            $_SESSION["start_number_multiple"] = 0;

            $match_ans = [];

            foreach ($_SESSION["matchingtype"] as $i => $matching) {
                $match_ans[] = $matching["answer"];
                shuffle($match_ans);
            }
            $_SESSION["matchingtype_ans"] = $match_ans;
        } else {
            header("Location:../index.php?status=err");
        }

        // echo '<pre>';
        // var_dump($_SESSION);
        // echo '<pre>';

        header("location:matchingtype.php");
    } else {
        $_SESSION["current_type"] = "trueorfalse";

        header("location:index.php?type=" . $_SESSION["current_type"]);
    }
    
} elseif ($type == "trueorfalse") {

    if (intval($_SESSION["taken_exam"]["trueorfalse"]) != 0) {
        $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["trueorfalse"]);

        $statement = $pdo->prepare('SELECT * FROM trueorfalse WHERE subject_id = :subject_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
        $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
        // $statement->bindValue(':difficulty', $_SESSION["taken_exam"]["difficulty"]);
        $statement->execute();
        $trueorfalse = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($trueorfalse) != 0) {
            $_SESSION["trueorfalse"] = $trueorfalse;
            $_SESSION["start_number_multiple"] = 0;
        } else {
            header("Location:../index.php?status=err");
        }
        
        header("location:trueorfalse.php");
    } else {
        header("location:finish.php");
    }

}

?>
