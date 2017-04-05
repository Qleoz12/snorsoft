<?php
/* Database connection start */
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
// Esto le dice a PHP que generaremos cadenas UTF-8
mb_http_output('UTF-8');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "snorsoft";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
/* Database connection end */
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
$columns = array( 
// datatable column index  => database column name
	0 =>'id_empresa',
	1 =>'licencia', 
	2 => 'nit',
	3=> 'empresa',
	4=> 'financiero',
	5=> 'comercial',
	6=> 'estatus',
	7=> 'pago'
	
);
// getting total number records without any search
$sql = "SELECT id_empresa,licencia,nit,empresa,financiero,comercial,estatus,pago";
$sql.=" FROM snor_empresas";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT id_empresa,licencia,nit,empresa,financiero,comercial,estatus,pago";
	$sql.=" FROM snor_empresas";
	$sql.=" WHERE empresa LIKE '"."%".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR nit LIKE '"."%".$requestData['search']['value']."%' ";
	$sql.=" OR licencia LIKE '"."%".$requestData['search']['value']."%' ";
	$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees1");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees2"); // again run query with limit
	
} else {	
	$sql = "SELECT id_empresa,licencia,nit,empresa,financiero,comercial,estatus,pago";
	$sql.=" FROM snor_empresas";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
	
}
//echo $sql;

$data = array();
include_once 'conecction.php';
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	$nestedData[] = $row["id_empresa"];  //0
	$nestedData[] = $row["licencia"];    //1
	$nestedData[] = $row["nit"];		 //2	
	$nestedData[] = $row["empresa"];	 //3	
	$nestedData[] = $row["financiero"];	 //4
	$nestedData[] = $row["comercial"];	 //5	
	$nestedData[] = $row["estatus"];	 //6
	$nestedData[] = get_state($row["pago"]);		 //7
	
	$data[] = $nestedData;
}

$data=utf8_converter($data);
 $json_data = array(
 			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
 			"recordsTotal"    => intval( $totalData ),  // total number of records
 			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
 			"data"            => $data   // total data array
 			);
 echo json_encode($json_data);  // send data as json format

//
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
        }
    });
 
    return $array;
}
?>