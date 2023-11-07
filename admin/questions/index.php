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
        case 'dup':
            echo "<script>alert('Duplicated Question');</script>";
            break;
        case 'invalid_file':
            echo "<script>alert('Invalid File');</script>";
            break;
        default:
    }
}

$search = $_GET['search1'] ?? 'multiplechoice';

$statement = $pdo->prepare("SELECT * FROM $search");
$statement->execute();
$procdata = $statement->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($_GET['search1']);
// echo '<pre>';

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
                                                            <?php if ($search == 'multiplechoice'): ?>
                                                            <option value="multiplechoice" selected>Multiple Choice</option>
                                                            <option value="identification">Identification</option>
                                                            <option value="trueorfalse">True or False</option>
                                                            <option value="matchingtype">Matching Type</option>
                                                            <?php endif;?>
                                                            <?php if ($search == 'identification'): ?>
                                                            <option value="multiplechoice">Multiple Choice</option>
                                                            <option value="identification" selected>Identification</option>
                                                            <option value="trueorfalse">True or False</option>
                                                            <option value="matchingtype">Matching Type</option>
                                                            <?php endif;?>
                                                            <?php if ($search == 'trueorfalse'): ?>
                                                            <option value="multiplechoice">Multiple Choice</option>
                                                            <option value="identification">Identification</option>
                                                            <option value="trueorfalse" selected>True or False</option>
                                                            <option value="matchingtype">Matching Type</option>
                                                            <?php endif;?>
                                                            <?php if ($search == 'matchingtype'): ?>
                                                            <option value="multiplechoice">Multiple Choice</option>
                                                            <option value="identification">Identification</option>
                                                            <option value="trueorfalse">True or False</option>
                                                            <option value="matchingtype" selected>Matching Type</option>
                                                            <?php endif;?>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-info btn-fill btn-wd" style="margin-left:5rem; margin-bottom:1rem;">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="left">
                                        <a href="list.php" class="btn btn-info btn-fill btn-wd">List of Subjects</a>
                                    </div>
                                </div>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <thead>
                                        <?php if ($search == 'multiplechoice'): ?>
                                    	<th>Subject Name</th>
                                    	<th>Question</th>
                                    	<th>Choice 1</th>
                                    	<th>Choice 2</th>
                                    	<th>Choice 3</th>
                                    	<th>Choice 4</th>
                                    	<th>Choice 5</th>
                                    	<th>Answer</th>
                                    	<th>Action</th>
                                        <?php endif;?>
                                        <?php if ($search == 'identification'): ?>
                                    	<th>Subject Name</th>
                                    	<th>Question</th>
                                    	<th>Answer</th>
                                    	<th>Action</th>
                                        <?php endif;?>
                                        <?php if ($search == 'trueorfalse'): ?>
                                    	<th>Subject Name</th>
                                    	<th>Question</th>
                                    	<th>Answer</th>
                                    	<th>Action</th>
                                        <?php endif;?>
                                        <?php if ($search == 'matchingtype'): ?>
                                    	<th>Subject Name</th>
                                    	<th>Question</th>
                                    	<th>Answer</th>
                                    	<th>Action</th>
                                        <?php endif;?>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($procdata as $i => $item): ?>
                                        <tr>
                                        	<td style="font-size:medium;"><b><?php echo $item['subject']; ?></b></td>
                                        	<td style="font-size:medium;"><b><?php echo $item['question']; ?></b></td>
                                            <?php if ($search == 'multiplechoice'): ?>
                                                <td style="font-size:medium;"><?php echo $item['A']; ?></td>
                                                <td style="font-size:medium;"><?php echo $item['B']; ?></td>
                                                <td style="font-size:medium;"><?php echo $item['C']; ?></td>
                                                <td style="font-size:medium;"><?php echo $item['D']; ?></td>
                                                <td style="font-size:medium;"><?php echo $item['E']; ?></td>
                                            <?php endif;?>
                                            <td style="font-size:medium;"><?php echo $item['answer']; ?></td>
                                        	<td style="text-align:left;">
                                                <?php if ($search == 'multiplechoice'): ?>
                                                    <!-- <a href="update.php?exammulti_id=<?php echo $item['exammulti_id']; ?>" class="btn btn-warning btn-wd">Edit Question</a> -->
                                                    <a href="delete.php?exammulti_id=<?php echo $item['exammulti_id']; ?>" class="btn btn-danger btn-wd">Delete</a>
                                                <?php endif;?>
                                                <?php if ($search == 'identification'): ?>
                                                    <!-- <a href="update.php?examiden_id=<?php echo $item['examiden_id']; ?>" class="btn btn-warning btn-wd">Edit Question</a> -->
                                                    <a href="delete.php?examiden_id=<?php echo $item['examiden_id']; ?>" class="btn btn-danger btn-wd">Delete</a>
                                                <?php endif;?>
                                                <?php if ($search == 'trueorfalse'): ?>
                                                    <!-- <a href="update.php?trueorfalse=<?php echo $item['trueorfalse']; ?>" class="btn btn-warning btn-wd">Edit Question</a> -->
                                                    <a href="delete.php?trueorfalse=<?php echo $item['trueorfalse']; ?>" class="btn btn-danger btn-wd">Delete</a>
                                                <?php endif;?>
                                                <?php if ($search == 'matchingtype'): ?>
                                                    <!-- <a href="update.php?matchingtype_id=<?php echo $item['matchingtype_id']; ?>" class="btn btn-warning btn-wd">Edit Question</a> -->
                                                    <a href="delete.php?matchingtype_id=<?php echo $item['matchtype_id']; ?>" class="btn btn-danger btn-wd">Delete</a>
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
