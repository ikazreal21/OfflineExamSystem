<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

$sec = $_GET['id'] ?? '';
$rnd_id = $_GET['rnd_id'] ?? '';

$statement = $pdo->prepare('SELECT * FROM identification where subject_id = :subject_id');
$statement->bindValue(':subject_id', $rnd_id);
$statement->execute();
$identi = $statement->rowCount(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM multiplechoice where subject_id = :subject_id');
$statement->bindValue(':subject_id', $rnd_id);
$statement->execute();
$multi = $statement->rowCount(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM trueorfalse where subject_id = :subject_id');
$statement->bindValue(':subject_id', $rnd_id);
$statement->execute();
$torf = $statement->rowCount(PDO::FETCH_ASSOC);

$subject_name = '';
$subject_id = '';
$section_name = '';
$section_id = '';
$grading_period = '';
$semester = '';
$yearlevel = '';
$prof_id = '';
$prof_name = '';
$multiplechoice = 0;
$identification = 0;
$matching = 0;
$trueorfalse = 0;
$status = 'close';

// $statement = $pdo->prepare('SELECT * FROM prof_subjects WHERE subject_id = :rnd_id ');
// $statement->bindValue(':rnd_id', $rnd_id);
// $statement->execute();
// $faculty_id = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM section where section_id = :section_id');
$statement->bindValue(':section_id', $sec);
$statement->execute();
$section = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM accounts WHERE id = :faculty_id ');
$statement->bindValue(':faculty_id', $section[0]['prof_id']);
$statement->execute();
$faculty_get = $statement->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($faculty);
// echo '<pre>';

$statement = $pdo->prepare('SELECT * FROM subject where rnd_id = :rnd_id');
$statement->bindValue(':rnd_id', $rnd_id);
$statement->execute();
$subject = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $subject_name = $subject[0]['subject_name'];
    $subject_id = $subject[0]['rnd_id'];
    $section_name = $section[0]['section_name'];
    $section_id = $section[0]['section_id'];
    $semester = $subject[0]['semester'];
    $yearlevel = $subject[0]['yearlevel'];
    $prof_id = $faculty_get[0]['id'];
    $prof_name = ucfirst($faculty_get[0]['first_name']) . " " . ucfirst($faculty_get[0]['last_name']);
    $grading_period = $_POST['grading_period'];
    $multiplechoice = $_POST['multiplechoice'];
    $identification = $_POST['identification'];
    $matching = $_POST['matching'];
    $trueorfalse = $_POST['trueorfalse'];
    // $unique_id = randomString(8, 2);

    if (empty($errors)) {

        $statement = $pdo->prepare("INSERT INTO examcreated (subject, subject_id, section_name, section_id, grading_period, yearlevel, semester, prof_name, prof_id, multiplechoice, identification, matching, trueorfalse, status)
              VALUES (:subject, :subject_id, :section_name, :section_id, :grading_period, :yearlevel, :semester, :prof_name, :prof_id, :multiplechoice, :identification, :matching, :trueorfalse, :status)");

        $statement->bindValue(':subject', $subject_name);
        $statement->bindValue(':subject_id', $subject_id);
        $statement->bindValue(':section_name', $section_name);
        $statement->bindValue(':section_id', $section_id);
        $statement->bindValue(':grading_period', $grading_period);
        $statement->bindValue(':yearlevel', $yearlevel);
        $statement->bindValue(':semester', $semester);
        $statement->bindValue(':prof_name', $prof_name);
        $statement->bindValue(':prof_id', $prof_id);
        $statement->bindValue(':multiplechoice', $multiplechoice);
        $statement->bindValue(':identification', $identification);
        $statement->bindValue(':matching', $matching);
        $statement->bindValue(':trueorfalse', $trueorfalse);
        $statement->bindValue(':status', $status);
        $statement->execute();
        header('Location:list.php');
    }

}

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>EXAMINATION SYSTEM - CCS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <link href="../../assets/css/main.css" rel="stylesheet" />
    <link href="../../assets/css/animate.css" rel="stylesheet"/>
    <link href="../../assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="../../assets/css/demo.css" rel="stylesheet" />


    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../../assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="success">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="" class="simple-text">
                    Admin Dashboard
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="../">
                        <p>Main Menu</p>
                    </a>
                </li>
                <li>
                    <a href="../questions/">
                        <p>Questions</p>
                    </a>
                </li>
                <li  class="active">
                    <a href="index.php">
                        <p>Exam</p>
                    </a>
                </li>
                <li>
                    <a href="../class/">
                        <p>Subject</p>
                    </a>
                </li>
                <li>
                    <a href="../generate/">
                        <p>Reports</p>
                    </a>
                </li>
                <li>
                    <a href="../user/">
                        <p>Users</p>
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
                    <a class="navbar-brand" href="#"></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="../profile.php">
                                <i class="ti-panel"></i>
								<p>Profile</p>
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
                            <a href="../../logout">
								<p>Logout</p>
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
                        <div class="card">
                            <div class="header">
                                <div class="header-arrangement">
                                    <div class="right">
                                        <h4 class="text-center">Create Exam</h4>
                                    </div>
                                    <div class="left">
                                        <a href="section.php?id=<?php echo $rnd_id; ?>" class="btn btn-info btn-fill btn-wd">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="content">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Section</label>
                                                    <input type="text" name="subject" class="form-control border-input" placeholder="" value="<?php echo $section[0]['section_name']; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Number of Identification</label>
                                                    <input type="number" min="1" max="<?php echo $identi; ?>" name="identification" class="form-control border-input" placeholder="Number of Identification" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Number of Multiple Choice</label>
                                                    <input type="number" min="1" max="<?php echo $multi; ?>" name="multiplechoice" class="form-control border-input" placeholder="Number of Multiple Choice" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Number of Matching Type</label>
                                                    <input type="number" min="0" name="matching" class="form-control border-input" placeholder="Number of Matching Type" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Number of True or False</label>
                                                    <input type="number" min="0" max="<?php echo $torf; ?>" name="trueorfalse" class="form-control border-input" placeholder="Number of True or False" value="" required>
                                             </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Grading Period</label>
                                                    <select name="grading_period" class="form-control border-input" required>
                                                        <option value="" selected>-</option>
                                                        <option value="Prelim">Prelim</option>
                                                        <option value="Midterm">Midterm</option>
                                                        <option value="Finals">Finals</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="create" class="btn btn-info btn-fill btn-wd" style="font-size:2rem;">Create</button>
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

    <script src="../../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../../assets/js/main.js" type="text/javascript"></script>
	<script src="../../assets/js/main-checkbox-radio.js"></script>
	<script src="../../assets/js/chartist.min.js"></script>
    <script src="../../assets/js/main-notify.js"></script>
	<script src="../../assets/js/paper-dashboard.js"></script>


	<script src="../../assets/js/demo.js"></script>
</html>
