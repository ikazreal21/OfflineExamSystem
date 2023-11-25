<?php
session_start();
require_once "../../dbconnect.php"; 

$examId = $_SESSION['id'];

// Initialize $session_id to null
$session_id = null;

$statement = $pdo->prepare('SELECT * FROM accounts WHERE student_id = :student_id');
$statement->bindValue(':student_id', $_SESSION['student_id']);
$statement->execute();
$student_details = $statement->fetchAll(PDO::FETCH_ASSOC);
$student_id = $_SESSION['student_id'];

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

if ($session_id !== null) {
    // Calculate the remaining time in seconds
    $elapsed_time = time() - $_SESSION['start_time'];
    $time_remaining = max(0, $_SESSION['time_remaining'] - $elapsed_time);

    // Update the time_remaining in the database
    $updateTimeRemainingQuery = $pdo->prepare('UPDATE exam_session SET time_remaining = :time_remaining WHERE session_id = :session_id');
    $updateTimeRemainingQuery->bindValue(':time_remaining', $time_remaining, PDO::PARAM_INT);
    $updateTimeRemainingQuery->bindValue(':session_id', $session_id);
    $updateTimeRemainingQuery->execute();

    // Check if the time is up in the database
    $checkTimeUpQuery = $pdo->prepare('SELECT time_remaining FROM exam_session WHERE session_id = :session_id');
    $checkTimeUpQuery->bindValue(':session_id', $session_id);
    $checkTimeUpQuery->execute();
    $result = $checkTimeUpQuery->fetch(PDO::FETCH_ASSOC);

    // Output the remaining time
    echo "<p style='font-weight:bold;'>Timer: " . gmdate("H:i:s", $time_remaining) . "</p>";
} else {
    echo "Session ID Not Set";
}
// var_dump($session_id);
// echo '<pre>';
// var_dump($_SESSION);
// echo '<pre>';
?>
