<?php 
include_once 'conecction.php';

// $a = array(
//     1 => array(
//         'a' => 1,
//         'bb' => 2,
//         'c' => 3
//     ),
//     2 => array(
//         'a' => 4,
//         'b' => 5,
//         'z' => 6
//     ),
// );

// $b = array(
//     1 => array(
//         'a' => "1a",
//         'b' => "b2",
//         'c' => 3
//     ),
//     2 => array(
//         'a' => 1,
//         'b' => 2,
//         'c' => 32
//     )
// );

// $vi=array_shift($b);
// echo "<br>";
// print_r($b);
// echo "<br>";

// echo "<br>inicio de arrays con arrays internos<br>";
// echo "<br>inicio de arrays con arrays internos<br>";

// foreach ($a as $key => $value) {
//     # code...
//     print_r(implode("-", array_keys($value)));
//     echo "<br>";
//     echo "<br>";
//     print_r(implode(",", $value));
//     echo "<br> end <br>";
// }

// $c=serialize($a);
// $d=unserialize($c);
// echo "<br>serializar un array<br>";
// echo $c;
// echo "<br>deserializa un array<br>";
// print_r($d);

// // $clmn="id_log_error";
// // $tbl="snor_log_errores";
// // $codename="SELECT max($clmn) FROM $tbl";
// $codename=returnIdLast("snor_log_errores","id_log_error");
// echo "<br>",$codename,"<br>";
// $codename=returnIdLast('snor_docs','id_doc')+1;
// echo "<br>",$codename,"<br>";
// echo "<br>",$codename,"<br>";
// var_dump(file_exists("ImagesLog/14-9-11-2016--11!33!57"));
// echo "<br>",$codename,"<br>";
// var_dump(file_exists("0"));
// echo "<br>",$codename,"<br>";
// $heads = json_decode($_POST['head'], true);
// $arrays = json_decode($_POST['data'], true);
// $titles =json_decode($_POST['titles'], true);   
// foreach ($arrays as $row) {
//     # code...
//     print_r($row[4]);
//     echo "<hr>";
// }
// echo gettype($titles);
// echo gettype($arrays);

// function ChangeColumbyColumn($tbl,$id,$idValue,$clmnR)
// {
// 	$con=con();
// 	$query = $con->prepare("select $clmnR FROM $tbl where $id='$idValue'");
// 	$query->execute();
// 	//grab a result set
// 	$resultSet = $query->get_result();
// 	//pull all results as an associative array
// 	$result = $resultSet->fetch_all(MYSQLI_ASSOC);
// 	return $result[0][$clmnR];
	
	
// }
// function get_id($tbl,$clmnR)
// {
// 	$con=con();
// 	$query = $con->prepare("select * FROM $tbl order by $clmnR desc limit 1,1");
// 	$query->execute();
// 	//grab a result set
// 	$resultSet = $query->get_result();
// 	//pull all results as an associative array
// 	$result = $resultSet->fetch_array(MYSQLI_ASSOC);
		
// 	return $result["$clmnR"];

// }
//echo get_id("snor_sistemas","idsistema");

// echo "<br>";
// echo "<hr>";	

// $gbd = new PDO('mysql:host=localhost;dbname=snorsoft',"AdminSnor", "1598753");
// $gsent = $gbd->prepare("SELECT idsistema, nombre FROM snor_sistemas");
// $gsent->execute();

// /* Obtener todas las filas restantes del conjunto de resultados */
// print("Obtener todas las filas restantes del conjunto de resultados:\n");
// $resultado = $gsent->fetchAll();
// print_r($resultado);



require_once('lib/FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);

// $firephp->group(array("this" => "is", "group" => "output"));

$firephp->log("Log", "Label");
$firephp->info("Info test '");
$firephp->error("Error", "Err Label");
$firephp->warn("Warning");
$firephp->log(array(0 => "A", "Z" => "Y"));
$firephp->log(array(1, 2, array(0 => "A", "Z" => "Y"), 4, 5));

// $resultado=get_last_v();
// print_r($resultado);
//$firephp->groupEnd();






//$resultado=get_state(1);
//echo ($resultado);

$files = array_slice(scandir('files_sol\\2-6-4-2017--13!31!41'), 2);
$files_d=array();
//print_r($files);
foreach ($files as $value)
		{
			$files_d[]=$value;	
		}
print_r($files_d);
$zipname = 'archivos.zip';
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($files_d as $file) {
	$zip->addFile($file);
}
$zip->close();
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname);
 ?>
<!--  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
 <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
 <script type="text/javascript">
	
	$.post( "fetch_states_paids.php",{ type: 1 })
	.done(function( data ) {
						    console.log( "Data Loaded: " + data );
						  });
 </script>  -->