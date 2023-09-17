<?php 
session_start();


require_once "../dbconnect.php";
require_once "../others/function.php";

if($_SESSION["usertype"] !=  "student"){
    header('location:../others/validation.php');
}

$available_exam = [];

$statement = $pdo->prepare('SELECT e.* FROM examcreated e where e.subject_id in (select p.subject_id from enrolled_student p where p.student_id = :student_id) and status = "open" and e.exam_id not in (select x.exam_id from exam_take x where x.student_id = :student_id)');
$statement->bindValue(':student_id', $_SESSION["student_id"]);
$statement->bindValue(':student_id', $_SESSION["student_id"]);
$statement->execute();
$procdata = $statement->fetchAll(PDO::FETCH_ASSOC);



// foreach ($procdata as $i => $products) {
//     $statement = $pdo->prepare('SELECT * from examcreated where subject_id = :subject_id ');
//     $statement->bindValue(':subject_id', $products["rnd_id"]);
//     $statement->execute();
//     $exam = $statement->fetchAll(PDO::FETCH_ASSOC);

//     $available_exam[] = $exam[0];

// }


// echo '<pre>';
// var_dump($procdata);
// echo '<pre>';



 ?>




<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Olfu Offline Exam System</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <link href="../assets/css/main.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>
    <link href="../assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="../assets/css/demo.css" rel="stylesheet" />


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
                    <?php echo ucfirst($_SESSION["first_name"]);  ?> Dashboard
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="">
                        <p>Exam</p>
                    </a>
                </li>
                <li>
                    <a href="subjects/">
                        <p>Subjects</p>
                    </a>
                </li>
                <li>
                    <a href="examination/view_exam_results.php">
                        <p>Exam Results</p>
                    </a>
                </li>
                <!-- <li>
                    <a href="examination/">
                        <p>Exam</p>
                    </a>
                </li> -->
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
                    <!-- <a class="navbar-brand" href="#">Olfu Offline Exam System</a> -->
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


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="">
                        <div class="card ">
                        <div class="header">
                                <h4 class="title">Available Exam</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Subject Name</th>
                                    	<th>Grading Period</th>
                                    	<th>Number of Items</th>
                                    	<th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($procdata as $i => $item): ?>
                                        <tr>
                                        	<td style="font-size:medium;"><b><?php echo $item['subject']; ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo $item['grading_period']; ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo $item['multiplechoice'] + $item['identification'] + $item['matching'] + $item['trueorfalse']; ?></b></td>
                                            <td style="text-align:left;">
                                                <a href="examination/take_exam.php?id=<?php echo $item['exam_id']; ?>" class="btn btn-success btn-wd" onclick="return confirm('Are you sure to take this exam?')">Take Exam</a>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
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

    <script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../assets/js/main.js" type="text/javascript"></script>
	<script src="../assets/js/main-checkbox-radio.js"></script>
	<script src="../assets/js/chartist.min.js"></script>
    <script src="../assets/js/main-notify.js"></script>
	<script src="../assets/js/paper-dashboard.js"></script>


	<script src="../assets/js/demo.js"></script>
</html>
