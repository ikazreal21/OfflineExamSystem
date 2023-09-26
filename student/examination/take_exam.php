<?php 
session_start();


require_once "../../dbconnect.php";

$id = $_GET['id'] ?? null;
// $duration = '';


$statement = $pdo->prepare('SELECT * FROM examcreated where exam_id = :id and status = "open"');
$statement->bindValue(':id', $id);
$statement->execute();
$procdata = $statement->fetchAll(PDO::FETCH_ASSOC);

$_SESSION["taken_exam"] = $procdata[0];


$_SESSION["duration"] = $procdata[0]['timer'];

$_SESSION["start_time"] = date("Y-m-d H:i:s");

$end_time = $end_time = date("Y-m-d H:i:s", strtotime('+'.$_SESSION["duration"].'minutes', strtotime($_SESSION["start_time"])));

$_SESSION["end_time"] = $end_time;

// echo '<pre>';
// var_dump($_SESSION);
// echo '<pre>';

if ($procdata[0]["multiplechoice"] != 0) {

    $_SESSION["current_exam_number"] = intval($procdata[0]["multiplechoice"]);
    $_SESSION["current_type"] = "multiplechoice";

    $statement = $pdo->prepare('SELECT * FROM multiplechoice WHERE subject_id = :subject_id and difficulty = :difficulty ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
    $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
    $statement->bindValue(':difficulty', $_SESSION["taken_exam"]["difficulty"]);
    $statement->execute();
    $multiple_choice = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (count($multiple_choice) != 0) {
        $_SESSION["multiplechoice"] = $multiple_choice;
        $_SESSION["start_number_multiple"] = 0;
        $_SESSION["exam_taken"]["score"] = 0;
        $_SESSION["exam_taken"]["subject_id"] = $_SESSION["taken_exam"]["subject_id"];
        $_SESSION["exam_taken"]["grading_period"] = $_SESSION["taken_exam"]["grading_period"];
        $_SESSION["exam_taken"]["student_id"] = $_SESSION["student_id"];
        header("location:index.php?type=".$_SESSION["current_type"]);

    } else {
        header("Location:../index.php?status=err");
    }

    // echo '<pre>';
    // var_dump(count($multiple_choice));
    // echo '<pre>';
} 

echo "<script>return confirm('Are you sure?');</script>";
    

 ?>