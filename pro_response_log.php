<?php 
include("conecction.php");  //include config file

//obtener dato de la session
session_start();
$varuser=$_SESSION['userid'];


//recibir la informacion
$id=isset($_POST["id"])?$_POST["id"]:0;
$title=isset($_POST["response_title"])?$_POST["response_title"]:0 ;
$descrip=isset($_POST["response_descrip"])?$_POST["response_descrip"]:0;
$response_fecha=isset($_POST["response_fecha"])?$_POST["response_fecha"]:0;
$fechaactual=isset($_POST["fechaactual"])?$_POST["fechaactual"]:0;
$id_sistema=isset($_POST["id_sistema"])?$_POST["id_sistema"]:0;

$jsnodata = array();
    $jsnodata["data"]["id"]=$id;
    $jsnodata["data"]["title"]=$title;
    $jsnodata["data"]["descrip"]=$descrip;
    $jsnodata["data"]["response_fecha"]=$response_fecha;
    $jsnodata["data"]["fechaactual"]=$fechaactual;
    $jsnodata["data"]["id_sistema"]=$id_sistema;
    
if($id!=0 and strlen($title)>0  and strlen($descrip)>0 and strlen($response_fecha)>0 and strlen($fechaactual)>0)
{
	subir_respuesta_log($id,$title,$descrip,$response_fecha,$fechaactual,$varuser,$id_sistema);
  echo json_encode($jsnodata);
}
else
{
	die("Solicitud no válida.");
}

function subir_respuesta_log($id,$title,$descrip,$response_fecha,$fechaactual,$username,$id_sistema)
{
	# code...
  
		$mysqli=con();		

          	$sql=("Insert Into snor_log_soluciones(	 nombre_sol,
	                                                   fecha_sol,
                                                     descripcion_sol,
	                                                   fecha_registro_sol,
                                                     usuario_registro,
	                                                   id_error,
	                                                   id_sistema_sol) 
                        								VALUES
                        								('$title',
                        								 '$response_fecha',
                        								 '$descrip', 
                        								 '$fechaactual',
                        								 '$username',
                                         '$id',
                                         '$id_sistema')");    
          	if ($mysqli->query($sql) === TRUE) 
          	{
            	echo "New record created successfully";
              $jsnodata["data"]["state"]="010";
        	}
        	else
        	{
            	echo "Error: " . $sql . "<br>" . $mysqli->error;
              $jsnodata["data"]["state"]="XIX";
        	}

          	
          	$mysqli->close();
}




 ?>}
