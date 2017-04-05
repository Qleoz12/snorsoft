<?php 
 include "index.php";
 $page=null;
 
 if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
	if($_SESSION['privilegio']==51)
	{
		include 'html/cabecera.html';
		include 'html/v.html';
		include 'html/foot.html';
	}	
	else
	{
		include 'html/cabecera.html';	
		include 'html/v_only_consult.html';
		include 'html/foot.html';
	}
	
}
 
 ?>