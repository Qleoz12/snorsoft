<?php 

 include "index.php";

 $page=null;
 
 if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
		
		include 'html/cabecera.html';
		include 'html/docs_mcc.html';
		include 'html/foot.html';
		
}
 

 ?>