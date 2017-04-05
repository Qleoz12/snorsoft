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
		$usuarioX = get_data_user($_GET["id"]);
		$usuario=$usuarioX->usuario;
		$password=$usuarioX->password;
		$email=$usuarioX->email;
		$privilegio=$usuarioX->snor_privilegios;
		// convert true== 51
		echo gettype($privilegio);
		echo $privilegio;
		$privilegio = ($privilegio=="51")? "" : "Checked" ;
		include 'html/cabecera.html';
		include 'html/update_user.html';
		include 'html/foot.html';	
	}
	else
	{
		print "<h4>no tiene acceso a esta pagina solo usuarios del area 51</h4>";
	}

} //end else

?>