<?php 

require_once "../../dbconnect.php";
require_once "../../others/function.php";



$sec = $_GET['id'] ?? '';
$rnd_id = $_GET['rnd_id'] ?? '';

$statement = $pdo->prepare('SELECT s.*, (select e.prof_name from section e where e.section_id = s.section_id) as prof_name FROM exam_take s where section_id = :section_id');
$statement->bindValue(':section_id', $sec);
$statement->execute();
$procdata1 = $statement->fetchAll(PDO::FETCH_ASSOC);



$filename = $procdata1[0]["subject"]."_".date('Ymdhis') . ".xls";			
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

$firstrow=false;
foreach($procdata1 as $data)
{
    if(!$firstrow)
    {
        echo implode("\t",array_keys($data))."\n";
        $firstrow=true;
    }
    
    echo implode("\t",array_values($data))."\n";
    
}

exit;
	
?>