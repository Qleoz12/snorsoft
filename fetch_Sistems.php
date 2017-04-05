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
	
		$results = $mysqli->prepare("SELECT idsistema,nombre, descripcion  FROM snor_sistemas order by idsistema DESC");
		
		$results->execute(); //Execute prepared Query
		$results->bind_result($id, $name, $descripcion); //bind variables to prepared statement
		//Display records fetched from database.
		if ($_SESSION['privilegio']==51) {
			echo "<table>
			        <thead>
			          	<tr>
			              <th>ID</th>
			              <th>Sistema</th>
			              <th>Descripcion</th>
			              <th>Accion</th>
			              <th>Accion</th>
			          	</tr>
			        </thead>
			        <tbody>";
		
			while($results->fetch())
			{ //fetch values
				   echo"<tr>
			            	<td>".$id."</td>
			            	<td>".$name."</td>
			            	<td>".$descripcion."</td>
			            	<td> <a class='waves-effect waves-light btn modal-trigger deleteUser' href='#Borrar' data-row=".$id.">Borrar</a></td>
			            	<td><a href='update_sistems.php?id=".$id."'>Modificar</a></td>
			          	</tr>"; 
						
			}//end while
				echo "</tbody>
			      	</table>";
			    echo "  <!-- Modal Structure -->
						  	<div id='Borrar' class='modal'>
							    <div class='modal-content'>
							      <h4>Borrar Usuario</h4>
							      <p></p>
							    </div>
							    <div class='modal-footer'>
							      <a href='#!' class='modal-action modal-close modal-delete-confirm waves-effect waves-red btn-flat'>OK!!</a>
							      <a href='#!' class='modal-action modal-close waves-effect waves-green btn-flat'>Volver</a>
							    </div>
						  	</div>";
		 
		}
		else
		{
			echo "ups51";
		}
		

}//end if 
else
{
	echo "ups";
}
exit();
?>