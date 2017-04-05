<?php

// datos para la coneccion a mysql
define('DB_SERVER','localhost');
define('DB_NAME','snorsoft');
define('DB_USER','AdminSnor');
define('DB_PASS','1598753');

$con = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
mysql_select_db(DB_NAME,$con);

function verificar_login($user,$password,&$result) {
    $sql = "SELECT * FROM snor_users WHERE usuario = '$user' and password = '$password'";
    $rec = mysql_query($sql);
    $count = 0;

    while($row = mysql_fetch_object($rec))
    {
        $count++;
        $result = $row;
    }

    if($count == 1)
    {
        return 1;
    }

    else
    {
        return 0;
    }
}
/// codigo externo pero muy util
/**
* Conexion a la base de datos y funciones
* Autor: evilnapsis
**/

function con(){
	return new mysqli("localhost","AdminSnor","1598753","snorsoft");
}

function insert_img($folder, $image, $desc,$sistem,$user)
{
	$con = con();
	$con->query("insert into snor_files (folder,src,created_at,descripcion,sistema,usuario_registro) value (\"$folder\",\"$image\",NOW(), \"$desc\", \"$sistem\", \"$user\")");
}

//function to update info about version
function update_ver($id,$folder, $ver, $desc,$sistem )
{
	$con = con();
	$con->query("update snor_files set folder='$folder',src='$ver',descripcion='$desc',sistema='$sistem' where id='$id' ");
}



function get_imgs(){
	$images = array();
	$con = con();
	$query=$con->query("select * from snor_files order by created_at desc");
	while($r=$query->fetch_object()){
		$images[] = $r;
	}
	return $images;
}

function get_img($id){
	$image = null;
	$con = con();
	$query=$con->query("select * from snor_files where id=$id");
	while($r=$query->fetch_object()){
		$image = $r;
	}
	return $image;
}

function del($id){
	$con = con();
	$con->query("delete from snor_files where id=$id");
}

function lencamptabl($db,$tbl,$clmn)
{
	$len=null;
	$con=con();
	$query=$con->query("SELECT column_name, character_maximum_length FROM information_schema.columns WHERE table_schema='$db' AND table_name = '$tbl' AND column_name = '$clmn'");
	if( !$query)
	{	echo "QueryError";
		die($con->error);
	}
	while($r=$query->fetch_object()){
		$len = $r;
	}
	return $len->character_maximum_length;
}

function returnIdLast($tbl,$clmn)
{
	$con=con();
	$query=$con->prepare("select * FROM $tbl ORDER BY $clmn DESC LIMIT 1");
	$query->execute();
	if( !$query)
	{	echo "QueryError";
		die($con->error);
	}
	//grab a result set
	$resultSet = $query->get_result();
	//pull all results as an associative array
	$result = $resultSet->fetch_array(MYSQLI_ASSOC);
		
	return $result["$clmn"];
}


// get data from a table for in other proccess iterate over it
function getdatatable($tbl,$clmn)
{
	$len=null;
	$con=con();
	$query=$con->query("select * FROM $tbl ORDER BY $clmn DESC LIMIT 1");
	if( !$query)
	{	echo "QueryError";
		die($con->error);
	}
	return $query;
}

//change an id by defect adyacent column
function ChangeColumbyColumn($tbl,$id,$idValue,$clmnR)
{
	$con=con();
	$query = $con->prepare("select $clmnR FROM $tbl where $id='$idValue'");
	$query->execute();
	//grab a result set
	$resultSet = $query->get_result();
	//pull all results as an associative array
	$result = $resultSet->fetch_all(MYSQLI_ASSOC);
	return $result[0]['nombre'];

}




//-------------------------Usuarios-----------------------////////////////
//getdata of table users by specific id
function get_data_user($id){
	$image = null;
	$con = con();
	$query=$con->query("select * from snor_users where iduser=$id");
	while($r=$query->fetch_object()){
		$image = $r;
	}
	return $image;
}

//function to update info about user
function update_user($id,$user, $pass, $email,$privilegio )
{
	$con = con();
	$query=$con->query("UPDATE snor_users SET usuario='$user',password='$pass',email='$email',snor_privilegios='$privilegio' where iduser='$id' ");

	if( !$query)
	{	echo "QueryError: ";
		die($con->error);
	}
}


//-------------------------sistemas-----------------------////////////////
//function to get id 
function get_Slast_id($tbl,$clmnR)
{
	$con=con();
	$query = $con->prepare("select * FROM $tbl order by $clmnR desc limit 1,1");
	$query->execute();
	//grab a result set
	$resultSet = $query->get_result();
	//pull all results as an associative array
	$result = $resultSet->fetch_array(MYSQLI_ASSOC);
		
	return $result["$clmnR"];

}
//getdata of table users by specific id
function get_data_sistem($id){
	$image = null;
	$con = con();
	$query=$con->query("select * from snor_sistemas where idsistema=$id");
	while($r=$query->fetch_object()){
		$image = $r;
	}
	return $image;
}

//function to update info about user
function update_sistem($id,$nombre, $descripcion)
{
	$con = con();
	$query=$con->query("UPDATE snor_sistemas SET nombre='$nombre',descripcion='$descripcion'  where idsistema='$id' ");

	if( !$query)
	{	echo "QueryError: ";
		die($con->error);
	}
}


//-------------------------empresas-----------------------////////////////
//getdata of table users by specific id
function get_data_empresa($id){
	$image = null;
	$con = con();
	$query=$con->query("select * from snor_empresas where id_empresa=$id");
	while($r=$query->fetch_object()){
		$image = $r;
	}
	return $image;
}

function get_last_v()
{
	$con=con();
	//get last comercial file
	$query = $con->prepare("select * FROM snor_files where sistema=1 order by id desc limit 0,1");
	$query->execute();
	//grab a result set
	$resultSet = $query->get_result();
	//pull all results as an associative array
	$result = $resultSet->fetch_array(MYSQLI_ASSOC);



	//set the data of sistems
	$LastSistems = array();
	$LastSistems['comercial'] =$result['id'];


	//get last comercial file
	$query = $con->prepare("select * FROM snor_files where sistema=5 order by id desc limit 0,1");
	$query->execute();
	//grab a result set
	$resultSet = $query->get_result();
	//pull all results as an associative array
	$result = $resultSet->fetch_array(MYSQLI_ASSOC);

	$LastSistems['financiero'] =$result['id'];

	
	return $LastSistems;
}


//function to update info about empresas
function update_empresas($id,$nombre, $nit,$financiero,$comercial,$status,$pago)
{
	$con = con();
	$query=$con->query("UPDATE snor_empresas SET empresa='$nombre',nit='$nit',financiero='$financiero',comercial='$comercial',estatus='$status',pago='$pago'  where id_empresa='$id'");
	
	if( !$query)
	{	echo "QueryError: ";
		die($con->error);
	}

}

//function to update info about empresas
function update_empresas_from_versiones()
{
	$con = con();
	$query=$con->query("UPDATE snor_empresas SET estatus='No actualizado'");
	
	if( !$query)
	{	echo "QueryError: ";
		die($con->error);
	}

}

//function to get data  about states
function get_state($id)
{
	$con = con();
	//get last comercial file
	$query = $con->prepare("SELECT * FROM `snor_states`  where id_state='$id'");
	$query->execute();
	if( !$query)
	{	echo "QueryError: ";
		die($con->error);
	}
	//grab a result set
	$resultSet = $query->get_result();
	//pull all results as an associative array
	$result = $resultSet->fetch_array(MYSQLI_ASSOC);
	
	return  $result['state'];
}



//-------------------------documentos-----------------------////////////////
//inser a new document
function insert_a_doc($folder,$name_file,$title,$descripcion,$etiqueta,$fecha,$user)
{
	$con = con();
	$query=$con->query("insert into snor_docs (folder_doc,name_doc,titulo_doc,descripcion_doc, etiqueta_doc,fecha_doc,fecha_creado_doc,id_user) value (\"$folder\",\"$name_file\",\"$title\", \"$descripcion\", \"$etiqueta\",\"$fecha\",Now() ,\"$user\")");
	if( !$query)
	{	echo "QueryError: ";
		die($con->error);
	}
}

function get_doc($id){
	$image = null;
	$con = con();
	$query=$con->query("select * from snor_docs where id_doc=$id");
	while($r=$query->fetch_object()){
		$image = $r;
	}
	return $image;
}
?>