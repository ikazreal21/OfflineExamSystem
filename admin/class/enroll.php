<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

$id = $_GET['rnd_id'] ?? null;
$sect_id = $_GET['id'] ?? null;
$search1 = '';

if (!$id && !$sect_id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM subject WHERE rnd_id = :id ');
$statement->bindValue(':id', $id);
$statement->execute();
$procdata1 = $statement->fetchAll(PDO::FETCH_ASSOC);

$yearlevel = $procdata1[0]["yearlevel"];
$subject = $procdata1[0]["subject_name"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['search1'] = $_POST['search1'];
    $search1 = $_SESSION['search1'];
}

if ($search1) {
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE role = "student" and first_name like :username or student_id like :student_id');
    $statement->bindValue(':username', "%$search1%");
    $statement->bindValue(':student_id', "%$search1%");
    $statement->execute();
    $count = $statement->rowCount();
    if ($count == 0) {
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE role = "student"');
    } else {
        $statement = $pdo->prepare('SELECT * FROM accounts WHERE role = "student" and first_name like :username or student_id like :student_id');
        $statement->bindValue(':username', "%$search1%");
        $statement->bindValue(':student_id', "%$search1%");
    }
} else {
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE role = "student"');
}


$statement->execute();
$procdata2 = $statement->fetchAll(PDO::FETCH_ASSOC);

$procdata = [];

foreach ($procdata2 as $i => $products) {
    $statement = $pdo->prepare('SELECT * FROM enrolled_student WHERE student_id = :student_id and subject_id = :subject_id and section_id = :section_id');
    $statement->bindValue(':student_id', $products["student_id"]);
    $statement->bindValue(':subject_id', $id);
    $statement->bindValue(':section_id', $sect_id);
    $statement->execute();
    $count = $statement->rowCount();

    // echo '<pre>';
    // var_dump($count);
    // echo '<pre>';

    if ($count == 0) {
        $procdata[] = $products;
    }

}

if (count($procdata) == 0) {
    header('Location: section.php?id=' . $id);
}

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
                <li>
                    <a href="../exams/">
                        <p>Exam</p>
                    </a>
                </li>
                <li  class="active">
                    <a href="index.php">
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
                        <div class="card ">
                            <div class="header">
                                <div class="header-arrangement">
                                    <div class="right">
                                        <form action="" method="post">
                                            <div class="flex">
                                                <h4 class="title"><b><?php echo $subject; ?></b></h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" name="search1" class="form-control border-input" placeholder="Username or Student Id" value="">
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="search" class="btn btn-info btn-fill btn-wd" style="margin-left:5rem; margin-top:.5rem; ">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="left">
                                        <a href="index.php" class="btn btn-info btn-fill btn-wd">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table">
                                    <thead>
                                        <th>Student ID</th>
                                    	<th>Student Name</th>
                                    	<th>Year Level</th>
                                    	<th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($procdata as $i => $item): ?>
                                        <tr>
                                        	<td style="font-size:medium;"><?php echo $item['student_id']; ?></td>
                                        	<td style="font-size:medium;"><b><?php echo ucfirst($item['first_name']); ?> <?php echo ucfirst($item['last_name']); ?></b></td>
                                        	<td style="font-size:medium;"><?php echo $item['yearlevel']; ?></td>
                                        	<td style="text-align:left;">
                                                <a href="add.php?id=<?php echo $id; ?>&student_id=<?php echo $item['student_id']; ?>&section_id=<?php echo $sect_id; ?>" class="btn btn-success btn-wd">Add</a>
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
