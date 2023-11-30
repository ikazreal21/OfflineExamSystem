<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

if ($_SESSION["usertype"] != "faculty") {
    header('location:../others/validation.php');
}

$sec = $_GET['id'] ?? '';
$rnd_id = $_GET['rnd_id'] ?? '';
$grading = $_GET['grade_per'] ?? '';

$available_exam = [];

$statement = $pdo->prepare('SELECT * FROM section where section_id = :section_id');
$statement->bindValue(':section_id', $sec);
$statement->execute();
$section = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT s.*, (select e.prof_name from section e where e.section_id = s.section_id) as prof_name FROM exam_take s where section_id = :section_id and grading_per = :grade_per');
$statement->bindValue(':section_id', $sec);
$statement->bindValue(':grade_per', $grading);
$statement->execute();
$procdata1 = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM enrolled_student WHERE subject_id  = :subject_id and section_id = :section_id');
$statement->bindValue(':section_id', $sec);
$statement->bindValue(':subject_id', $rnd_id);
$statement->execute();
$procdata2 = $statement->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($procdata1);
// echo '<pre>';


$procdata = [];

foreach ($procdata2 as $i => $products) {
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE student_id = :student_id');
    $statement->bindValue(':student_id', $products["student_id"]);
    $statement->execute();
    $procdatas = $statement->fetchAll(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // var_dump($procdatas);
    // echo '<pre>';

    $procdata[] = $procdatas[0];

}
    // echo '<pre>';
    // var_dump($procdata);
    // echo '<pre>';

array_multisort(array_column($procdata, 'last_name'), $procdata);

    // echo '<pre>';
    // var_dump($procdata);
    // echo '<pre>';

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
                    <?php echo ucfirst($_SESSION["first_name"]); ?> Dashboard
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
                <li>
                    <a href="../exams/">
                        <p>Exam</p>
                    </a>
                </li>
                <li >
                    <a href="../subjects/">
                        <p>Subjects</p>
                    </a>
                </li>
                <li class="active">
                    <a href="">
                        <p>Results</p>
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
                            <a href="../../logout.php">
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
                                <div class="header-arrangement">
                                    <div class="right">
                                        <h4 class="title">Result of Exam | <?php echo $section[0]['section_name']; ?></h4>
                                    </div>
                                    <div class="left">
                                        <?php if ($procdata1): ?>
                                        <a href="download.php?id=<?php echo $sec; ?>&rnd_id=<?php echo $rnd_id; ?>&grade_per=<?php echo $grading; ?>" class="btn btn-info btn-fill btn-wd">Export Data</a>
                                        <?php endif; ?>
                                        <a href="list.php?id=<?php echo $rnd_id; ?>" class="btn btn-info btn-fill btn-wd">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <thead>
                                    	<th>Student Name</th>
                                    	<th>Subject Name</th>
                                    	<th>Section Name</th>
                                    	<th>Professor's Name</th>
                                    	<th>Number of Items</th>
                                    	<th>Score</th>
                                    	<th>Percentage Score</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($procdata as $i => $item): ?>
                                        <tr>
                                        	<td style="font-size:medium;"><b><?php echo ucfirst($item['last_name']) . ", " . ucfirst($item['first_name']) ?></b></td>

                                            <?php
                                             $statement = $pdo->prepare('SELECT * FROM section where section_id = :section_id');
                                             $statement->bindValue(':section_id', $sec);
                                             $statement->execute();
                                             $section = $statement->fetchAll(PDO::FETCH_ASSOC);
                                             
                                             $statement = $pdo->prepare('SELECT s.*, (select e.prof_name from section e where e.section_id = s.section_id) as prof_name FROM exam_take s where section_id = :section_id and student_id = :student_id and grading_per = :grade_per');
                                             $statement->bindValue(':section_id', $sec);
                                             $statement->bindValue(':student_id', $item['student_id']);
                                             $statement->bindValue(':grade_per', $grading);
                                             $statement->execute();
                                             $procdata1 = $statement->fetchAll(PDO::FETCH_ASSOC);

                                                // echo '<pre>';
                                                // var_dump($procdata1);
                                                // echo '<pre>';

                                            ?>
                                            <?php if ($procdata1): ?>
                                        	<td style="font-size:medium;"><b><?php echo $procdata1[0]['subject']; ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo $procdata1[0]['section_name']; ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo ucfirst($procdata1[0]['prof_name']); ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo $procdata1[0]['out_of']; ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo $procdata1[0]['score']; ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo $procdata1[0]['score']/$procdata1[0]['out_of']*100; ?>%</b></td>
                                            <?php else: ?>
                                            <td style="font-size:medium;"><b>~</b></td>
                                        	<td style="font-size:medium;"><b>~</b></td>
                                        	<td style="font-size:medium;"><b>~</b></td>
                                        	<td style="font-size:medium;"><b>~</b></td>
                                        	<td style="font-size:medium;"><b>~</b></td>
                                        	<td style="font-size:medium;"><b>~%</b></td>
                                            <?php endif; ?>
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
                <!-- -->
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
