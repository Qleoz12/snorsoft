<?php 

include("conecction.php");  //include config file
include "lib/class.upload.php";

//obtener dato de la session
session_start();
$varuser=$_SESSION['userid'];

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

    print_r($files);
?>