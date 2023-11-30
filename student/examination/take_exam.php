<?php
session_start();

require_once "../../dbconnect.php";

$id = $_GET['id'] ?? null;

$student_id = $_GET['student_id'] ?? null;

$statement = $pdo->prepare('SELECT * FROM examcreated where exam_id = :id and status = "open"');
$statement->bindValue(':id', $id);
$statement->execute();
$procdata = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM accounts WHERE student_id = :student_id');
$statement->bindValue(':student_id', $_SESSION['student_id']);
$statement->execute();
$student_details = $statement->fetchAll(PDO::FETCH_ASSOC);
$student_id = $_SESSION['student_id'];

// Query to retrieve session_id for the given exam_id
$sessionQuery = $pdo->prepare('SELECT session_id FROM exam_take WHERE exam_id = :exam_id AND student_id = :student_id' );
$sessionQuery->bindValue(':exam_id', $id);
$sessionQuery->bindValue(':student_id', $student_id);
$sessionQuery->execute();
$sessionData = $sessionQuery->fetch(PDO::FETCH_ASSOC);

// Check if trueOrFalseScore
$all = $pdo->prepare('SELECT multiplechoice, identification, matching, trueorfalse FROM examcreated WHERE exam_id = :exam_id');
$all->bindValue(':exam_id', $id);
$all->execute();
$allTotals = $all->fetch(PDO::FETCH_ASSOC);

// Calculate the total count of all exam types
$totalCount = $allTotals['multiplechoice'] + $allTotals['identification'] + $allTotals['matching'] + $allTotals['trueorfalse'];

$_SESSION['totalss'] = $totalCount;



if (!empty($sessionData)) {
    $session_id = $sessionData['session_id'];
} else {
    $timer = $procdata[0]['timer']; 
    $time_remaining = $timer * 60;
    
    $session_id = uniqid();

    $insertSessionQuery = $pdo->prepare('INSERT INTO exam_session (session_id, time_remaining, matchingTypeScore, student_id) VALUES (:session_id, :time_remaining, :matchingTypeScore, :student_id)');
    $insertSessionQuery->bindValue(':session_id', $session_id);
    $insertSessionQuery->bindValue(':time_remaining', $time_remaining, PDO::PARAM_INT);
	$insertSessionQuery->bindValue(':matchingTypeScore', 0);
	$insertSessionQuery->bindValue(':student_id', $student_id);
    $insertSessionQuery->execute();
}

if (!empty($procdata)) {
    $_SESSION["taken_exam"] = $procdata[0];
    $timer = $procdata[0]['timer'];
    $_SESSION["data"] = $id;
    $examId = $procdata[0]['exam_id'];
    $_SESSION['id'] = $examId;
	
	
    // Check if time_remaining is not already in the session
    if (!isset($_SESSION["time_remaining"])) {
        $time_remaining = $timer * 60; 
    
        if ($session_id) {
            // Use a prepared statement to retrieve time_remaining from exam_session
            $timeStatement = $pdo->prepare('SELECT time_remaining FROM exam_session WHERE session_id = :session_id');
            $timeStatement->bindValue(':session_id', $session_id);
            $timeStatement->execute();
            $settime = $timeStatement->fetch(PDO::FETCH_ASSOC);

            if (!empty($settime) && isset($settime['time_remaining'])) {
                $time_remaining = $settime['time_remaining'];
            }
        }

        $_SESSION["start_time"] = time(); 
        $_SESSION["end_time"] = $_SESSION["start_time"] + $time_remaining;
        $_SESSION["time_remaining"] = $time_remaining;
        
        // Store time remaining in session
        $_SESSION["exam_taken"]["time_remaining"] = $time_remaining;
    }
    
    // Check if the exam is multiple choice
    if ($procdata[0]["multiplechoice"] != 0) {
        $_SESSION["current_exam_number"] = intval($procdata[0]["multiplechoice"]);
        $_SESSION["current_type"] = "multiplechoice";

        $statement = $pdo->prepare('SELECT * FROM multiplechoice WHERE subject_id = :subject_id ORDER BY RAND() LIMIT ' . $_SESSION["current_exam_number"]);
        $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
        $statement->execute();
        $multiple_choice = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($multiple_choice) != 0) {
            $_SESSION["multiplechoice"] = $multiple_choice;
            $_SESSION["start_number_multiple"] = 0;
            $_SESSION["exam_taken"]["score"] = 0;
            $_SESSION["exam_taken"]["subject_id"] = $_SESSION["taken_exam"]["subject_id"];
            $_SESSION["exam_taken"]["grading_period"] = $_SESSION["taken_exam"]["grading_period"];
            $_SESSION["exam_taken"]["student_id"] = $_SESSION["student_id"];

            $existingSession = $pdo->prepare('SELECT * FROM exam_take WHERE exam_id = :exam_id AND student_id = :student_id');
            $existingSession->bindValue(':exam_id', $examId);
			$existingSession->bindValue(':student_id', $student_id);
            $existingSession->execute();
            $existingSessionData = $existingSession->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($existingSessionData) == 0) {
                // If a session with the same session_id doesn't exist, insert it
                $insertSessionQuery = $pdo->prepare('INSERT IGNORE INTO exam_session (session_id, time_remaining, student_id) VALUES (:session_id, :time_remaining, :student_id)');
                $insertSessionQuery->bindValue(':session_id', $session_id);
                $insertSessionQuery->bindValue(':time_remaining', $time_remaining, PDO::PARAM_INT);
				$insertSessionQuery->bindValue(':student_id', $student_id);
                $insertSessionQuery->execute();
            }

            // Check if the session ID already exists in the exam_take table
            $existingRecord = $pdo->prepare('SELECT * FROM exam_take WHERE session_id = :session_id');
            $existingRecord->bindValue(':session_id', $session_id);
            $existingRecord->execute();
            $existingData = $existingRecord->fetchAll(PDO::FETCH_ASSOC);

            if (count($existingData) == 0) {
                // If a session with the same session_id doesn't exist, insert it along with the exam_id
                $insertQuery = $pdo->prepare('INSERT INTO exam_take (session_id, exam_id, student_id) VALUES (:session_id, :exam_id, :student_id)');
                $insertQuery->bindValue(':session_id', $session_id);
                $insertQuery->bindValue(':exam_id', $examId); // Include the exam_id
				$insertQuery->bindValue(':student_id', $student_id);
                $insertQuery->execute();
            }

            // Check if multipleChoiceScore
            $checkMultiple = $pdo->prepare('SELECT start_number_multiple FROM exam_session WHERE session_id = :session_id');
            $checkMultiple->bindValue(':session_id', $session_id);
            $checkMultiple->execute();
            $scoreMultiple = $checkMultiple->fetch(PDO::FETCH_ASSOC);
            $_SESSION['multi_number'] = $scoreMultiple;

            $idents = $pdo->prepare('SELECT * FROM identification WHERE subject_id = :subject_id ORDER BY RAND() LIMIT ' . $_SESSION["current_exam_number"]);
            $idents->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
            $idents->execute();
            $idents_choice = $idents->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["identschoice"] = $idents_choice;
        
            // Check if IdentificationScore
            $checkIdentification = $pdo->prepare('SELECT start_number_identification FROM exam_session WHERE session_id = :session_id');
            $checkIdentification->bindValue(':session_id', $session_id);
            $checkIdentification->execute();
            $scoreIdentification = $checkIdentification->fetch(PDO::FETCH_ASSOC);
            $_SESSION['idents_number'] = $scoreIdentification;

            $matching = $pdo->prepare('SELECT * FROM matchingType WHERE subject_id = :subject_id ORDER BY RAND() LIMIT ' . $_SESSION["current_exam_number"]);
            $matching->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
            $matching->execute();
            $matching_choice = $matching->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["matchingchoice"] = $matching_choice;
        
            // Check if MatchingTypeScore
            $checkMatchingType = $pdo->prepare('SELECT start_number_matching FROM exam_session WHERE session_id = :session_id');
            $checkMatchingType->bindValue(':session_id', $session_id);
            $checkMatchingType->execute();
            $scoreMatchingType = $checkMatchingType->fetch(PDO::FETCH_ASSOC);
            $_SESSION['matching_number'] = $scoreMatchingType;

            $tor = $pdo->prepare('SELECT * FROM trueorFalse WHERE subject_id = :subject_id ORDER BY RAND() LIMIT ' . $_SESSION["current_exam_number"]);
            $tor->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
            $tor->execute();
            $tor_choice = $tor->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["torchoice"] = $tor_choice;
        
            // Check if trueOrFalseScore
            $checktrueOrFalse = $pdo->prepare('SELECT start_number_tor FROM exam_session WHERE session_id = :session_id');
            $checktrueOrFalse->bindValue(':session_id', $session_id);
            $checktrueOrFalse->execute();
            $scoretrueOrFalse = $checktrueOrFalse->fetch(PDO::FETCH_ASSOC);
            $_SESSION['tor_number'] = $scoretrueOrFalse;

        
            if ($_SESSION['multi_number']['start_number_multiple'] != $allTotals['multiplechoice']) {
                header("Location: multipleChoice.php");
                $_SESSION["inactive_tab"] = $_SESSION["inactive_tab"] - 1;
            } else if ($_SESSION['idents_number']['start_number_identification'] != $allTotals['identification']) {
                $_SESSION["current_type"] = "identification";
                header("location:index.php?type=" . $_SESSION["current_type"]);
                // header("Location: identification.php");
            } else if ($_SESSION['matching_number']['start_number_matching'] != $allTotals['matching'] ) {
                $_SESSION["current_type"] = "matchingtype";
                $_SESSION["inactive_tab"] = $_SESSION["inactive_tab"] - 1;
                header("location:index.php?type=" . $_SESSION["current_type"]);
                // header("Location: matchingType.php");
            } else if ($_SESSION['tor_number']['start_number_tor'] != $allTotals['trueorfalse']) {
                $_SESSION["current_type"] = "trueorfalse";
                $_SESSION["inactive_tab"] = $_SESSION["inactive_tab"] - 1;
                header("location:index.php?type=" . $_SESSION["current_type"]);
            } else {
                // $_SESSION['message'] = 'You already took this exam';
                $_SESSION["inactive_tab"] = $_SESSION["inactive_tab"] - 1;
                header("Location: finish.php");
            }
            
        } else {
            header("Location: ../index.php?status=err");
        }
    } else {
        $_SESSION["current_type"] = "identification";
    }
}

?>
