<?php 

include("conecction.php");  //include config file
$id=isset($_POST["id_empresas"])?$_POST["id_empresas"]:0 ;

$nombre_empresas=isset($_POST["nombre_empresas"])?$_POST["nombre_empresas"]:0 ;
$nit_empresas=isset($_POST["nit_empresas"])?$_POST["nit_empresas"]:0 ;
$sistema_c=isset($_POST["sistema_c#"])?$_POST["sistema_c#"]:0 ;
$sistema_f=isset($_POST["sistema_f#"])?$_POST["sistema_f#"]:0 ;
$pago=isset($_POST["pago#"])?$_POST["pago#"]:0 ;

$version_comercial=isset($_POST["version_comercial"])?$_POST["version_comercial"]:0 ;
$version_financiero=isset($_POST["version_financiero"])?$_POST["version_financiero"]:0 ;

// saber si esta actualizada
$LastSistems=get_last_v();
 $V_c = ($sistema_c==$LastSistems['comercial']) ? "Actualizado" : "No actualizado" ;
 $V_f = ($sistema_f==$LastSistems['financiero']) ? "Actualizado" : "No actualizado" ;
 $status= ($V_f==$V_c || $V_c==$V_f) ? "Actualizado" : "No actualizado";

//$pago=get_state($pago);

// echo $id."\n";
// echo $nombre_empresas."\n";
// echo $nit_empresas."\n";
// // echo $LastSistems['comercial']."\n";
// // echo $sistema_c."\n";
// echo $V_c."\n";
// echo $V_f."\n";
//function update_empresas($id,$nombre, $nit,$financiero,$comercial)
update_empresas($id,$nombre_empresas,$nit_empresas,$version_financiero,$version_comercial,$status,$pago);
?>