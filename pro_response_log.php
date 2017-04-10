<?php 
include("conecction.php");  //include config file
include "lib/class.upload.php";
//obtener dato de la session
session_start();
$varuser=$_SESSION['userid'];
/// mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//recibir la informacion
$id=isset($_POST["id"])?$_POST["id"]:0;
$title=isset($_POST["response_title"])?$_POST["response_title"]:0 ;
$descrip=isset($_POST["response_descrip"])?$_POST["response_descrip"]:0;
$response_fecha=isset($_POST["response_fecha"])?$_POST["response_fecha"]:0;
$fechaactual=isset($_POST["fechaactual"])?$_POST["fechaactual"]:0;
$id_sistema=isset($_POST["id_sistema"])?$_POST["id_sistema"]:0;
$file_name=null;

$jsnodata = array();
    $jsnodata["data"]["id"]=$id;
    $jsnodata["data"]["title"]=$title;
    $jsnodata["data"]["descrip"]=$descrip;
    $jsnodata["data"]["response_fecha"]=$response_fecha;
    $jsnodata["data"]["fechaactual"]=$fechaactual;
    $jsnodata["data"]["id_sistema"]=$id_sistema;
//code for folder
$codename=returnIdLast('snor_log_soluciones','id_log_sol')+1;
$complexcodename=$codename."-".$fechaactual;

//cargar archivos 
$files = array();
foreach ($_FILES['files_sol'] as $k => $l) 
{
 foreach ($l as $i => $v) {
 if (!array_key_exists($i, $files))
   $files[$i] = array();
   $files[$i][$k] = $v;
 }
}
foreach ($files as $file) {
  $handle = new Upload($file);
  
  if ($handle->uploaded) {
    $handle->Process("files_sol/$complexcodename");
    if ($handle->processed) {

      require_once('lib/FirePHPCore/FirePHP.class.php');
      $firephp = FirePHP::getInstance(true);
      $firephp->log("Log", "se ha subido el archivo en ".$complexcodename);
      $file_name=$handle->file_dst_name;
      
    } else {
    $error = true;
      echo 'Error: ' . $handle->error;
      //echo 'inpect:' . $handle->log;
    }
  } else {
    $error = true;
    echo 'Error: ' . $handle->error;
  }
  unset($handle);
}


    
if($id!=0 and strlen($title)>0  and strlen($descrip)>0 and strlen($response_fecha)>0 and strlen($fechaactual)>0)
{
	subir_respuesta_log($id,$title,$descrip,$response_fecha,$fechaactual,$varuser,$id_sistema,$complexcodename,$file_name);
  echo json_encode($jsnodata);
}
else
{
	die("Solicitud no válida.");
}

function subir_respuesta_log($id,$title,$descrip,$response_fecha,$fechaactual,$username,$id_sistema,$ruta,$name_file)
{
	# code...
  
		$mysqli=con();		

          	$sql=("Insert Into snor_log_soluciones(	 nombre_sol,
	                                                   fecha_sol,
                                                     descripcion_sol,
	                                                   fecha_registro_sol,
                                                     folder_files_sol,
                                                     name_file_sol,
                                                     usuario_registro,
	                                                   id_error,
	                                                   id_sistema_sol) 
                        								VALUES
                        								('$title',
                        								 '$response_fecha',
                        								 '$descrip', 
                        								 '$fechaactual',
                                         '$ruta',
                                         '$name_file',
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
