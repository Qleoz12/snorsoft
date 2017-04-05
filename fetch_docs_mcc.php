<?php
/* Title : Ajax Pagination with jQuery & PHP
Example URL : http://www.sanwebe.com/2013/03/ajax-pagination-with-jquery-php */

/// definicion de variables 
		
session_start();

//continue only if $_POST is set and it is a Ajax request
if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
	include("conecction.php");  //include config file
	$mysqli=con();	
	
	//Get page number from Ajax POST
	if(isset($_POST["page"]))
	{
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}
	else
	{
		$page_number = 1; //if there's no page number, set it to 1
		
	} //end else


	//get dthe data for item_per page 
	$item_per_page= isset($_POST["item_per_page"])?$_POST["item_per_page"]:30; 
	//item to display per page
	//filter by keydata
	if (isset($_POST["keyval"]))
	{	
			//data searched by user
			$keyval=$_POST["keyval"];
			//get total number of records from database for pagination
			$results = $mysqli->query("SELECT COUNT(*) FROM snor_docs  where titulo_doc like '%".$keyval."%' or descripcion_doc like '%".$keyval."%' or etiqueta_doc like '%".$keyval."%'");
			$get_total_rows = $results->fetch_row(); //hold total records in variable
			//break records into pages
			$total_pages = ceil($get_total_rows[0]/$item_per_page);
			//get starting position to fetch the records
			$page_position = (($page_number-1) * $item_per_page);
			//Limit our results within a specified range. 
			
			$results = $mysqli->prepare("SELECT id_doc,titulo_doc, descripcion_doc,etiqueta_doc,fecha_doc, fecha_creado_doc,id_user  FROM snor_docs where titulo_doc like '%".$keyval."%' or descripcion_doc like '%".$keyval."%' or etiqueta_doc like '%".$keyval."%' order by id_doc DESC LIMIT $page_position, $item_per_page");
	}
	else
	{

		//get total number of records from database for pagination
		$results = $mysqli->query("SELECT COUNT(*) FROM snor_docs");
		$get_total_rows = $results->fetch_row(); //hold total records in variable
		//break records into pages
		$total_pages = ceil($get_total_rows[0]/$item_per_page);
		//get starting position to fetch the records
		$page_position = (($page_number-1) * $item_per_page);
		//Limit our results within a specified range.
		$results = $mysqli->prepare("SELECT id_doc,titulo_doc, descripcion_doc,etiqueta_doc,fecha_doc, fecha_creado_doc,id_user  FROM snor_docs ORDER BY id_doc DESC LIMIT $page_position, $item_per_page");

	}	

		$results->execute(); //Execute prepared Query
		$results->bind_result($id,$titulo, $descripcion, $etiqueta,$fecha,$fecha_creado_doc,$user); //bind variables to prepared statement
		
			while($results->fetch()){ //fetch values
				        
			echo	'<li>
			             <div class="collapsible-header blue lighten-4">
			              	<i class="material-icons">done</i>';
			echo              	$id." "." - ".$titulo." - ";
			echo          '</div>
			              <div class="collapsible-body">
			              	<table border="1">
				              	<tr>
				              	<td>ID</td>
								<td>Archivo</td>
								<td>Fecha de Archivo</td>
								<td>subio!</td>
								<td><i class="material-icons">system_update_alt</i></td>
							    </tr>';
			echo 				'<tr>';
			echo 				'<td>'.$id.'</td>';
			echo 				'<td>'.$titulo.'</td>';
			echo				'<td>'.$fecha.'</td>';
			echo				'<td>'.$user.'</td>';
			echo				'<td><a href="./download_docs.php?id='.$id.'">Descargar</a></td>		 
								</tr>';
			    echo 			'</table>';
				echo '<h5>Descripción del documento:</h5>';
				echo '<p class="wordtext">';
				echo  $descripcion;
				echo '</p>';
				echo  '</div> <!-- end collapsible-body-->
			           </li>';
			
			}//end while
}	

 

exit();
?>

