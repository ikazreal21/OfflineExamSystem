<?php 
session_start();

if (!isset($_SESSION["exam_taken"])) {
    header("location:../");
}

// echo '<pre>';
// var_dump($_SESSION);
// echo '<pre>';
// if ($_SESSION["current_type"] == "multiplechoice") {
    
// }



if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (strtolower($_POST['radio']) == strtolower($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["answer"])) {
        $_SESSION["exam_taken"]["score"] = $_SESSION["exam_taken"]["score"] + 1;
        echo 'here';
    }
    if ($_SESSION["start_number_multiple"] < $_SESSION["current_exam_number"] - 1) {
        $_SESSION["start_number_multiple"] = $_SESSION["start_number_multiple"] + 1;
    } 
    else {
        $_SESSION["current_type"] = "identification";
        // echo '<pre>';
        // var_dump($_SESSION);
        // echo '<pre>';
        header("location:index.php?type=".$_SESSION["current_type"]);
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

	<title>Olfu Offline Exam System</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <link href="../../assets/css/main.css" rel="stylesheet" />
    <link href="../../assets/css/animate.min.css" rel="stylesheet"/>
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
                    <?php echo ucfirst($_SESSION["first_name"]);  ?> Dashboard
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="">
                        <p>Mutliple Choice</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <p>Identification</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <p>Matching Type</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <p>True or False</p>
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
                    <!-- <a class="navbar-brand" href="#">Olfu Offline Exam System</a> -->
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="">
                                <!-- <i class="ti-panel"></i> -->
								<!-- <p>Profile</p> -->
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
                            <a href="">
								<!-- <p>Logout</p> -->
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
                                        <h4><?php echo ucfirst($_SESSION["taken_exam"]["subject"]);  ?></h4>
                                    </div>
                                    <div class="left">
                                        <!-- <a href="../" class="btn btn-info btn-fill btn-wd">Back</a> -->
                                        <!-- <a href="create.php" class="btn btn-info btn-fill btn-wd">Create Subject</a> -->
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="content">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["question"]);  ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="">
                                                <div class="">
                                                    <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["A"]);  ?>
                                                        <input type="radio" name="radio"  value="A">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["B"]);  ?>
                                                        <input type="radio" name="radio" value="B">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["C"]);  ?>
                                                        <input type="radio" name="radio" value="C">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["D"]);  ?>
                                                        <input type="radio" name="radio" value="D">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="containers"><?php echo ucfirst($_SESSION["multiplechoice"][$_SESSION["start_number_multiple"]]["E"]);  ?>
                                                        <input type="radio" name="radio" value="E">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="exam" class="btn btn-info btn-fill btn-wd" style="font-size:2rem;">Next</button>
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
