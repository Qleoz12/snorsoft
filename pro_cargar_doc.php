<?php
session_start();
include "conecction.php";
include "lib/class.upload.php";

/// mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = false;
//info from docs_cargar.php

$titulo_doc=isset($_POST["titulo_doc"])?$_POST["titulo_doc"]:0 ;
$etiqueta_doc=isset($_POST["etiqueta_doc"])?$_POST["etiqueta_doc"]:0 ;
$descripcion_doc=isset($_POST["descripcion_doc"])?$_POST["descripcion_doc"]:0 ;
$fecha_doc=isset($_POST["fecha_doc"])?$_POST["fecha_doc"]:0 ;
$fechaactual=isset($_POST["fechaactual"])?$_POST["fechaactual"]:0;
$user=$_SESSION['userid'];

//code for folder
$codename=returnIdLast('snor_docs','id_doc')+1;
$complexcodename=$codename."-".$fechaactual;

$files = array();
foreach ($_FILES['doc_'] as $k => $l) 
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
    $handle->Process("Docs_loaded/$complexcodename");
    if ($handle->processed) {
    	// usamos la funcion insert_img de la libreria db.php
      //function insert_a_doc($folder,$name_file,$title,$descripcion,$etiqueta,$fecha,$user)
    	insert_a_doc("Docs_loaded/$complexcodename",$handle->file_dst_name,$titulo_doc,$descripcion_doc,$etiqueta_doc,$fecha_doc,$user);
      

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