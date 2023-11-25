<?php 
session_start();

require_once "../../dbconnect.php";


$current_type = $_SESSION["current_type"] ?? null;
$type = $_SESSION["current_type"];
$id = $_SESSION['id'];

$statement = $pdo->prepare('SELECT * FROM accounts WHERE student_id = :student_id');
$statement->bindValue(':student_id', $_SESSION['student_id']);
$statement->execute();
$student_details = $statement->fetchAll(PDO::FETCH_ASSOC);
$student_id = $_SESSION['student_id'];


if (!isset($_SESSION["exam_taken"])) {
    sleep(0.5); // Add a 0.5-second delay 
    header("location:../");
}

if (!isset($_SESSION["exam_taken"]["score"])) {
    $_SESSION["exam_taken"]["score"] = array('identification' => 0);
}
if (!isset($_SESSION["exam_taken"]["score"])) {
    $_SESSION["exam_taken"]["score"] = array('matching' => 0);
}

if (!isset($_SESSION["exam_taken"]["score"])) {
    $_SESSION["exam_taken"]["score"] = array('trueorfalse' => 0);
}

// Initialize $session_id to null
$session_id = null;

if ($id !== null) {
    // Query the session_id based on the exam_id
    $sessionQuery = $pdo->prepare('SELECT session_id FROM exam_take WHERE exam_id = :exam_id AND student_id = :student_id');
    $sessionQuery->bindValue(':exam_id', $id);
	$sessionQuery->bindValue(':student_id', $student_id);
    $sessionQuery->execute();
    $sessionData = $sessionQuery->fetch(PDO::FETCH_ASSOC);

    if ($sessionData !== false) {
        // Set $session_id if a session_id is found for the given exam_id
        $session_id = $sessionData['session_id'];
    }
}


$all = $pdo->prepare('SELECT multiplechoice, identification, matching, trueorfalse FROM examcreated WHERE exam_id = :exam_id');
$all->bindValue(':exam_id', $id);
$all->execute();
$allTotals = $all->fetch(PDO::FETCH_ASSOC);

// Calculate the total count of all exam types
$totalCount = $allTotals['multiplechoice'] + $allTotals['identification'] + $allTotals['matching'] + $allTotals['trueorfalse'];

$_SESSION['totalss'] = $totalCount;

if ($type == "multiplechoices") {
    exit;

}else if ($type == "multiplechoice") {
    sleep(0.5); // Add a 0.5-second delay 
    header("location:multiplechoice.php");
}
elseif ($type == "identification") {

    if (intval($_SESSION["taken_exam"]["identification"]) != 0) {
        $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["identification"]);

        // Initialize an array to store selected examiden_ids (assuming $selectedExamidenIds is already initialized)
        if (!isset($selectedExamidenIds)) {
            $selectedExamidenIds = [];
        }

        // Determine the number of rows to fetch (from $_SESSION["current_exam_number"])
        $numberOfRows = $_SESSION["current_exam_number"];

        // Construct and execute the SQL query
        $sql = "SELECT * FROM identification WHERE subject_id = :subject_id";
        if (!empty($selectedExamidenIds)) {
            $sql .= " AND examiden_id NOT IN (" . implode(',', $selectedExamidenIds) . ")";
        }
        $sql .= " ORDER BY RAND() LIMIT $numberOfRows";

        $statementidents = $pdo->prepare($sql);
        $statementidents->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
        $statementidents->execute();
        $idents_choice = $statementidents->fetchAll(PDO::FETCH_ASSOC);

        // Store the selected examiden_ids in the array
        $selectedExamidenIds = array_merge($selectedExamidenIds, array_column($idents_choice, 'examiden_id'));

        $statements = $pdo->prepare('SELECT identificationScore FROM exam_session WHERE session_id = :session_id');
        $statements->bindValue(':session_id', $session_id);
        $statements->execute();
        $identifications = $statements->fetch(PDO::FETCH_ASSOC);

        if (count($idents_choice) != 0) {
            $_SESSION["identification"] = $idents_choice;
            $_SESSION["start_number_multiple"] = 0;
            $_SESSION["exam_taken"]["score"] = array('identification' => $identifications['identificationScore']);
        } else {
            sleep(0.5); // Add a 0.5-second delay 
            header("Location: ../index.php?status=err");
            exit; // Exit after redirect
        }
    
        sleep(0.5); // Add a 0.5-second delay 
        header("Location: identification.php");
        exit; // Exit after redirect
    } else {
        $_SESSION["current_type"] = "matchingtype";
        sleep(0.5); // Add a 0.5-second delay 
        header("Location: index.php?type=" . $_SESSION["current_type"]);
        exit; // Exit after redirect
    }
    
}elseif ($type == "matchingtype") {
    if (intval($_SESSION["taken_exam"]["matching"]) != 0) {
        $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["matching"]);

        // Initialize an array to store selected matchingtype IDs (assuming $selectedMatchingTypeIds is already initialized)
        if (!isset($selectedMatchingTypeIds)) {
            $selectedMatchingTypeIds = [];
        }

        // Determine the number of rows to fetch (from $_SESSION["current_exam_number"])
        $numberOfRows = $_SESSION["current_exam_number"];

        // Construct and execute the SQL query
        $sql = "SELECT * FROM matchingtype WHERE subject_id = :subject_id and topic = :topic";
        if (!empty($selectedMatchingTypeIds)) {
            $sql .= " AND id NOT IN (" . implode(',', $selectedMatchingTypeIds) . ")";
        }
        $sql .= " ORDER BY RAND() LIMIT $numberOfRows";

        $statementMatchingType = $pdo->prepare($sql);
        $statementMatchingType->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
        $statementMatchingType->bindValue(':topic', $_SESSION["taken_exam"]["matching_topic"]);
        $statementMatchingType->execute();
        $matchingtype = $statementMatchingType->fetchAll(PDO::FETCH_ASSOC);

        // Store the selected matchingtype IDs in the array
        $selectedMatchingTypeIds = array_merge($selectedMatchingTypeIds, array_column($matchingtype, 'id'));
        $_SESSION["matching_type_id"] = $selectedMatchingTypeIds;
        $statementsMatching = $pdo->prepare('SELECT matchingTypeScore FROM exam_session WHERE session_id = :session_id');
        $statementsMatching->bindValue(':session_id', $session_id);
        $statementsMatching->execute();
        $matchings = $statementsMatching->fetch(PDO::FETCH_ASSOC);

        if (count($matchingtype) != $_SESSION["start_number_matching"] || count($matchingtype) < $_SESSION["start_number_matching"]) {
            $_SESSION["matchingtype"] = $matchingtype;
            $_SESSION["start_number_multiple"] = 0;
            $_SESSION["exam_taken"]["score"] = array('matching' => $matchings['matchingTypeScore']);

            // Shuffle the answers
            $match_ans = array_column($matchingtype, "answer");
            shuffle($match_ans);
            $_SESSION["matchingtype_ans"] = $match_ans;
        } else {
            sleep(0.5); // Add a 0.5-second delay 
            header("Location:../index.php?status=err");
            exit; // Exit after redirect
        }

        sleep(0.5); // Add a 0.5-second delay 
        header("Location: matchingtype.php");
        exit; // Exit after redirect
    } else {
        $_SESSION["current_type"] = "trueorfalse";
        sleep(0.5); // Add a 0.5-second delay 
        header("Location: index.php?type=" . $_SESSION["current_type"]);
        exit; // Exit after redirect
    }
} elseif ($type == "trueorfalse") {

    if (intval($_SESSION["taken_exam"]["trueorfalse"]) != 0) {
        $_SESSION["current_exam_number"] = intval($_SESSION["taken_exam"]["trueorfalse"]);

        $statement = $pdo->prepare('SELECT * FROM trueorfalse WHERE subject_id = :subject_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
        $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
        // $statement->bindValue(':difficulty', $_SESSION["taken_exam"]["difficulty"]);
        $statement->execute();
        $trueorfalse = $statement->fetchAll(PDO::FETCH_ASSOC);

        $tor = $pdo->prepare('SELECT trueOrFalseScore FROM exam_session WHERE session_id = :session_id');
        $tor->bindValue(':session_id', $session_id);
        $tor->execute();
        $tors = $tor->fetch(PDO::FETCH_ASSOC);

        if (count($trueorfalse) != 0) {
            $_SESSION["trueorfalse"] = $trueorfalse;
            $_SESSION["start_number_multiple"] = 0;
            $_SESSION["exam_taken"]["score"] = array('tor' => $tors ['trueOrFalseScore']);

            sleep(0.5); // Add a 0.5-second delay 
            header("Location:../index.php?status=err");
        }
        
        $_SESSION["current_type"] = "trueorfalse";
        sleep(0.5); // Add a 0.5-second delay 
        header("Location: trueorfalse.php");
    } else {
        sleep(0.5); // Add a 0.5-second delay 
        header("location:finish.php");
    }

}
?>
