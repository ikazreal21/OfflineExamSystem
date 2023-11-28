<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";

if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'succ':
            echo "<script>alert('Upload Successfully');</script>";
            break;
        case 'err':
            echo "<script>alert('Error on Upload');</script>";
            break;
        case 'dup1':
            echo "<script>alert('Password Not Match');</script>";
            break;
        case 'dup2':
            echo "<script>alert('Username Unavailable');</script>";
            break;
        case 'invalid_file':
            echo "<script>alert('Invalid File');</script>";
            break;
        default:
    }
}

$search1 = $_GET['search1'] ?? '';

if ($search1) {
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE role like :role');
    $statement->bindValue(':role', "%$search1%");
} else {
    $statement = $pdo->prepare('SELECT * FROM accounts order by student_id asc');
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
                <li  class="active">
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
                                                            <option value="" selected>Select</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="faculty">Faculty</option>
                                                            <option value="student">Student</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit"  class="btn btn-info btn-fill btn-wd" style="margin-left:5rem; margin-bottom:1rem;">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="left">
                                        <a href="upload_user.php" class="btn btn-info btn-fill btn-wd">Upload Users</a>
                                        <a href="user_type.php" class="btn btn-info btn-fill btn-wd">Create User</a>
                                        <a href="mark_archive.php?search1=<?php echo $search1; ?>" class="btn btn-info btn-fill btn-wd">Archive User</a>
                                        <a href="mark_activate.php?search1=<?php echo $search1; ?>" class="btn btn-info btn-fill btn-wd">Unarchive User</a>
                                    </div>
                                </div>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table">
                                    <thead>
                                        <th>ID</th>
                                    	<th>Username</th>
                                    	<th>Email</th>
                                    	<th>First Name</th>
                                    	<th>Second Name</th>
                                    	<th>Student ID</th>
                                    	<th>Year Level</th>
                                    	<th>Status</th>
                                    	<th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($procdata as $i => $item): ?>
                                        <tr>
                                        	<td style="font-size:medium;"><?php echo $item['id']; ?></td>
                                        	<td style="font-size:medium;"><b><?php echo $item['username']; ?></b></td>
                                        	<td style="font-size:medium;"><?php echo $item['email']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['first_name']; ?></td>
                                        	<td style="font-size:medium;"><?php echo $item['last_name']; ?></td>
                                            <td style="font-size:medium;"><?php echo $item['student_id']; ?></td>
                                            <td style="font-size:medium;"><?php echo $item['yearlevel']; ?></td>
                                        	<td style="font-size:medium;"><?php echo strtoupper($item['status']); ?></td>
                                        	<td style="text-align:left;">
                                                <a href="edit.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-wd">Change Password</a>
                                                <?php if ($item['status'] == 'active'): ?>
                                                    <a href="remove.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-">Deactivate </a>
                                                <?php elseif ($item['status'] == 'deactivated'): ?>
                                                    <a href="activate.php?id=<?php echo $item['id']; ?>" class="btn btn-success btn-">Activate </a>
                                                <?php endif;?>
                                                <?php if ($item['role'] == 'faculty'): ?>
                                                    <a href="view_priv.php?id=<?php echo $item['id']; ?>" class="btn btn-primary btn-">Privilage </a>
                                                <?php endif;?>
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
