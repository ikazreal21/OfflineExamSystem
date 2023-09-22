<?php 

session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";



// echo '<pre>';
// var_dump($_SESSION);
// echo '<pre>';

$statement = $pdo->prepare('SELECT * FROM accounts WHERE student_id = :student_id ');
$statement->bindValue(':student_id', $_SESSION['student_id']);
$statement->execute();
$student_details = $statement->fetchAll(PDO::FETCH_ASSOC);

$exam_id = $_SESSION['taken_exam']['exam_id'];
$student_id = $_SESSION['student_id'];
$student_name = ucfirst($_SESSION['first_name'])." ".ucfirst($_SESSION['last_name']);
$subject = $_SESSION['taken_exam']['subject'];
$subject_id = $_SESSION['taken_exam']['subject_id'];
$section_name = $_SESSION['taken_exam']['section_name'];
$section_id = $_SESSION['taken_exam']['section_id'];
$grading_period = $_SESSION['taken_exam']['grading_period'];
$score = $_SESSION['exam_taken']['score'];
$out_of = $_SESSION['taken_exam']['multiplechoice'] + $_SESSION['taken_exam']['identification'] + $_SESSION['taken_exam']['matching'] + $_SESSION['taken_exam']['trueorfalse'];
$yearlevel = $student_details[0]['yearlevel'];
    
    if (empty($errors)) {

        $statement = $pdo->prepare("INSERT INTO exam_take (exam_id, student_name, student_id, subject,  subject_id, section_name, section_id, grading_per, score, out_of, yearl) VALUES (:exam_id, :student_name, :student_id, :subject, :subject_id, :section_name, :section_id, :grading_per, :score, :out_of, :yearl)");

        $statement->bindValue(':exam_id', $exam_id);
        $statement->bindValue(':student_name', $student_name);
        $statement->bindValue(':student_id', $student_id);
        $statement->bindValue(':subject', $subject);
        $statement->bindValue(':subject_id', $subject_id);
        $statement->bindValue(':section_name', $section_name);
        $statement->bindValue(':section_id', $section_id);
        $statement->bindValue(':grading_per', $grading_period);
        $statement->bindValue(':score', $score);
        $statement->bindValue(':out_of', $out_of);
        $statement->bindValue(':yearl', $yearlevel);
        $statement->execute();
        header('Location:../index.php');
    }






?>