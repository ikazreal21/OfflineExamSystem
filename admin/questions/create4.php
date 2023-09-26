<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

$rnd_id = $_GET['id'] ?? '';

if (!$rnd_id) {
    header('Location: index.php');
    exit;
}

$subject_name = '';
$subject_id = '';
$grading_period = '';
$semester = '';
$yearlevel = '';
$prof_id = '';
$prof_name = '';
$difficulty = '';
$faculty = [];

// echo '<pre>';
// var_dump($faculty);
// echo '<pre>';

$statement = $pdo->prepare('SELECT * FROM subject where rnd_id = :rnd_id');
$statement->bindValue(':rnd_id', $rnd_id);
$statement->execute();
$subject = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM prof_subjects WHERE subject_id = :rnd_id ');
$statement->bindValue(':rnd_id', $rnd_id);
$statement->execute();
$faculty_id = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($faculty_id as $i => $facul) {
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE id = :faculty_id ');
    $statement->bindValue(':faculty_id', $facul['prof_id']);
    $statement->execute();
    $faculty_get = $statement->fetchAll(PDO::FETCH_ASSOC);

    $faculty[] = $faculty_get[0];

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $statement = $pdo->prepare('SELECT * FROM accounts where id = :prof_id');
    $statement->bindValue(':prof_id', $_POST['prof_id']);
    $statement->execute();
    $prof_details = $statement->fetchAll(PDO::FETCH_ASSOC);

    $subject_name = $subject[0]['subject_name'];
    $subject_id = $subject[0]['rnd_id'];
    $semester = $subject[0]['semester'];
    $yearlevel = $subject[0]['yearlevel'];
    $prof_id = $prof_details[0]['id'];
    $prof_name = ucfirst($prof_details[0]['first_name']) . " " . ucfirst($prof_details[0]['last_name']);
    $grading_period = $_POST['grading_period'];
    $difficulty = $_POST['difficulty'];

    $statement = $pdo->prepare("SELECT * FROM trueorfalse WHERE question = :question and subject_id = :subject_id");
    $statement->bindValue(':question', $_POST['question']);
    $statement->bindValue(':subject_id', $subject_id);
    $statement->execute();
    $count = $statement->rowCount();

    if ($count == 0) {

        $statement = $pdo->prepare("INSERT INTO trueorfalse (question, answer, subject, subject_id, yearlevel, grading_period, semester, prof_name, prof_id, difficulty) VALUES (:question, :answer, :subject, :subject_id, :yearlevel, :grading_period, :semester, :profname, :prof_id, :difficulty)");
        $statement->bindValue(':question', $_POST['question']);
        $statement->bindValue(':answer', $_POST['radio']);
        $statement->bindValue(':subject', $subject_name);
        $statement->bindValue(':subject_id', $subject_id);
        $statement->bindValue(':yearlevel', $yearlevel);
        $statement->bindValue(':grading_period', $_POST['grading_period']);
        $statement->bindValue(':semester', $semester);
        $statement->bindValue(':profname', $prof_name);
        $statement->bindValue(':prof_id', $prof_id);
        $statement->bindValue(':difficulty', $difficulty);
        $statement->execute();
        // echo '<pre>';
        // var_dump($_POST["radio"]);
        // echo '<pre>';

        header('Location:index.php?search1=trueorfalse');
    } else {
        header('Location:index.php?status=dup');
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
                    Admin Dashboard
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="../">
                        <p>Main Menu</p>
                    </a>
                </li>
                <li class="active">
                    <a href="">
                        <p>Questions</p>
                    </a>
                </li>
                <li>
                    <a href="../exams/">
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
                                        <a href="list.php" class="btn btn-info btn-fill btn-wd">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="content">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-md-auto">
                                                    <div class="form-group">
                                                        <label>Question</label>
                                                        <input type="text" min="0" name="question" class="form-control border-input" placeholder="" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                    <label class="containers">True
                                                        <input type="radio" name="radio"  value="True">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="containers">Flase
                                                        <input type="radio" name="radio" value="Flase">
                                                        <span class="checkmark"></span>
                                                    </label>
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
                                            <div class="row">
                                                <div class="col-md-auto">
                                                    <div class="form-group">
                                                        <label>Difficulty</label>
                                                        <select name="difficulty" class="form-control border-input" required>
                                                            <option value="easy" selected>Easy</option>
                                                            <option value="medium">Medium</option>
                                                            <option value="hard">Hard</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-auto">
                                                    <div class="form-group">
                                                        <label>Proctor</label>
                                                        <select name="prof_id" class="form-control border-input" required>
                                                            <option value="" selected>-</option>
                                                            <?php foreach ($faculty as $i => $item): ?>
                                                            <option value="<?php echo $item['id']; ?>"><?php echo ucfirst($item['first_name']); ?> <?php echo ucfirst($item['last_name']); ?></option>
                                                            <?php endforeach;?>
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
