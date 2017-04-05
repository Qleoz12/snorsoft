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
		$item_per_page= isset($_POST["item_per_page"])?$_POST["item_per_page"]:30 ; //item to display per page
		
		if (isset($_POST["sistema"]))
		{	
			//
			$sistema=$_POST["sistema"];
			//get total number of records from database for pagination
			$results = $mysqli->query("SELECT COUNT(*) FROM snor_files  where sistema=$sistema");
			$get_total_rows = $results->fetch_row(); //hold total records in variable
			//break records into pages
			$total_pages = ceil($get_total_rows[0]/$item_per_page);
			//get starting position to fetch the records
			$page_position = (($page_number-1) * $item_per_page);
			//Limit our results within a specified range. 
			
			$results = $mysqli->prepare("SELECT id, src,created_at,descripcion,sistema  FROM snor_files where sistema=$sistema order by created_at DESC LIMIT $page_position, $item_per_page");
		}
		else
		{	
			//get total number of records from database for pagination
			$results = $mysqli->query("SELECT COUNT(*) FROM snor_files");
			$get_total_rows = $results->fetch_row(); //hold total records in variable
			//break records into pages
			$total_pages = ceil($get_total_rows[0]/$item_per_page);
			//get starting position to fetch the records
			$page_position = (($page_number-1) * $item_per_page);
			//Limit our results within a specified range.
			$results = $mysqli->prepare("SELECT id, src,created_at,descripcion,sistema  FROM snor_files ORDER BY created_at DESC LIMIT $page_position, $item_per_page");	
		}
		
		$results->execute(); //Execute prepared Query
		$results->bind_result($id, $name, $created_at,$descripcion,$sistema); //bind variables to prepared statement
		//Display records fetched from database.
		if ($_SESSION['privilegio']==51) {
		
			while($results->fetch()){ //fetch values
				        
			echo	'<li>
			              <div class="collapsible-header blue lighten-4">
			              	<i class="material-icons">done</i>';
			echo              	$id." "." - ".$name." - ".ChangeColumbyColumn("snor_sistemas","idsistema",$sistema,"nombre");
			echo          '</div>
			              <div class="collapsible-body">
			              	<table border="1">
				              	<tr>
				              	<td>ID</td>
								<td>Archivo</td>
								<td>Fecha de Subida</td>
								<td>Sistema</td>
								<td><i class="material-icons">system_update_alt</i></td>
								<td><i class="mdi mdi-lead-pencil mdi-24px"></i>  <!-- bell --></td>
								<td><i class="material-icons">delete</i></td>
							    </tr>';
			echo 				'<tr>';
			echo 				'<td>'.$id.'</td>';
			echo 				'<td>'.$name.'</td>';
			echo				'<td>'.$created_at.'</td>';
			echo				'<td>'.ChangeColumbyColumn("snor_sistemas","idsistema",$sistema,"nombre").'</td>';
			echo				'<td><a href="./download.php?id='.$id.'">Descargar</a></td>
								 <td><a href="./update.php?id='.$id.'">Modificar</a></td>
								 <td><a href="./delete.php?id='.$id.'">Eliminar</a></td>
								</tr>';
			    echo 			'</table>';
				echo '<h5>Descripción de cambios:</h5>';
				echo '<p class="wordtext">';
				echo  $descripcion;
				echo '</p>';
				echo  '</div> <!-- end collapsible-body-->
			           </li>';
			
			}//end while
		}
		 
		else
		{
			while($results->fetch()){ //fetch values
				        
			echo	'<li>
			             <div class="collapsible-header blue lighten-4">
			              	<i class="material-icons">done</i>';
			echo              	$id." "." - ".$name." - ".ChangeColumbyColumn("snor_sistemas","idsistema",$sistema,"nombre");
			echo          '</div>
			              <div class="collapsible-body">
			              	<table border="1">
				              	<tr>
				              	<td>ID</td>
								<td>Archivo</td>
								<td>Fecha de Subida</td>
								<td>Sistema</td>
								<td><i class="material-icons">system_update_alt</i></td>
							    </tr>';
			echo 				'<tr>';
			echo 				'<td>'.$id.'</td>';
			echo 				'<td>'.$name.'</td>';
			echo				'<td>'.$created_at.'</td>';
			echo				'<td>'.ChangeColumbyColumn("snor_sistemas","idsistema",$sistema,"nombre").'</td>';
			echo				'<td><a href="./download.php?id='.$id.'">Descargar</a></td>		 
								</tr>';
			    echo 			'</table>';
				echo '<h5>Descripción de cambios:</h5>';
				echo '<p class="wordtext">';
				echo  $descripcion;
				echo '</p>';
				echo  '</div> <!-- end collapsible-body-->
			           </li>';
			
			}//end while
		}	

}//end if 

exit();
?>

