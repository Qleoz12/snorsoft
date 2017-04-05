<?php 
include "index.php";
$lentextarea=lencamptabl('snorsoft','snor_files','descripcion');

if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
	include 'html/cabecera.html';
	include 'html/cargar.html';
	include 'html/foot.html';
}
 

?>

