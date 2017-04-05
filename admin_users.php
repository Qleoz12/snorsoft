<?php 
 include "index.php";

 
 if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
	if($_SESSION['privilegio']==51)
	{
		include 'html/cabecera.html';
		include 'html/admin_users.html';
		include 'html/foot.html';
	}	
	else
	{
		include 'html/cabecera.html';
		include 'html/dontAccess.html';
		include 'html/foot.html';
		
	}
	
}

?>