<?php 

//obtener datos de la base de datos
if( isset($_POST['basspass']) ) 
{
  get_DataInfoPag($_POST['basspass']);


}
else
{
	die("Solicitud no válida.");
}

function get_DataInfoPag( $id ) 
{
 	include("conecction.php");  //include config file
  $mysqli=con();
  //get data of sistem
  $sistema=isset($_POST["sistema"])?$_POST["sistema"]:null;
  //items per page
  $item_per_page=30;
  if ($id==1) 
  {
    if ($sistema!=null) 
    {
      $results = $mysqli->query("SELECT * FROM snor_files where sistema='$sistema'");
    } else {
      
      $results = $mysqli->query("SELECT * FROM snor_files");
    }
    
    
    $total_pages = ceil($results->num_rows/$item_per_page);
    $jsnodata = array();
    $jsnodata["data"]["TotalRecords"]=$results->num_rows;
    $jsnodata["data"]["pages"]=$total_pages;
    $jsnodata["data"]["item_per_page"]=$item_per_page;
    $results->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsnodata, JSON_FORCE_OBJECT);
    $mysqli->close();
  }
  if ($id==2) 
  {
    if ($sistema!=null) 
    {
      $results = $mysqli->query("SELECT * FROM snor_log_errores where id_sistema_error='$sistema'");
    }
    elseif (isset($_POST["keyval"])) 
    {
      $keyval=$_POST["keyval"];
      $results = $mysqli->query("SELECT *  FROM snor_log_errores where nombre_error like '%".$keyval."%' or etiqueta_error like '%".$keyval."%' or descripcion_error like '%".$keyval."%' order by id_log_error DESC");
    }
    else
    {
      $results = $mysqli->query("SELECT * FROM snor_log_errores");
      
    }
    $total_pages = ceil($results->num_rows/$item_per_page);
    $jsnodata = array();
    $jsnodata["data"]["TotalRecords"]=$results->num_rows;
    $jsnodata["data"]["pages"]=$total_pages;
    $results->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsnodata, JSON_FORCE_OBJECT);
    $mysqli->close();
  }

    if ($id==3) 
  {
    
    $item_per_page=50; 
    $results = $mysqli->query("SELECT * FROM snor_empresas"); 
    $total_pages = ceil($results->num_rows/$item_per_page);
    $jsnodata = array();
    $jsnodata["data"]["TotalRecords"]=$results->num_rows;
    $jsnodata["data"]["pages"]=$total_pages;
    $results->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsnodata, JSON_FORCE_OBJECT);
    $mysqli->close();
  }

    if ($id==4) 
  {
    
    $item_per_page=50; 
    if (isset($_POST["keyval"])) 
    {
      $keyval=$_POST["keyval"];
      $results = $mysqli->query("SELECT *  FROM snor_docs where titulo_doc like '%".$keyval."%' or descripcion_doc like '%".$keyval."%' or etiqueta_doc like '%".$keyval."%' order by id_doc DESC");
    }
    else
    {
      $results = $mysqli->query("SELECT * FROM snor_docs"); 
    }
    $total_pages = ceil($results->num_rows/$item_per_page);
    $jsnodata = array();
    $jsnodata["data"]["TotalRecords"]=$results->num_rows;
    $jsnodata["data"]["pages"]=$total_pages;
    $jsnodata["data"]["item_per_page"]=$item_per_page;
    $results->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsnodata, JSON_FORCE_OBJECT);
    $mysqli->close();
  }
}

 ?>