<?php
include "index.php";
$lentextarea=lencamptabl('snorsoft','snor_files','descripcion');
 if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
	if(isset($_GET["id"]) and $_SESSION['privilegio']==51)
	{
		
		$ver_file = get_img($_GET["id"]);
		$sistema=$ver_file->sistema;
		$nameFile=$ver_file->src;
		

		include 'html/cabecera.html';
		include 'html/update.html';
		include 'html/foot.html';	
	}
	else
	{
		print "<h4>no tiene acceso a esta pagina solo usuarios del area 51</h4>";
	}

} //end else


?>