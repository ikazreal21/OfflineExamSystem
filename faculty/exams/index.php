<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

$search1 = $_GET['search1'] ?? '';
$search2 = $_GET['search2'] ?? '';

$statement = $pdo->prepare('SELECT * FROM prof_subjects WHERE prof_id = :prof_id and role = "main"');
$statement->bindValue(':prof_id', $_SESSION['id']);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($search1 && $search2) {
    $statement = $pdo->prepare('SELECT * FROM examcreated WHERE semester like :semester and yearlevel like :yearlevel and prof_id in (select prof_id from prof_subjects) ORDER BY exam_id DESC');
    $statement->bindValue(':semester', "%$search1%");
    $statement->bindValue(':yearlevel', "%$search2%");
} elseif ($search1 && empty($search2)) {
    $statement = $pdo->prepare('SELECT * FROM examcreated WHERE semester like :semester and prof_id in (select prof_id from prof_subjects) ORDER BY exam_id DESC');
    $statement->bindValue(':semester', "%$search1%");

} elseif ($search2 && empty($search1)) {
    $statement = $pdo->prepare('SELECT * FROM examcreated WHERE yearlevel like :yearlevel and prof_id in (select prof_id from prof_subjects) ORDER BY exam_id DESC');
    $statement->bindValue(':yearlevel', "%$search2%");

} else {
    $statement = $pdo->prepare('SELECT * FROM examcreated where prof_id in (select prof_id from prof_subjects) ORDER BY exam_id DESC');
}

$statement->execute();
$procdata = $statement->fetchAll(PDO::FETCH_ASSOC);

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
                <?php if ($_SESSION["prof_role"] == 'main'): ?>
                <li>
                    <a href="../questions/">
                        <p>Questions</p>
                    </a>
                </li>
                <li class="active">
                    <a href="../exams/">
                        <p>Exam</p>
                    </a>
                </li>
                <?php endif;?>
                <li>
                    <a href="../subjects/">
                        <p>Subjects</p>
                    </a>
                </li>
                <li>
                    <a href="../generate/">
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
                    <a class="navbar-brand" href="#">EXAMINATION SYSTEM - CCS</a>
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
                        <div class="card ">
                            <div class="header">
                                <div class="header-arrangement">
                                    <div class="right">
                                        <form action="" method="get">
                                            <div class="flex">
                                                <p><b>Filter</b></p>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <select name="search1" class="form-control" style="font-size: medium;">
                                                            <option value="" selected>Semester</option>
                                                            <option value="1st">1st</option>
                                                            <option value="2nd">2nd</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="search2" class="form-control" style="font-size: medium; margin-left:5rem;">
                                                            <option value="" selected>Year Level</option>
                                                            <option value="1st">1st</option>
                                                            <option value="2nd">2nd</option>
                                                            <option value="3rd">3rd</option>
                                                            <option value="4th">4th</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" name="search" class="btn btn-info btn-fill btn-wd" style="margin-left:5rem; margin-bottom:1rem;">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="left">
                                        <a href="list.php" class="btn btn-info btn-fill btn-wd">List of Subjects</a>
                                        <!-- <a href="create.php" class="btn btn-info btn-fill btn-wd">Create Subject</a> -->
                                    </div>
                                </div>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table">
                                    <thead>
                                    	<th>Subject Name</th>
                                    	<th>Section</th>
                                    	<th>Grading Period</th>
                                    	<th>Year Level</th>
                                    	<th>Semester</th>
                                    	<th>Professor's Name</th>
                                    	<th>Multiple Choice</th>
                                    	<th>Identification</th>
                                    	<th>Matching Type</th>
                                    	<th>True or False</th>
                                        <th>Timer</th>
                                    	<th>Status</th>
                                    	<th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($procdata as $i => $item): ?>
                                        <tr>
                                        	<td style="font-size:medium;"><b><?php echo $item['subject']; ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo $item['section_name']; ?></b></td>
                                        	<td style="font-size:medium;"><?php echo $item['grading_period']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['yearlevel']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['semester']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['prof_name']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['multiplechoice']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['identification']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['matching']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['trueorfalse']; ?></td>
                                            <td style="font-size:medium;"><?php echo $item['timer']; ?></td>
                                        	<td style="font-size:medium;"><?php echo strtoupper($item['status']); ?></td>
                                        	<td style="text-align:left;">
                                                <?php if ($item['status'] == 'close'): ?>
                                                    <a href="manual_open.php?id=<?php echo $item['exam_id']; ?>" class="btn btn-success btn-wd">Manual Open</a>
                                                <?php endif;?>
                                                <?php if ($item['status'] == 'open'): ?>
                                                    <a href="manual_close.php?id=<?php echo $item['exam_id']; ?>" class="btn btn-warning btn-wd">Manual Close</a>
                                                <?php endif;?>
                                                <a href="delete.php?id=<?php echo $item['exam_id']; ?>" onclick="return confirm('Are you sure you want to delete this Exam?')"  class="btn btn-danger btn-wd">Delete</a>
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

    <script src="../../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../../assets/js/main.js" type="text/javascript"></script>
	<script src="../../assets/js/main-checkbox-radio.js"></script>
	<script src="../../assets/js/chartist.min.js"></script>
    <script src="../../assets/js/main-notify.js"></script>
	<script src="../../assets/js/paper-dashboard.js"></script>


	<script src="../../assets/js/demo.js"></script>
</html>
