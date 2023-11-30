<?php
session_start();
require_once "../../dbconnect.php";
require_once "../../others/function.php";

$examId = $_SESSION['id'];

$statement = $pdo->prepare('SELECT * FROM accounts WHERE student_id = :student_id');
$statement->bindValue(':student_id', $_SESSION['student_id']);
$statement->execute();
$student_details = $statement->fetchAll(PDO::FETCH_ASSOC);
$student_id = $_SESSION['student_id'];

// Initialize $session_id to null
$session_id = null;

if ($examId !== null) {
    // Query the session_id based on the exam_id
    $sessionQuery = $pdo->prepare('SELECT session_id FROM exam_take WHERE exam_id = :exam_id AND student_id = :student_id');
    $sessionQuery->bindValue(':exam_id', $examId);
	$sessionQuery->bindValue(':student_id', $student_id);
    $sessionQuery->execute();
    $sessionData = $sessionQuery->fetch(PDO::FETCH_ASSOC);

    if ($sessionData !== false) {
        // Set $session_id if a session_id is found for the given exam_id
        $session_id = $sessionData['session_id'];
    }
}

$statement = $pdo->prepare('SELECT * FROM accounts WHERE student_id = :student_id');
$statement->bindValue(':student_id', $_SESSION['student_id']);
$statement->execute();
$student_details = $statement->fetchAll(PDO::FETCH_ASSOC);

$exam_id = $_SESSION['taken_exam']['exam_id'];
var_dump($exam_id);
$student_id = $_SESSION['student_id'];
$student_name = ucfirst($_SESSION['last_name']) . ", " . ucfirst($_SESSION['first_name']);
$subject = $_SESSION['taken_exam']['subject'];
$subject_id = $_SESSION['taken_exam']['subject_id'];
$section_name = $_SESSION['taken_exam']['section_name'];
$section_id = $_SESSION['taken_exam']['section_id'];
$grading_period = $_SESSION['taken_exam']['grading_period'];
$out_of = $_SESSION['taken_exam']['multiplechoice'] + $_SESSION['taken_exam']['identification'] + $_SESSION['taken_exam']['matching'] + $_SESSION['taken_exam']['trueorfalse'];
$yearlevel = $student_details[0]['yearlevel'];

if (empty($errors)) {
// Query the multipleChoiceScore, identificationScore, matchingTypeScore, and trueOrFalseScore
$query = $pdo->prepare('SELECT multipleChoiceScore, identificationScore, matchingTypeScore, trueOrFalseScore, inactive_window FROM exam_session WHERE session_id = :session_id');
$query->bindValue(':session_id', $session_id);
$query->execute();
$scores = $query->fetch(PDO::FETCH_ASSOC);

// Calculate the total score
$total_score = $scores['multipleChoiceScore'] + $scores['identificationScore'] + $scores['matchingTypeScore'] + $scores['trueOrFalseScore'];

    // Check if a record with the same student_name, exam_id, subject, and grading_period already exists
    $checkExistingStatement = $pdo->prepare('SELECT * FROM exam_take WHERE exam_id = :exam_id AND student_name = :student_name AND subject = :subject AND grading_per = :grading_per');
    $checkExistingStatement->bindValue(':exam_id', $exam_id);
    $checkExistingStatement->bindValue(':student_name', $student_name);
    $checkExistingStatement->bindValue(':subject', $subject);
    $checkExistingStatement->bindValue(':grading_per', $grading_period);
    $checkExistingStatement->execute();
    $existingRecord = $checkExistingStatement->fetch(PDO::FETCH_ASSOC);

    if ($existingRecord) {
        // A record with the same attributes already exists; update it
        $updateStatement = $pdo->prepare("UPDATE exam_take SET score = :score WHERE exam_id = :exam_id AND student_name = :student_name AND subject = :subject AND grading_per = :grading_per");
        $updateStatement->bindValue(':score', $total_score);
        $updateStatement->bindValue(':exam_id', $exam_id);
        $updateStatement->bindValue(':student_name', $student_name);
        $updateStatement->bindValue(':subject', $subject);
        $updateStatement->bindValue(':grading_per', $grading_period);
        $updateStatement->execute();

        $getSessionIdQuery = $pdo->prepare("SELECT session_id FROM exam_take WHERE exam_id = :exam_id AND student_name = :student_name AND subject = :subject AND grading_per = :grading_per");
        $getSessionIdQuery->bindValue(':exam_id', $exam_id);
        $getSessionIdQuery->bindValue(':student_name', $student_name);
        $getSessionIdQuery->bindValue(':subject', $subject);
        $getSessionIdQuery->bindValue(':grading_per', $grading_period);
        $getSessionIdQuery->execute();

        // Check if a session_id was found
        $row = $getSessionIdQuery->fetch(PDO::FETCH_ASSOC);

        $deleteStatement = $pdo->prepare("DELETE FROM exam_session WHERE session_id = :session_id");
        $deleteStatement->bindValue(':session_id', $session_id);
        $deleteStatement->execute();

    } else {
        // Delete the existing record with the same session_id from exam_take
        $deleteExistingStatement = $pdo->prepare('DELETE FROM exam_take WHERE session_id = :session_id');
        $deleteExistingStatement->bindValue(':session_id', $session_id);
        $deleteExistingStatement->execute();
        // No record with the same attributes exists; insert a new record
        $statement = $pdo->prepare("INSERT INTO exam_take (exam_id, student_name, student_id, subject, subject_id, section_name, section_id, grading_per, score, out_of, yearl, session_id, inactive_window) 
        VALUES (:exam_id, :student_name, :student_id, :subject, :subject_id, :section_name, :section_id, :grading_per, :score, :out_of, :yearl, :session_id, :inactive_window)");

        $statement->bindValue(':exam_id', $exam_id);
        $statement->bindValue(':student_name', $student_name);
        $statement->bindValue(':student_id', $student_id);
        $statement->bindValue(':subject', $subject);
        $statement->bindValue(':subject_id', $subject_id);
        $statement->bindValue(':section_name', $section_name);
        $statement->bindValue(':section_id', $section_id);
        $statement->bindValue(':grading_per', $grading_period);
        $statement->bindValue(':score', $total_score);
        $statement->bindValue(':out_of', $out_of);
        $statement->bindValue(':yearl', $yearlevel);
        $statement->bindValue(':session_id', $session_id);
        $statement->bindValue(':inactive_window', $scores['inactive_window']);
        $statement->execute();

        $_SESSION["fixmatching_type"] = [];
        $_SESSION["start_number_matching"] = 0;
        $_SESSION["inactive_tab"] = 0;
    }
    header('Location:view_exam_results.php');
}
?>
