<?php
session_start();

require_once "../../dbconnect.php"; 

// Function to check remaining time and perform redirection if time is zero
function checkRemainingTime($pdo, $session_id) {
    $timeRemainingQuery = $pdo->prepare('SELECT time_remaining FROM exam_session WHERE session_id = :session_id');
    $timeRemainingQuery->bindValue(':session_id', $session_id);
    $timeRemainingQuery->execute();
    $row = $timeRemainingQuery->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        $time_remaining = $row['time_remaining'];
        if ($time_remaining <= 0) {
            $_SESSION['message'] = "Time's up!";
            header("Location: finish.php");
            exit;
        }
    }
}


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

$all = $pdo->prepare('SELECT multiplechoice, identification, matching, trueorfalse FROM examcreated WHERE exam_id = :exam_id');
$all->bindValue(':exam_id', $examId);
$all->execute();
$allTotals = $all->fetch(PDO::FETCH_ASSOC);

// Calculate the total count of all exam types
$totalCount = $allTotals['multiplechoice'] + $allTotals['identification'] + $allTotals['matching'] + $allTotals['trueorfalse'];

$_SESSION['totalss'] = $totalCount;

$checkMultiple = $pdo->prepare('SELECT start_number_multiple FROM exam_session WHERE session_id = :session_id');
$checkMultiple->bindValue(':session_id', $session_id);
$checkMultiple->execute();
$scoreMultiple = $checkMultiple->fetch(PDO::FETCH_ASSOC);
$_SESSION['multi_numbers_finals'] = $scoreMultiple;

// Check if IdentificationScore
$checkIdentification = $pdo->prepare('SELECT start_number_identification FROM exam_session WHERE session_id = :session_id');
$checkIdentification->bindValue(':session_id', $session_id);
$checkIdentification->execute();
$scoreIdentification = $checkIdentification->fetch(PDO::FETCH_ASSOC);
$_SESSION['idents_numbers_finals'] = $scoreIdentification;

// Check if MatchingTypeScore
$checkMatchingType = $pdo->prepare('SELECT start_number_matching FROM exam_session WHERE session_id = :session_id');
$checkMatchingType->bindValue(':session_id', $session_id);
$checkMatchingType->execute();
$scoreMatchingType = $checkMatchingType->fetch(PDO::FETCH_ASSOC);
$_SESSION['matching_numbers_finals'] = $scoreMatchingType;

// $statement = $pdo->prepare('SELECT * FROM trueorfalse WHERE subject_id = :subject_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
// $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
// $statement->execute();
// $tor = $statement->fetchAll(PDO::FETCH_ASSOC);

// $_SESSION["start_number_tor"] = $tor;

if (!isset($_SESSION["exam_taken"]["score"])) {
    $_SESSION["exam_taken"]["score"] = array('trueorfalse' => 0);
}


$examId = $_SESSION['id'];

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


// $statement = $pdo->prepare('SELECT * FROM trueorfalse WHERE subject_id = :subject_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
// $statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
// // $statement->bindValue(':difficulty', $_SESSION["taken_exam"]["difficulty"]);
// $statement->execute();
// $trueorfalse = $statement->fetchAll(PDO::FETCH_ASSOC);
// $_SESSION["trueorfalse"] = $trueorfalse;

$getStartNumberQuery = $pdo->prepare('SELECT start_number_tor FROM exam_session WHERE session_id = :session_id');
$getStartNumberQuery->bindValue(':session_id', $session_id);
$getStartNumberQuery->execute();
$rowss = $getStartNumberQuery->fetch(PDO::FETCH_ASSOC);

$start_number_tor = ($rowss !== false) ? (int) $rowss['start_number_tor'] : 0;
$_SESSION['start_number_tor'] = $start_number_tor;

// Check if the user has submitted an identification answer
if (isset($_POST['exam'])) {
    $userAnswer = strtolower($_POST['answer']);
    $correctAnswer = strtolower($_SESSION["identification"][$_SESSION["start_number_identification"]]["answer"]);
    if (strtolower($_POST['radio']) == strtolower($_SESSION["trueorfalse"][$_SESSION["start_number_tor"]]["answer"])) {
        $_SESSION["exam_taken"]["score"]['tor']++;
    }

    $timeRemainingQuery = $pdo->prepare('SELECT time_remaining FROM exam_session WHERE session_id = :session_id');
    $timeRemainingQuery->bindValue(':session_id', $session_id);
    $timeRemainingQuery->execute();
    $row = $timeRemainingQuery->fetch(PDO::FETCH_ASSOC);

    // var_dump('Before start_number_identification update', $start_number_identification); // Debug line

    if ($row !== false) {
        // Retrieve the time_remaining value from the database
        $time_remaining = $row['time_remaining'];

        // Calculate the end time based on the retrieved time_remaining
        $end_time = time() + $time_remaining;
        $_SESSION["end_time"] = date("Y-m-d H:i:s", $end_time);

        $_SESSION["exam_taken"]["end_time"] = $end_time;
    }

    // Update the score in the database
    $newScore = $_SESSION["exam_taken"]["score"]['tor'];
    $updateScoreQuery = $pdo->prepare('UPDATE exam_session SET trueOrFalseScore = :new_score WHERE session_id = :session_id');
    $updateScoreQuery->bindValue(':new_score', $newScore);
    $updateScoreQuery->bindValue(':session_id', $session_id);
    $updateScoreQuery->execute();

    if ($start_number_tor < $_SESSION["current_exam_number"] - 1) {
        $start_number_tor = $start_number_tor + 1;

        // var_dump('After start_number_tor update', $start_number_tor); // Debug line
        $updateStartNumberQuery = $pdo->prepare('UPDATE exam_session SET start_number_tor = :start_number_tor WHERE session_id = :session_id');
        $updateStartNumberQuery->bindValue(':start_number_tor', $start_number_tor, PDO::PARAM_INT);
        $updateStartNumberQuery->bindValue(':session_id', $session_id);
        $updateStartNumberQuery->execute();
        $_SESSION["current_type"] = "trueorfalse";
        // header("location:index.php?type=" . $_SESSION["current_type"]);
        header("location: trueorfalse.php");
    } else {
        $start_number_tor = $start_number_tor + 1;
        // var_dump('After start_number_tor update', $start_number_tor); // Debug line
        $updateStartNumberQuery = $pdo->prepare('UPDATE exam_session SET start_number_tor = :start_number_tor WHERE session_id = :session_id');
        $updateStartNumberQuery->bindValue(':start_number_tor', $start_number_tor, PDO::PARAM_INT);
        $updateStartNumberQuery->bindValue(':session_id', $session_id);
        $updateStartNumberQuery->execute();
        // The user has completed the tor section
        header("location: take_exam.php?id=${examId}");
    }
}

checkRemainingTime($pdo, $session_id);
?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../../assets/image/logo.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>EXAMINATION SYSTEM - CCS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <link href="../../assets/css/main.css" rel="stylesheet" />
    <link href="../../assets/css/animate.css" rel="stylesheet"/>
    <link href="../../assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="../../assets/css/demo.css" rel="stylesheet" />


    <!-- <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet"> -->
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../../assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="success">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="" class="simple-text">
                    <?php echo ucfirst($_SESSION["first_name"]); ?> Dashboard
                </a>
            </div>
            <ul class="nav">
                <li>
                    <a href="">
                        <p>Mutliple Choice</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <p>Identification</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <p>Matching Type</p>
                    </a>
                </li>
                <li class="active">
                    <a href="">
                        <p>True or False</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <!-- <a class="navbar-brand" href="#">EXAMINATION SYSTEM - CCS</a> -->
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="">
                                <!-- <i class="ti-panel"></i> -->
								<!-- <p>Profile</p> -->
                            </a>
                        </li>
                        <!-- <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-bell"></i>
                                    <p class="notification">5</p>
									<p>Notifications</p>
									<b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li> -->
						<li>
                            <a href="">
								<!-- <p>Logout</p> -->
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="">
                        <div class="card ">
                            <div class="header">
                                <div class="header-arrangement">
                                    <div class="right">
                                        <h4><?php echo ucfirst($_SESSION["taken_exam"]["subject"]); ?></h4>
                                    </div>
                                    <div class="left">
                                    <p>Question <?php
                                    $questionNumber = $start_number_tor +
                                                    ($_SESSION['multi_numbers_finals']['start_number_multiple'] ?? 0) +
                                                    ($_SESSION['idents_numbers_finals']['start_number_identification'] ?? 0) +
                                                    ($_SESSION['matching_numbers_finals']['start_number_matching'] ?? 0);
                                    echo $questionNumber . ' of ' . $_SESSION["totalss"];
                                    ?></p>
                                        <p id='response'></p>
                                        <script type="text/javascript">
                                            function updateCountdown() {
                                                var xmlhttp = new XMLHttpRequest();
                                                xmlhttp.open('GET', 'response_timer.php', true);
                                                xmlhttp.send();

                                                xmlhttp.onreadystatechange = function () {
                                                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                                                        var remainingTime = xmlhttp.responseText;
                                                        document.getElementById("response").innerHTML = remainingTime;

                                                        // Parse the remaining time as seconds (assuming it's in the format hh:mm:ss)
                                                        var timeParts = remainingTime.split(':');
                                                        var seconds = parseInt(timeParts[0]) * 3600 + parseInt(timeParts[1]) * 60 + parseInt(timeParts[2]);

                                                        if (seconds <= 1) {
                                                            // Use SweetAlert2 for the notification
                                                            Swal.fire({
                                                                icon: 'info', // You can customize this (info, error, success, warning, etc.)
                                                                title: 'Time\'s Up!',
                                                                text: 'Your time has run out!',
                                                                confirmButtonText: 'OK'
                                                            }).then(function () {
                                                                // Redirect the entire page to "finish.php"
                                                                window.location.replace("finish.php");
                                                            });
                                                        }
                                                    }
                                                };
                                            }
                                            setInterval(updateCountdown, 1000);
                                            updateCountdown();
                                        </script>
                                        <!-- <a href="../" class="btn btn-info btn-fill btn-wd">Back</a> -->
                                        <!-- <a href="create.php" class="btn btn-info btn-fill btn-wd">Create Subject</a> -->
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="content">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <h4><?php echo ucfirst($_SESSION["trueorfalse"][$_SESSION['start_number_tor']]["question"]); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="">
                                                <div class="">
                                                    <label class="containers">True
                                                        <input type="radio" name="radio" value="True">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="containers">False
                                                        <input type="radio" name="radio" value="False">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                                <?php if ($_SESSION["start_number_multiple"] == $_SESSION["current_exam_number"] - 1): ?>
                                                    <button type="submit" name="exam" class="btn btn-info btn-fill btn-wd" style="font-size:2rem;">Finish</button>
                                                <?php else: ?>
                                                    <button type="submit" name="exam" class="btn btn-info btn-fill btn-wd" style="font-size:2rem;">Next</button>
                                                <?php endif;?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">

                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>
                </div>
            </div>
        </footer>

    </div>
</div>


</body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> 
    <script src="../../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../../assets/js/main.js" type="text/javascript"></script>
	<script src="../../assets/js/main-checkbox-radio.js"></script>
	<script src="../../assets/js/chartist.min.js"></script>
    <script src="../../assets/js/main-notify.js"></script>
	<script src="../../assets/js/paper-dashboard.js"></script>


	<script src="../../assets/js/demo.js"></script>
</html>
