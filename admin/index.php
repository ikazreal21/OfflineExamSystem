<?php
session_start();

require_once "../dbconnect.php";

if ($_SESSION["usertype"] != "admin") {
    header('location:../others/validation.php');
}

$statement = $pdo->prepare('SELECT * FROM examcreated where status = "open" ');
$statement->execute();
$openexam = $statement->rowCount();

$statement = $pdo->prepare('SELECT s.*, (select count(*) from enrolled_student e where e.subject_id = s.rnd_id) as number_of_stud,
(select count(*) from prof_subjects p where p.subject_id = s.rnd_id) as number_of_prof FROM subject s');
$statement->execute();
$subject = $statement->rowCount();

$statement = $pdo->prepare('SELECT * FROM accounts WHERE role = "faculty"');
$statement->execute();
$faculty = $statement->rowCount();

$statement = $pdo->prepare('SELECT * FROM accounts WHERE role = "student"');
$statement->execute();
$student = $statement->rowCount();

?>




<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/image/logo.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>EXAMINATION SYSTEM - CCS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <link href="../assets/css/main.css" rel="stylesheet" />
    <link href="../assets/css/animate.css" rel="stylesheet"/>
    <link href="../assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <link href="../assets/css/mes.css" rel="stylesheet" />


    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

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
                <li  class="active">
                    <a href="">
                        <p>Main Menu</p>
                    </a>
                </li>
                <li>
                    <a href="questions/">
                        <p>Questions</p>
                    </a>
                </li>
                <li>
                    <a href="exams/">
                        <p>Exam</p>
                    </a>
                </li>
                <li>
                    <a href="class/">
                        <p>Subject</p>
                    </a>
                </li>
                <!--
                <li>
                    <a href="generate/">
                        <p>Reports</p>
                    </a>
                </li>
                -->
                <li>
                    <a href="user/">
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
                    <a class="navbar-brand" href="#">EXAMINATION SYSTEM - CCS</a>
                    <?php
                        if (isset($_SESSION["message"])) {
                            
                            echo '  <div id="mes">' . $_SESSION["message"] . '</div>';
                            unset($_SESSION["message"]);
                        }
                    ?>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="profile.php">
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
                            <a href="../logout.php">
								<p>Logout</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content" >
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-comment"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Open Exam</p>
                                            <?php echo $openexam; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-reload"></i> Exam that are Open
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-book"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Subjects</p>
                                            <?php echo $subject; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-book"></i> Available Subjects
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Faculty</p>
                                            <?php echo $faculty; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-user"></i> Available Faculty
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Student</p>
                                            <?php echo $student; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-pencil"></i> Available Student
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Exam Statistics</h4>
                            </div>
                            <div class="content" style="text-align: center">
                                <dl>
                                    <dd class="percentage percentage-11"><span class="text">Test 1: 11.33%</span></dd>
                                    <dd class="percentage percentage-49"><span class="text">Test 2: 49.77%</span></dd>
                                    <dd class="percentage percentage-16"><span class="text">Test 3: 16.09%</span></dd>
                                    <dd class="percentage percentage-5"><span class="text">Test 4: 5.41%</span></dd>
                                    <dd class="percentage percentage-2"><span class="text">Test 5: 1.62%</span></dd>
                                    <dd class="percentage percentage-2"><span class="text">Test 6: 4.4: 2%</span></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div> -->
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

    <script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../assets/js/main.js" type="text/javascript"></script>
	<script src="../assets/js/main-checkbox-radio.js"></script>
	<script src="../assets/js/chartist.min.js"></script>
    <script src="../assets/js/main-notify.js"></script>
	<script src="../assets/js/paper-dashboard.js"></script>
	<script src="../assets/js/mes.js"></script>


	<script src="../assets/js/demo.js"></script>
</html>
