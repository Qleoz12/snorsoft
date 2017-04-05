<?php
/* Title : Ajax Pagination with jQuery & PHP
Example URL : http://www.sanwebe.com/2013/03/ajax-pagination-with-jquery-php */

/// definicion de variables 
		


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
		$item_per_page = 50; //item to display per page
		
		//Limit our results within a specified range. 
		if (isset($_POST["sistema"])) 
		{
			$sistema=$_POST["sistema"];
			//get total number of records from database for pagination
			$results = $mysqli->query("SELECT COUNT(*) FROM snor_log_errores where id_sistema_error='$sistema'");
			$get_total_rows = $results->fetch_row(); //hold total records in variable
			//break records into pages
			$total_pages = ceil($get_total_rows[0]/$item_per_page);
			//get starting position to fetch the records
			$page_position = (($page_number-1) * $item_per_page);
			
			$results = $mysqli->prepare("SELECT id_log_error, nombre_error,fecha_error,descripcion_error,imagen_error,id_sistema_error,etiqueta_error  FROM snor_log_errores where id_sistema_error=$sistema order by id_log_error DESC LIMIT $page_position, $item_per_page");
		}
		elseif (isset($_POST["keyval"]))
		{	
			//data searched by user
			$keyval=$_POST["keyval"];
			//get total number of records from database for pagination
			$results = $mysqli->query("SELECT COUNT(*) FROM snor_log_errores  where nombre_error like '%".$keyval."%' or etiqueta_error like '%".$keyval."%' or descripcion_error like '%".$keyval."%'");
			$get_total_rows = $results->fetch_row(); //hold total records in variable
			//break records into pages
			$total_pages = ceil($get_total_rows[0]/$item_per_page);
			//get starting position to fetch the records
			$page_position = (($page_number-1) * $item_per_page);
			//Limit our results within a specified range. 
			
			$results = $mysqli->prepare("SELECT id_log_error, nombre_error,fecha_error,descripcion_error,imagen_error,id_sistema_error,etiqueta_error  FROM snor_log_errores where nombre_error like '%".$keyval."%' or etiqueta_error like '%".$keyval."%' or descripcion_error like '%".$keyval."%' order by id_log_error DESC LIMIT $page_position, $item_per_page");
		}
		else
		{
			//get total number of records from database for pagination
			$results = $mysqli->query("SELECT COUNT(*) FROM snor_log_errores");
			$get_total_rows = $results->fetch_row(); //hold total records in variable
			//break records into pages
			$total_pages = ceil($get_total_rows[0]/$item_per_page);
			//get starting position to fetch the records
			$page_position = (($page_number-1) * $item_per_page);
			$results = $mysqli->prepare("SELECT id_log_error, nombre_error,fecha_error,descripcion_error,imagen_error,id_sistema_error,etiqueta_error  FROM snor_log_errores ORDER BY id_log_error DESC LIMIT $page_position, $item_per_page");	
		}
		
		$results->execute(); //Execute prepared Query
		$results->bind_result($id, $name, $created_at,$descripcion,$ruta_imgs,$id_sistema_error,$etiqueta_error); //bind variables to prepared statement
		

		//Display records fetched from database.
		while($results->fetch()){ //fetch values
		        
		echo	'<li>
		              <div class="collapsible-header cyan lighten-3">
		              	<i class="material-icons">done</i>';
		echo              	$id." - ".$name." - ".ChangeColumbyColumn("snor_sistemas","idsistema",$id_sistema_error,"nombre");
		echo          '</div>
		              <div class="collapsible-body">
		              	<table border="1">
			              	<tr>
			              	<td>ID del error</td>
							<td>nombre del error</td>
							<td>Fecha de registro del error</td>
							<td><i class="material-icons medium">question_answer</i></td>
						    </tr>';
		echo 				'<tr>';
		echo 				'<td>'.$id.'</td>';
		echo 				'<td>'.$name.'</td>';
		echo				'<td>'.$created_at.'</td>';
		echo				'<td><a href="#" name="response" data-row="'.$id.'" data-sis="'.$id_sistema_error.'">Responder</a></td>
							</tr>';
		    echo 			'</table>';
			echo '<h5 class="blue-text text-darken-2">Descripción de cambios:</h5>';
			echo '<p class="wordtext">';
			echo  $descripcion;
			echo '</p>';
			echo '<h6 class="blue-text text-darken-2">Etiqueta del Error</h6>';
			echo '<p class="wordtext">';
			echo  $etiqueta_error;
			echo '</p>';
			echo '<h5>Imagen de Error</h5>';
			echo '<div id="images_log" name="images_log" class="col s12 ignored">';
            

            if (file_exists($ruta_imgs))
            {
            	$dirimgs = dir($ruta_imgs);		    
				while (($archivo = $dirimgs->read()) !== false)
			    {	
			    	if ($archivo != "." && $archivo!="..")
			    	{
	                    echo '<div class="col s12 blue darken-3 mycenter"> <img class="materialboxed responsive-img" data-caption=" " width="190" src="'.$ruta_imgs."/".$archivo.'"> </div>';
	                    // echo '<br>'.$archivo.'<br>';
	                } 
			    }
			    $dirimgs->close();
            }
            else
            {
            	echo '<br>'."no se encuentran imagenes adjuntas".'<br>';
            }
            
		    echo '</div><!-- end #images-to-upload -->';
		    

			echo '</div> <!-- end collapsible-body-->
		           </li>';
		
		} //end while	

}//end if 

exit();
?>