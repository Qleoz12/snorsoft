<?php

include "conecction.php";
include "lib/class.upload.php";

/// mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = false;
//info from update.php
$descrip=(isset($_POST['descripcion_ver'])) ? $_POST['descripcion_ver']:0;
$sistem=(isset($_POST['sistema'])) ? $_POST['sistema']:0;
$id=(isset($_POST['id'])) ? $_POST['id']:0;
$nameFile=(isset($_POST['nameFile'])) ? $_POST['nameFile']:0;


$files = array();
foreach ($_FILES['filez'] as $k => $l) 
{
 foreach ($l as $i => $v) {
 if (!array_key_exists($i, $files))
   $files[$i] = array();
   $files[$i][$k] = $v;
 }
}

//state of the array  its check  
$updtd_fl_stt=$files['0']['error'];
if ($updtd_fl_stt==0) 
{ 

        foreach ($files as $file) 
        {
          $handle = new Upload($file);
          //$handle->mime_magic_check = false;
          //$handle->mime_check = false;
          $handle->allowed =('application/x-rar');
          if ($handle->uploaded) {
            $handle->Process("uploads/");
            if ($handle->processed) {
              // usamos la funcion insert_img de la libreria db.php
              update_ver($id,"uploads/",$handle->file_dst_name,$descrip,$sistem);
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
}
else
{ 
  
  update_ver($id,"uploads/",$nameFile,$descrip,$sistem);
}

   

if(!$error){
	print "<h4>Exito!</h4>";
	print "<li><a href='./v.php'>Ver Archivos</a></li></ul>";
  
}

?>