<?php 

include("conecction.php");  //include config file

$id=$_POST["id"]; 
$nombre_sistema=isset($_POST["nombre_sistema"])?$_POST["nombre_sistema"]:0 ;
$descripcion_sistema=isset($_POST["descripcion_sistema"])?$_POST["descripcion_sistema"]:0 ;
//function update_sistem($id,$nombre, $descripcion)
update_sistem($id,$nombre_sistema,$descripcion_sistema);
?>