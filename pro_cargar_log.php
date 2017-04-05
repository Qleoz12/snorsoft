<?php 

include("conecction.php");  //include config file
include "lib/class.upload.php";

//obtener dato de la session
session_start();
$varuser=$_SESSION['userid'];


//recibir la informacion
$nombre_error=isset($_POST["nombre_error"])?$_POST["nombre_error"]:0 ;
$E_error=isset($_POST["E_error"])?$_POST["E_error"]:0;
$log_sistema=isset($_POST["log_sistema"])?$_POST["log_sistema"]:0 ;
$log_descrip=isset($_POST["log_descrip"])?$_POST["log_descrip"]:0;
$fecha_error=isset($_POST["fecha_error"])?$_POST["fecha_error"]:0 ;
$title=isset($_POST["title"])?$_POST["title"]:0;
$fechaactual=isset($_POST["fechaactual"])?$_POST["fechaactual"]:0;

//code for folder
$codename=returnIdLast('snor_log_errores','id_log_error')+1;
$complexcodename=$codename."-".$fechaactual;
  $jsnodata = array();
    $jsnodata["data"]["nombre_error"]=$nombre_error;
    $jsnodata["data"]["E_error"]=$E_error;
    $jsnodata["data"]["log_sistema"]=$log_sistema;
    $jsnodata["data"]["log_descrip"]=$log_descrip;
    $jsnodata["data"]["fecha_error"]=$fecha_error;
    $jsnodata["data"]["title"]=$title;
    $jsnodata["data"]["fechaactual"]=$fechaactual;
    $jsnodata["data"]["complexcodename"]=$complexcodename;
    echo json_encode($jsnodata);
//var_dump($_FILES); //files
// var_dump($_POST); //post
    
if($complexcodename!=0 and strlen($nombre_error)>0  and strlen($E_error)>0 and strlen($fecha_error)>0 and strlen($fechaactual)>0)
{

// codigo para subir las imagenes
     $files = array();
     foreach ($_FILES['images'] as $k => $l) {
      foreach ($l as $i => $v) 
      {
         if (!array_key_exists($i, $files))
           $files[$i] = array();
           $files[$i][$k] = $v;
      }
    }


    foreach ($files as $file) {
      $handle = new Upload($file);
      //$handle->mime_magic_check = false;
      //$handle->mime_check = false;
      //$handle->allowed =('application/x-rar');
      if ($handle->uploaded) {
        $handle->Process("ImagesLog/$complexcodename");
        if ($handle->processed) 
         {
            echo "subidos";
        } 
        else 
        {
            $error = true;
            echo 'Error: ' . $handle->error;
            echo 'inpect:' . $handle->log;
        
        }
      } else {
        $error = true;
        echo 'Error: ' . $handle->error;
      }
      unset($handle);
    }



 get_DataInfoPag($nombre_error,$log_sistema,$E_error,$fecha_error,$fechaactual,$log_descrip,$varuser,"ImagesLog/$complexcodename");
      

}
else
{
	die("Solicitud no válida.");
}

        function get_DataInfoPag( $nombre,$sistema, $etiqueta, $fechaError, $fechaactual,$descripcion, $username,$ruta_img_cargada) 
        {
         	
        	$mysqli=con();		

          	$sql=("Insert Into snor_log_errores(nombre_error,
                                                etiqueta_error,
                            					fecha_error,
                            					descripcion_error,
                            					id_sistema_error,
                                                fecha_registro,
                            					usuario_registro,
                                                imagen_error) 
          								VALUES
          								('$nombre',
          								 '$etiqueta',
          								 '$fechaError', 
          								 '$descripcion',
          								 '$sistema',
                                         '$fechaactual',                                           
          								 '$username',
                                         '$ruta_img_cargada')");    
          	if ($mysqli->query($sql) === TRUE) 
          	{
            	echo "New record created successfully";
        	}
        	else
        	{
            	echo "Error: " . $sql . "<br>" . $mysqli->error;
        	}

          	
          	$mysqli->close();
        }
?>