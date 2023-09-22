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


    <link href="assets/css/main.css" rel="stylesheet" />
    <link href="assets/css/animate.css" rel="stylesheet"/>
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="assets/css/demo.css" rel="stylesheet" />


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
                    About
                </a>
            </div>

            <ul class="nav">
                <li >
                    <a href="login.php">
                        <p>Login</p>
                    </a>
                </li>
                <li class="active">
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
                                <h4 class="text-center">About Us</h4>
                            </div>
                            <div class="container">
                                <div class="content">
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
