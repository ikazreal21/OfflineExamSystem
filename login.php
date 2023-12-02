<?php
session_start();

if (isset($_SESSION["message"])) {
    echo $_SESSION["message"];
    unset($_SESSION["message"]); 
}

require_once 'dbconnect.php';
// require_once 'others/validation.php';

if (isset($_SESSION["usertype"])) {
    header('location:others/validation.php');
}

try {
    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<div class="error-message">All fields are required</div>';
        } else {
            $query = "SELECT * FROM accounts WHERE username = :username AND password = :password and status = 'active'";
            $statement = $pdo->prepare($query);
            $statement->execute(
                array(
                    'username' => $_POST["username"],
                    'password' => $_POST["password"],
                )
            );
            $count = $statement->rowCount();
            $user = $statement->fetchAll(PDO::FETCH_ASSOC);

            $procdata = [];




            // echo '<pre>';
            // var_dump($user[0]);
            // echo '<pre>';

            if ($count > 0) {
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["email"] = $user[0]["email"];
                $_SESSION["usertype"] = $user[0]["role"];
                if ($user[0]["role"] == "faculty") {
                    $statement = $pdo->prepare('SELECT * FROM prof_subjects WHERE prof_id = :prof_id');
                    $statement->bindValue(':prof_id', $user[0]["id"]);
                    $statement->execute();
                    $procdatas = $statement->fetchAll(PDO::FETCH_ASSOC);
                    
                    $_SESSION["data"] = $procdatas;

                    foreach ($procdatas as $row) {
                        if ($row['role'] == "main") {
                            $_SESSION["prof_role"] = "main";
                        } else {
                            $_SESSION["prof_role"] = "none";
                        }
                    }
                } else {
                    $_SESSION["prof_role"] = "none";
                }

                $_SESSION["first_name"] = $user[0]["first_name"];
                $_SESSION["last_name"] = $user[0]["last_name"];
                $_SESSION["id"] = $user[0]["id"];

                if ($user[0]["role"] == 'student') {
                    $_SESSION["student_id"] = $user[0]["student_id"];
                }

                $_SESSION["message"] = 'Login Successfully!';
                header('Location: others/validation.php');
            } else {
                $_SESSION["message"] = 'Wrong Credentials!';
            }
        }
    }
} catch (PDOException $error) {
    $message = '<div class="error-message">' . $error->getMessage() . '</div>';
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/image/logo.png">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>EXAMINATION SYSTEM - CCS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <link href="assets/css/main.css" rel="stylesheet" />
    <link href="assets/css/animate.css" rel="stylesheet"/>
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="assets/css/demo.css" rel="stylesheet" />
    <link href="assets/css/mes.css" rel="stylesheet" />


    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
	<script src="assets/js/demo.js"></script>

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="success">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="" class="simple-text">
                    Login
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="">
                        <p>Login</p>
                    </a>
                </li>
                <li>
                    <a href="about.php">
                        <p>About Us</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="">
                        <div class="card">
                            <div class="header">
                                <div class="logo-login" style="width:250px; margin:auto; display: flex; justify-content:space-around;">
                                    <img src="assets/image/CCS LOGO.png" width="100" height="100">
                                    <img src="assets/image/OLFU LOGO.png" width="100" height="100">
                                </div>
                                <h4 class="text-center">Our Lady of Fatima University Examination System</h4>
                            </div>
                            <div class="container">
                                <div class="content">
                                    <?php
                                        if (isset($_SESSION["message"])) {
                                            
                                            echo '  <div id="mes">' . $_SESSION["message"] . '</div>';
                                            unset($_SESSION["message"]);
                                        }
                                    ?>
                                    <form method="post" action="login.php">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" name="username" class="form-control border-input" placeholder="Username" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" name="password" class="form-control border-input" placeholder="Password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="login" class="btn btn-info btn-fill btn-wd">Login</button>
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

    </div>
</div>


</body>

    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/main.js" type="text/javascript"></script>
	<script src="assets/js/main-checkbox-radio.js"></script>
	<script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/main-notify.js"></script>
	<script src="assets/js/paper-dashboard.js"></script>
	<script src="assets/js/mes.js"></script>

    <script type="text/javascript">

    function showNotification (from, align, color, text) {
    	// color = Math.floor((Math.random() * 4) + 1);

    	$.notify({
        	message: text

        },{
            type: color,
            timer: 4000,
            placement: {
                from: from,
                align: align
            }
        });
	}
    </script>


</html>
