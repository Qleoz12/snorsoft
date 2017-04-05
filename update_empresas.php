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
		$empresaX = get_data_empresa($_GET["id"]);
		$empresa=$empresaX->empresa;
		$nit=$empresaX->nit;
		$licencia=$empresaX->licencia;
		$financiero=$empresaX->financiero;
		$comercial=$empresaX->comercial;
		$estatus=$empresaX->estatus;
		$anos=$empresaX->anos;
		$pago=$empresaX->pago;
		//echo $pago;
		include 'html/cabecera.html';
		include 'html/update_empresa.html';
		include 'html/foot.html';	
	}
	else
	{
		print "<h4>no tiene acceso a esta pagina solo usuarios del area 51</h4>";
	}

} //end else

?>