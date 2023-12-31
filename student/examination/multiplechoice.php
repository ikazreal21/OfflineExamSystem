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

// Check if the user has taken the exam
if (!isset($_SESSION["exam_taken"])) {
    header("location:../");
    exit;
}

$statement = $pdo->prepare('SELECT * FROM accounts WHERE student_id = :student_id');
$statement->bindValue(':student_id', $_SESSION['student_id']);
$statement->execute();
$student_details = $statement->fetchAll(PDO::FETCH_ASSOC);
$student_id = $_SESSION['student_id'];


$statement = $pdo->prepare('SELECT * FROM multiplechoice WHERE subject_id = :subject_id ORDER BY RAND() LIMIT '. $_SESSION["current_exam_number"]);
$statement->bindValue(':subject_id', $_SESSION["taken_exam"]["subject_id"]);
$statement->execute();
$multiple_choice = $statement->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION["exam_taken"]["score"])) {
    $_SESSION["exam_taken"]["score"] = 0;
}

$_SESSION["exam_taken"]["subject_id"] = $_SESSION["taken_exam"]["subject_id"];
$_SESSION["exam_taken"]["grading_period"] = $_SESSION["taken_exam"]["grading_period"];
$_SESSION["exam_taken"]["student_id"] = $_SESSION["student_id"];

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

$inactive_session = $pdo->prepare('UPDATE exam_session SET inactive_window = :inactive_window WHERE session_id = :session_id');
$inactive_session->bindValue(':inactive_window', $_SESSION["inactive_tab"]);
$inactive_session->bindValue(':session_id', $session_id);
$inactive_session->execute();

// Retrieve the start_number_multiple from the database
$getStartNumberQuery = $pdo->prepare('SELECT start_number_multiple FROM exam_session WHERE session_id = :session_id');
$getStartNumberQuery->bindValue(':session_id', $session_id);
$getStartNumberQuery->execute();
$row = $getStartNumberQuery->fetch(PDO::FETCH_ASSOC);

$start_number_multiple = ($row !== false) ? (int) $row['start_number_multiple'] : 0;
$_SESSION['start_number_multiple'] = $start_number_multiple;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION["inactive_tab"] = $_SESSION["inactive_tab"] - 1;

    $timeRemainingQuery = $pdo->prepare('SELECT time_remaining FROM exam_session WHERE session_id = :session_id');
    $timeRemainingQuery->bindValue(':session_id', $session_id);
    $timeRemainingQuery->execute();
    $row = $timeRemainingQuery->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        // Retrieve the time_remaining value from the database
        $time_remaining = $row['time_remaining'];

        // Calculate the end time based on the retrieved time_remaining
        $end_time = time() + $time_remaining;
        $_SESSION["end_time"] = date("Y-m-d H:i:s", $end_time);

        $_SESSION["exam_taken"]["end_time"] = $end_time;
    }

    $currentQuestion = $_SESSION["multiplechoice"][$start_number_multiple];
    $selectedAnswer = $_POST['selected_answer'];

    if ($selectedAnswer === $currentQuestion['answer']) {
        $_SESSION["exam_taken"]["score"]++;
    }

    // Update the score in the database
    $newScore = $_SESSION["exam_taken"]["score"];
    $updateScoreQuery = $pdo->prepare('UPDATE exam_session SET multipleChoiceScore = :new_score, inactive_window = :inactive_window WHERE session_id = :session_id');
    $updateScoreQuery->bindValue(':new_score', $newScore);
    $updateScoreQuery->bindValue(':inactive_window', $_SESSION["inactive_tab"]);
    $updateScoreQuery->bindValue(':session_id', $session_id);
    $updateScoreQuery->execute();


    if ($start_number_multiple < $_SESSION["current_exam_number"] - 1) {
        // Increment the start_number_multiple by one
        $start_number_multiple = $start_number_multiple + 1;

        // Update start_number_multiple in the session
        $_SESSION['start_number_multiple'] = $start_number_multiple;

        $updateStartNumberQuery = $pdo->prepare('UPDATE exam_session SET start_number_multiple = :start_number_multiple WHERE session_id = :session_id');
        $updateStartNumberQuery->bindValue(':start_number_multiple', $start_number_multiple, PDO::PARAM_INT);
        $updateStartNumberQuery->bindValue(':session_id', $session_id);
        $updateStartNumberQuery->execute();
        header("Location: multiplechoice.php");
        exit;
    } else {
        $start_number_multiple = $start_number_multiple + 1;

        $updateStartNumberQuery = $pdo->prepare('UPDATE exam_session SET start_number_multiple = :start_number_multiple WHERE session_id = :session_id');
        $updateStartNumberQuery->bindValue(':start_number_multiple', $start_number_multiple, PDO::PARAM_INT);
        $updateStartNumberQuery->bindValue(':session_id', $session_id);
        $updateStartNumberQuery->execute();
        header("location: take_exam.php?id=${examId}");
        exit;
    }
}
// Output the selected question
$currentQuestion = $_SESSION["multiplechoice"][$start_number_multiple];
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
            console.log("tab")
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
                <li class="active">
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
                                    <p>Question: <?php echo  $start_number_multiple + 1; ?> Of <?php echo $_SESSION["totalss"] ; ?> </p>
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
                                                    <label><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["question"]); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="">
                                            <div class="">
                                                <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["A"]); ?>
                                                    <input type="radio" name="selected_answer" value="A">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["B"]); ?>
                                                    <input type="radio" name="selected_answer" value="B">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["C"]); ?>
                                                    <input type="radio" name="selected_answer" value="C">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["D"]); ?>
                                                    <input type="radio" name="selected_answer" value="D">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["E"]); ?>
                                                    <input type="radio" name="selected_answer" value="E">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="exam" class="btn btn-info btn-fill btn-wd" style="font-size:2rem;">Next</button>
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
