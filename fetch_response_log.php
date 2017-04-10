<?php 
include("conecction.php");  //include config file

if( isset($_POST['id_response']) and isset($_POST['id_sis'])) 
{
  $id_error=$_POST['id_response'];
  $responses_total=get_number_of_responses($_POST['id_response'], $_POST['id_sis']);
  $jsnodata = array();
  $jsnodata["data"]["id_error"]=$id_error;
  $jsnodata["data"]["responses_total"]=$responses_total;

		  if ($responses_total>0) 
		{
			
			$mysqli=con();	
		  	$results = $mysqli->prepare("SELECT id_log_sol,nombre_sol,fecha_sol,descripcion_sol,fecha_registro_sol,name_file_sol,folder_files_sol FROM snor_log_soluciones where id_error='$id_error'");
		  	$results->execute();
		  	$results->bind_result($id, $name, $created_at,$descripcion,$fecha_registro_sol,$name_file_sol,$folder_files_sol); //bind
		  	//Display records fetched from database.
			
			
				while($results->fetch()){ //fetch values
				        
				echo	'<li>
				              <div class="collapsible-header">
				              	<i class="material-icons">done</i>';
				echo              	$id."-".$name;
				echo          '</div>
				              <div class="collapsible-body">
				              	<table border="1">
					              	<tr>
					              	<td>ID de solucion</td>
									<td>nombre de la solución</td>
									<td>Fecha de registro de la solucion</td>
									<td>fecha de entrada</td>
								    </tr>';
				echo 				'<tr>';
				echo 				'<td>'.$id.'</td>';
				echo 				'<td>'.$name.'</td>';
				echo				'<td>'.$created_at.'</td>';
				echo				'<td>'.substr($fecha_registro_sol,0,10).'</a></td>
									</tr>';
				    echo 			'</table>';
				   	echo 			"<h5>Descripcion de solucion</h5>";
				   	echo			"<p>".$descripcion."</p>";
				   	echo 			"<h5>Archivos Adjuntos</h5>";
				   	echo			"<p>";
				   					$log_directory ="files_sol/".$folder_files_sol;
				   					foreach (glob($log_directory.'/*.*') as $file) 
				   					{
				   						# code...
				   						$file_name=substr($file, strrpos( $file, '/' ) + 1 );
				   						echo "<a href=./download_files_sol.php?id=".$id."&filename=".$file_name.">".$file_name."</a> <br>";
				   					}	
				   	echo             "</p>";
				    echo '		</div> <!-- end collapsible-body-->
				          </li>';
		 	 }
			
		  

		}
		else
		{
		  	echo "no hay respuestas registradas para el error-".$_POST['id_response'];
		}
		json_encode($jsnodata);
} // end of if post
else
{
	die("Solicitud no válida.");
}

function get_number_of_responses( $id, $sistem) 
{
 	
 	$mysqli=con();
    $results = $mysqli->query("SELECT * FROM snor_log_soluciones where id_error=$id");
    $number_rows=$results->num_rows;
    $results->close();
    $mysqli->close();
    return $number_rows;
}


?>