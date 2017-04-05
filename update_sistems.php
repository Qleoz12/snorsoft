<?php 
include "index.php";
 if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
	if(isset($_GET["id"]) and $_SESSION['privilegio']==51)
	{
		
		$id=$_GET["id"];
		$sistemaX = get_data_sistem($_GET["id"]);
		$nombre=$sistemaX->nombre;
		$descripcion=$sistemaX->descripcion;
		
		include 'html/cabecera.html';
		include 'html/update_sistems.html';
		include 'html/foot.html';	
	}
	else
	{
		print "<h4>no tiene acceso a esta pagina solo usuarios del area 51</h4>";
	}

} //end else

?>