<?php 

include("conecction.php");  //include config file

$id=$_POST["id"]; 
$nombre_usuario=isset($_POST["nombre_usuario"])?$_POST["nombre_usuario"]:0 ;
$contraseña_usuario=isset($_POST["contraseña_usuario"])?$_POST["contraseña_usuario"]:0 ;
$email_usuario=isset($_POST["email_usuario"])?$_POST["email_usuario"]:0 ;
$privilegio=isset($_POST["privilegio"])?$_POST["privilegio"]:0 ;
// convert true== 51
$privilegio = ($privilegio=="false")? 51 : 0 ;
//function update_sistem($id,$nombre, $descripcion)
update_user($id,$nombre_usuario,$contraseña_usuario,$email_usuario,$privilegio);
echo "AAAAAAAAAAA"
?>