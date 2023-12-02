<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

$username = '';
$password = '';
$email = '';
$role = '';
$first_name = '';
$last_name = '';
$student_id = '';
$yearlevel = '';
$status = 'active';

// $statement = $pdo->prepare('SELECT * FROM accounts WHERE role = "faculty" ');
// $statement->execute();
// $procdata1 = $statement->fetchAll(PDO::FETCH_ASSOC);
$search1 = $_GET['search1'] ?? '';

if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'err':
            echo "<script>alert('Password are not the same as Confirm Password');</script>";
            break;
        case 'err2':
            echo "<script>alert('Username is Unavailable');</script>";
            break;
        default:
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo '<pre>';
    // var_dump($_POST);
    // echo '<pre>';

    
    if (strval($_POST['password']) != strval($_POST['confirm_password'])) {
        $qstring = '?status=dup1';
    }


    $statement = $pdo->prepare("SELECT * FROM accounts WHERE username = :username and role = 'student'");
    $statement->bindValue(':username', strval($_POST['username']));
    $statement->execute();
    $count = $statement->rowCount();

    // echo '<pre>';
    // var_dump($count);
    // echo '<pre>';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $search1;
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $student_id = $_POST['student_id'];
    $yearlevel = $_POST['yearlevel'];

    if ($count == 0) {

        $statement = $pdo->prepare("INSERT INTO accounts (username, password, role, email, first_name, last_name, student_id, status, yearlevel)
              VALUES (:username, :password, :role, :email, :first_name, :last_name, :student_id, :status, :yearlevel)");

        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':role', $search1);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':student_id', $student_id);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':yearlevel', $yearlevel);
        $statement->execute();
        // header('Location:index.php');
    } else {
        $qstring = '?status=dup2';
    }
    header("Location:index.php". $qstring);
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
                <!--
                <li>
                    <a href="../generate/">
                        <p>Reports</p>
                    </a>
                </li>
                -->
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
                                        <h4 class="text-center">Create User</h4>
                                    </div>
                                    <div class="left">
                                        <a href="index.php" class="btn btn-info btn-fill btn-wd">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="content">
                                    <form method="post">
                                        <!-- <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <select name="role" class="form-control border-input">
                                                        <option value="" selected>Role</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="faculty">Faculty</option>
                                                        <option value="student">Student</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>User Name</label>
                                                    <input type="text" name="username" class="form-control border-input" placeholder="Username" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" name="password" class="form-control border-input" placeholder="Password" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" name="confirm_password" class="form-control border-input" placeholder="Confirm" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" name="email" class="form-control border-input" placeholder="Email" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" name="first_name" class="form-control border-input" placeholder="First Name" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" name="last_name" class="form-control border-input" placeholder="Last Name" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($search1 == 'student'): ?>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Student ID / Employee ID</label>
                                                    <input type="text" name="student_id" class="form-control border-input" placeholder="Student ID / Employee ID" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Year Level (only for students)</label>
                                                    <select name="yearlevel" class="form-control border-input">
                                                        <option value="" selected>Year Level</option>
														<option value="N/A">N/A</option>
                                                        <option value="1st">1st</option>
                                                        <option value="2nd">2nd</option>
                                                        <option value="3rd">3rd</option>
                                                        <option value="4th">4th</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
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
