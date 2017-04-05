<?php
session_start();
include "conecction.php";
include "lib/class.upload.php";

/// mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = false;
//info from form.php
$descrip=$_POST['descripcion_ver'];
$user=$_SESSION['userid'];

$sistem=(isset($_POST['sistema'])) ? $_POST['sistema']:0;


$files = array();
foreach ($_FILES['filez'] as $k => $l) 
{
 foreach ($l as $i => $v) {
 if (!array_key_exists($i, $files))
   $files[$i] = array();
   $files[$i][$k] = $v;
 }
}


foreach ($files as $file) {
  $handle = new Upload($file);
  //$handle->mime_magic_check = false;
  //$handle->mime_check = false;
  $handle->allowed =('application/x-rar');
  if ($handle->uploaded) {
    $handle->Process("uploads/");
    if ($handle->processed) {
    	// usamos la funcion insert_img de la libreria db.php
      //function insert_img($folder, $image, $desc,$sistem,$user)
    	insert_img("uploads/",$handle->file_dst_name,$descrip,$sistem,$user);
      //$sistem (string)
      //update the states in the companies 
      if ($sistem=="1" or $sistem=="5") 
      {
          update_empresas_from_versiones();
      }

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

if(!$error){
	print "<h4>Exito!</h4>";
	print "<ul><li><a href='./form.php'>Agregar mas</a></li>";
	print "<li><a href='./v.php'>Ver Archivos</a></li></ul>";
  
}

?>