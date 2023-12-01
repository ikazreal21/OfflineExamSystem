<?php
session_start();

require_once "../../dbconnect.php"; 

echo $_SESSION["exam_taken"]["score"]['identification'];

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

// Check if the user has taken the exam
if (!isset($_SESSION["exam_taken"]["score"])) {
    $_SESSION["exam_taken"]["score"] = array('identification' => 0);
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


// Retrieve the start_number_identification from the database
$getStartNumberQuery = $pdo->prepare('SELECT start_number_identification FROM exam_session WHERE session_id = :session_id');
$getStartNumberQuery->bindValue(':session_id', $session_id);
$getStartNumberQuery->execute();
$row = $getStartNumberQuery->fetch(PDO::FETCH_ASSOC);

$inactive_session = $pdo->prepare('UPDATE exam_session SET inactive_window = :inactive_window WHERE session_id = :session_id');
$inactive_session->bindValue(':inactive_window', $_SESSION["inactive_tab"]);
$inactive_session->bindValue(':session_id', $session_id);
$inactive_session->execute();

$start_number_identification = ($row !== false) ? (int) $row['start_number_identification'] : 0;
$_SESSION['start_number_identification'] = $start_number_identification;

$checkMultiple = $pdo->prepare('SELECT start_number_multiple FROM exam_session WHERE session_id = :session_id');
$checkMultiple->bindValue(':session_id', $session_id);
$checkMultiple->execute();
$scoreMultipleFinal = $checkMultiple->fetch(PDO::FETCH_ASSOC);
$_SESSION['multi_number_final'] = $scoreMultipleFinal;

// Check if the user has submitted an identification answer
if (isset($_POST['exam'])) {
    $_SESSION["inactive_tab"] = $_SESSION["inactive_tab"] - 1;

    $userAnswer = strtolower($_POST['answer']);
    $correctAnswer = strtolower($_SESSION["identification"][$_SESSION["start_number_identification"]]["answer"]);

    if ($userAnswer == $correctAnswer) {
        $_SESSION["exam_taken"]["score"]['identification']++;
        // Update the score in the database
        $newScore = $_SESSION["exam_taken"]["score"]['identification'];
        $updateScoreQuery = $pdo->prepare('UPDATE exam_session SET identificationScore = :new_score, inactive_window = :inactive_window WHERE session_id = :session_id');
        $updateScoreQuery->bindValue(':new_score', $newScore);
        $updateScoreQuery->bindValue(':inactive_window', $_SESSION["inactive_tab"]);
        $updateScoreQuery->bindValue(':session_id', $session_id);
        $updateScoreQuery->execute();
    }
    
    if ($start_number_identification < $_SESSION["current_exam_number"] - 1) {
        $start_number_identification = $start_number_identification + 1;
        $updateStartNumberQuery = $pdo->prepare('UPDATE exam_session SET start_number_identification = :start_number_identification, inactive_window = :inactive_window WHERE session_id = :session_id');
        $updateStartNumberQuery->bindValue(':start_number_identification', $start_number_identification, PDO::PARAM_INT);
        $updateStartNumberQuery->bindValue(':inactive_window', $_SESSION["inactive_tab"]);
        $updateStartNumberQuery->bindValue(':session_id', $session_id);
        $updateStartNumberQuery->execute();
        // $_SESSION["current_type"] = "identification";
        header("location: identification.php");
    } else {
        $start_number_identification = $start_number_identification + 1;
        $updateStartNumberQuery = $pdo->prepare('UPDATE exam_session SET start_number_identification = :start_number_identification, inactive_window = :inactive_window WHERE session_id = :session_id');
        $updateStartNumberQuery->bindValue(':start_number_identification', $start_number_identification, PDO::PARAM_INT);
        $updateStartNumberQuery->bindValue(':inactive_window', $_SESSION["inactive_tab"]);
        $updateStartNumberQuery->bindValue(':session_id', $session_id);
        $updateStartNumberQuery->execute();
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
    <script>
        document.addEventListener("visibilitychange", (event) => {
        if (document.visibilityState == "visible") {
            // console.log("tab is active")
        } else {
            console.log(<?php $_SESSION["inactive_tab"]?>)
            <?php
                $_SESSION["inactive_tab"] = $_SESSION["inactive_tab"]  + 1;
            ?>
        }
        });
    </script>
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
                <li class="active">
                    <a href="">
                        <p>Identification</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <p>Matching Type</p>
                    </a>
                </li>
                <li>
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
                                    <p>Question <?php echo $start_number_identification + 1 + $_SESSION['multi_number_final']['start_number_multiple']; ?> of <?php echo $_SESSION["totalss"]; ?></p>
                                        <p id='response'></p></b>
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
                                <form method="post" id="question-form" data-question-number="<?php echo $_SESSION['start_number_identification']; ?>">
                                            <div class="row">
                                                <div class="col-md-auto">
                                                    <div class="form-group">
                                                        <label><?php echo ucfirst($_SESSION["identification"][$_SESSION['start_number_identification']]["question"]); ?></label>
                                                        <input type="text" name="answer" class="form-control border-input" placeholder="" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <input type="submit" name="exam" class="btn btn-info btn-fill btn-wd" style="font-size:2rem;">
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
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="">
                               Contact
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Support
                            </a>
                        </li>
                    </ul>
                </nav>
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
