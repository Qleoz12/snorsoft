<?php 
 include "index.php";
 
 if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
	include 'html/cabecera.html';
	include 'html/default.html';
	include 'html/foot.html';
}
 
 ?>