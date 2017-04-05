<?php
session_start();
 if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
	if(isset($_GET["id"]) and $_SESSION['privilegio']==51)
	{
		include "conecction.php";
		$img = get_img($_GET["id"]);
		if($img!=null)
		{
			del($img->id);
			unlink($img->folder.$img->src);
			print "<h4>Eliminada Exitosamente!</h4>";
			print "<ul><li><a href='./form.php'>Agregar mas</a></li>";
			print "<li><a href='./files.php'>Ver Archivos</a></li></ul>";
		}	
	}
	else
	{
		print "<h4>no tiene acceso a esta pagina solo usuarios del area 51</h4>";
	}

} //end else


?>