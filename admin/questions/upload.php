<?php
session_start();

require_once "../../dbconnect.php";
require_once "../../others/function.php";
require_once '../../vendor/autoload.php';
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$rnd_id = $_GET['id'] ?? '';
$faculty = [];

// echo '<pre>';
// var_dump($faculty);
// echo '<pre>';

$statement = $pdo->prepare('SELECT * FROM subject where rnd_id = :rnd_id');
$statement->bindValue(':rnd_id', $rnd_id);
$statement->execute();
$subject = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT * FROM prof_subjects WHERE subject_id = :rnd_id ');
$statement->bindValue(':rnd_id', $rnd_id);
$statement->execute();
$faculty_id = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($faculty_id as $i => $facul) {
    $statement = $pdo->prepare('SELECT * FROM accounts WHERE id = :faculty_id ');
    $statement->bindValue(':faculty_id', $facul['prof_id']);
    $statement->execute();
    $faculty_get = $statement->fetchAll(PDO::FETCH_ASSOC);

    $faculty[] = $faculty_get[0];

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $statement = $pdo->prepare('SELECT * FROM accounts WHERE id = :faculty_id ');
    $statement->bindValue(':faculty_id', $_POST['prof_id']);
    $statement->execute();
    $prof_details = $statement->fetchAll(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // var_dump($_POST['question_type']);
    // echo '<pre>';

    $excelMimes = array('text/xls', 'text/xlsx', 'text/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    // echo '<pre>';
    // var_dump($_FILES['file']['type']);
    // echo '<pre>';

    // $statement = $pdo->prepare('SELECT * FROM accounts where id = :prof_id');
    // $statement->bindValue(':prof_id', $_POST['prof_id']);
    // $statement->execute();
    // $prof_details = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Validate whether selected file is a Excel file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)) {

        // echo 'test';
        // var_dump($row);
        // echo '<pre>';
        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            if ($_FILES['file']['type'] == 'text/csv') {
                $reader = new Csv();
                $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            } else {
                $reader = new Xlsx();
                $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            }

            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet_arr = $worksheet->toArray();

            // Remove header row
            unset($worksheet_arr[0]);

            if ($_POST['question_type'] == 'multiplechoice') {
                foreach ($worksheet_arr as $row) {

                    // echo '<pre>';
                    // var_dump($row);
                    // echo '<pre>';

                    $subject_name = $row[0];
                    $question = $row[1];
                    $choice1 = $row[2];
                    $choice2 = $row[3];
                    $choice3 = $row[4];
                    $choice4 = $row[5];
                    $choice5 = $row[6];
                    $answer = $row[7];
                    $prof_name = $row[8];

                    // Check whether member already exists in the database with the same email
                    $statement = $pdo->prepare("SELECT * FROM multiplechoice WHERE question = :question");
                    $statement->bindValue(':question', $question);
                    $statement->execute();
                    $count = $statement->rowCount();

                    // echo $count;

                    if ($count == 0) {

                        // echo 'here';

                        $statement = $pdo->prepare("INSERT INTO multiplechoice (subject, subject_id, question, A, B, C, D, E, answer, yearlevel, grading_period, semester, profname, prof_id) VALUES (:subject, :subject_id, :question, :c1, :c2, :c3, :c4, :c5, :answer, :yearlevel, :grading_period, :semester, :profname, :prof_id)");
                        $statement->bindValue(':subject', $subject_name);
                        $statement->bindValue(':subject_id', $subject[0]['rnd_id']);
                        $statement->bindValue(':question', $question);
                        $statement->bindValue(':c1', $choice1);
                        $statement->bindValue(':c2', $choice2);
                        $statement->bindValue(':c3', $choice3);
                        $statement->bindValue(':c4', $choice4);
                        $statement->bindValue(':c5', $choice5);
                        $statement->bindValue(':answer', $answer);
                        $statement->bindValue(':yearlevel', $subject[0]['yearlevel']);
                        $statement->bindValue(':grading_period', $_POST['grading_period']);
                        $statement->bindValue(':semester', $subject[0]['semester']);
                        $statement->bindValue(':profname', $prof_name);
                        $statement->bindValue(':prof_id', $prof_details[0]['id']);
                        $statement->execute();
                    }
                    $qstring = '?status=succ';

                }
                header("Location: index.php" . $qstring);
            } elseif ($_POST['question_type'] == 'identification') {
                foreach ($worksheet_arr as $row) {

                    // echo '<pre>';
                    // var_dump($row);
                    // echo '<pre>';

                    $subject_name = $row[0];
                    $question = $row[1];
                    $answer = $row[2];
                    $prof_name = $row[8];

                    // Check whether member already exists in the database with the same email
                    $statement = $pdo->prepare("SELECT * FROM identification WHERE question = :question");
                    $statement->bindValue(':question', $question);
                    $statement->execute();
                    $count = $statement->rowCount();

                    // echo $count;

                    if ($count == 0) {

                        // echo 'here';

                        $statement = $pdo->prepare("INSERT INTO identification (subject, subject_id, question, answer, yearlevel, grading_period, semester, prof_name, prof_id) VALUES (:subject, :subject_id, :question, :answer, :yearlevel, :grading_period, :semester, :profname, :prof_id)");
                        $statement->bindValue(':subject', $subject_name);
                        $statement->bindValue(':subject_id', $subject[0]['rnd_id']);
                        $statement->bindValue(':question', $question);
                        $statement->bindValue(':answer', $answer);
                        $statement->bindValue(':yearlevel', $subject[0]['yearlevel']);
                        $statement->bindValue(':grading_period', $_POST['grading_period']);
                        $statement->bindValue(':semester', $subject[0]['semester']);
                        $statement->bindValue(':profname', $prof_name);
                        $statement->bindValue(':prof_id', $prof_details[0]['id']);
                        $statement->execute();
                    }
                    $qstring = '?status=succ';

                }
                header("Location: index.php" . $qstring);

            } elseif ($_POST['question_type'] == 'trueorfalse') {
                foreach ($worksheet_arr as $row) {

                    // echo '<pre>';
                    // var_dump($row);
                    // echo '<pre>';

                    $subject_name = $row[0];
                    $question = $row[1];
                    $answer = $row[2];
                    $prof_name = $row[8];

                    // Check whether member already exists in the database with the same email
                    $statement = $pdo->prepare("SELECT * FROM trueorfalse WHERE question = :question");
                    $statement->bindValue(':question', $question);
                    $statement->execute();
                    $count = $statement->rowCount();

                    // echo $count;

                    if ($count == 0) {

                        // echo 'here';
                        $statement = $pdo->prepare("INSERT INTO trueorfalse (question, answer, subject, subject_id, yearlevel, grading_period, semester, prof_name, prof_id) VALUES (:question, :answer, :subject, :subject_id, :yearlevel, :grading_period, :semester, :profname, :prof_id)");
                        $statement->bindValue(':question', $question);
                        $statement->bindValue(':answer', $answer);
                        $statement->bindValue(':subject', $subject_name);
                        $statement->bindValue(':subject_id', $subject[0]['rnd_id']);
                        $statement->bindValue(':yearlevel', $subject[0]['yearlevel']);
                        $statement->bindValue(':grading_period', $_POST['grading_period']);
                        $statement->bindValue(':semester', $subject[0]['semester']);
                        $statement->bindValue(':profname', $prof_name);
                        $statement->bindValue(':prof_id', $prof_details[0]['id']);
                        $statement->execute();
                    }
                    $qstring = '?status=succ';

                }
                header("Location: index.php" . $qstring);

            } elseif ($_POST['question_type'] == 'matchingtype') {
                foreach ($worksheet_arr as $row) {

                    // echo '<pre>';
                    // var_dump($row);
                    // echo '<pre>';

                    $subject_name = $row[0];
                    $question = $row[1];
                    $answer = $row[2];
                    $prof_name = $row[8];

                    // Check whether member already exists in the database with the same email
                    $statement = $pdo->prepare("SELECT * FROM matchingtype WHERE question = :question");
                    $statement->bindValue(':question', $question);
                    $statement->execute();
                    $count = $statement->rowCount();

                    // echo $count;

                    if ($count == 0) {

                        // echo 'here';
                        $statement = $pdo->prepare("INSERT INTO matchingtype (question, answer, subject, subject_id, yearlevel, grading_period, semester, prof_name, prof_id) VALUES (:question, :answer, :subject, :subject_id, :yearlevel, :grading_period, :semester, :profname, :prof_id)");
                        $statement->bindValue(':question', $question);
                        $statement->bindValue(':answer', $answer);
                        $statement->bindValue(':subject', $subject_name);
                        $statement->bindValue(':subject_id', $subject[0]['rnd_id']);
                        $statement->bindValue(':yearlevel', $subject[0]['yearlevel']);
                        $statement->bindValue(':grading_period', $_POST['grading_period']);
                        $statement->bindValue(':semester', $subject[0]['semester']);
                        $statement->bindValue(':profname', $prof_name);
                        $statement->bindValue(':prof_id', $prof_details[0]['id']);
                        $statement->execute();
                    }
                    $qstring = '?status=succ';

                }
                header("Location: index.php" . $qstring);

            }

            $qstring = '?status=succ';
        } else {
            $qstring = '?status=err';
        }
    } else {
        $qstring = '?status=invalid_file';
    }

    header("Location: index.php" . $qstring);

}

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
                                        <h4 class="text-center">Upload Exam</h4>
                                    </div>
                                    <div class="left">
                                        <a href="list.php" class="btn btn-info btn-fill btn-wd">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="content">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <input type="text" min="0" name="subject" class="form-control border-input" placeholder="" value="<?php echo $subject[0]['subject_name']; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Professor</label>
                                                    <select name="prof_id" class="form-control border-input" required>
                                                        <option value="" selected>-</option>
                                                        <?php foreach ($faculty as $i => $item): ?>
                                                        <option value="<?php echo $item['id']; ?>"><?php echo ucfirst($item['first_name']); ?> <?php echo ucfirst($item['last_name']); ?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Grading Period</label>
                                                    <select name="grading_period" class="form-control border-input" required>
                                                        <option value="" selected>-</option>
                                                        <option value="Prelim">Prelim</option>
                                                        <option value="Midterm">Midterm</option>
                                                        <option value="Finals">Finals</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Type of Question</label>
                                                    <select name="question_type" class="form-control border-input" required>
                                                        <option value="multiplechoice" selected>Multiple Choice</option>
                                                        <option value="identification">Identification</option>
                                                        <option value="trueorfalse">True or False</option>
                                                        <option value="matchingtype">Matching Type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <div class="form-group">
                                                    <label>Upload File</label>
                                                    <input type="file" class="form-control border-input" name="file" id="fileInput" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="upload" class="btn btn-info btn-fill btn-wd" style="font-size:2rem;">Upload</button>
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
