<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'err':
            echo "<script>alert('Password are not the same as Confirm Password');</script>";
            break;
        default:
    }
}

// $subject = '';
// $semester = '';
// $yearlevel = '';
// $unique_id = '';
// // $prof_id = '';
// // $prof_name = '';

// $statement = $pdo->prepare('SELECT * FROM accounts WHERE role = "faculty" ');
// $statement->execute();
// $procdata1 = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['password'] == $_POST['confirm_password']) {
        if (empty($errors)) {

            $statement = $pdo->prepare("UPDATE accounts set password = :password WHERE id = :id");
            $statement->bindValue(':password', $_POST['password']);
            $statement->bindValue(':id', $id);
            $statement->execute();

            header('Location:index.php');
        }
    } else {
        $qstring = '?status=err&id=' . $id;
        header("Location: edit.php" . $qstring);
    }

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
                <li class="active">
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
                                        <h4 class="text-center">Change Password</h4>
                                    </div>
                                    <div class="left">
                                        <a href="index.php" class="btn btn-info btn-fill btn-wd">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="content">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="text" name="password" class="form-control border-input" placeholder="New Password" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="text" name="confirm_password" class="form-control border-input" placeholder="Confirm Password" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="create" class="btn btn-info btn-fill btn-wd" style="font-size:2rem;">Change Password</button>
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

    <script src="../../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../../assets/js/main.js" type="text/javascript"></script>
	<script src="../../assets/js/main-checkbox-radio.js"></script>
	<script src="../../assets/js/chartist.min.js"></script>
    <script src="../../assets/js/main-notify.js"></script>
	<script src="../../assets/js/paper-dashboard.js"></script>


	<script src="../../assets/js/demo.js"></script>
</html>
