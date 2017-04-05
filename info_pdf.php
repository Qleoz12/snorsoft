<!DOCTYPE html>
<html>
<head>
	<title>Informe</title>
	<link rel="stylesheet" type="text/css" href="cxx/materialize.css">
	<link href="cxx/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />
	<style type="text/css">
			.container
			{
				width: 95%;
				margin: 10px 20px;
				min-width: 800px;
				word-wrap: break-word;
			}
			table
			{
				border-collapse: collapse;
			}
			td
			{
				word-break: break-word;
				border: 1px solid black;
			}
			th, td
			{
				text-align: center;
			}
			th:nth-of-type(1)
			{
				width: 3%;
			}
			
			th:nth-of-type(7)
			{
				width: 10%;	
			}


	</style>
</head>
<body class="">
 		<div class="container">
 		<div class="row">
 			<a class="btn-floating btn-large waves-effect waves-light red" name="craft_pdf"><i class="mdi mdi-file-pdf mdi-36px"></i></a>
 		</div>
 		<div class="row">
		                  
        	<?php 
include("conecction.php");  //include config file

$mysqli=con();
if( isset($_POST['sistem']) and isset($_POST['pass']) and isset($_POST['informe'])) 
{
  $id_sistema=$_POST['sistem']; //type string
  $clave=$_POST['pass'];		//type string
  $informe=$_POST['informe'];	//type string
  $codigo_sol=isset($_POST["codigo_sol"])? $_POST["codigo_sol"]:0;
		if ($informe=="Errores") 
		{
			# code...
				
				$array = array(255, 0, 0);
				setcookie("color[0]", $array[0], time()+3600);
				setcookie("color[1]", $array[1], time()+3600);
				setcookie("color[2]", $array[2], time()+3600);
				echo "<H3 class='center-align'>Reporte de Errores Registrados</H3>";
				echo '<table class="striped">
						        <thead class="red darken-3">
						          <tr class="red darken-3">
						          	  <th width="3%">N#</th>
						              <th width="3%">ID</th>
						              <th width="10%">Nombre</th>
						              <th width="10%">Etiqueta</th>
						              <th width="50%">Descripcion</th>
						              <th width="10%">Fecha</th>
						              <th width="10%">Fecha registro</th>
						              <th width="10%">Usuario</th>
						          </tr>
						        </thead>
						        <tbody>';

			if ($id_sistema=="999" and $clave=="0") {
				# code...
				$query="SELECT @curRank := @curRank + 1 as rank,id_log_error,nombre_error,etiqueta_error,descripcion_error,fecha_error,fecha_registro,usuario_registro FROM snor_log_errores,(SELECT @curRank := 0) r order by id_log_error desc";
				$results = $mysqli->prepare($query);
				  	 $results->execute();
				  	 $results->bind_result($N_r,$id, $name,$label,$descripcion,$created_at,$fecha_registro,$user); //bind
				  	 //Display records fetched from database.
						while($results->fetch())
						{ //fetch values
						echo'<tr>
							    <td>'.$N_r.'</td>
							    <td>'.$id.'</td>
							    <td>'.$name.'</td>
							    <td>'.$label.'</td>
							    <td>'.$descripcion.'</td>
							    <td>'.$created_at.'</td>
							    <td>'.substr($fecha_registro,0,10).'</td>
							    <td>'.$user.'</td>
							  </tr>';
							
						}
					}
				else if ($id_sistema!="999" and $clave=="0") 
				{
					# code...
					 $query="SELECT id_log_error,nombre_error,etiqueta_error,descripcion_error,fecha_error,fecha_registro,usuario_registro,@curRank := @curRank + 1 as rank FROM snor_log_errores,(SELECT @curRank := 0) r where id_sistema_error='$id_sistema';";	
					 $results = $mysqli->prepare($query);
				  	 $results->execute();
				  	 $results->bind_result($id, $name,$label,$descripcion,$created_at,$fecha_registro,$user,$N_r); //bind
				  	 //Display records fetched from database.
						while($results->fetch())
						{ //fetch values
						echo'<tr>
							    <td>'.$N_r.'</td>
							    <td>'.$id.'</td>
							    <td>'.$name.'</td>
							    <td>'.$label.'</td>
							    <td>'.$descripcion.'</td>
							    <td>'.$created_at.'</td>
							    <td>'.substr($fecha_registro,0,10).'</td>
							    <td>'.$user.'</td>
							  </tr>';
					
						}
				}
				else if ($id_sistema=="999" and $clave!="0") 
				{
					# code...
					 $query="SELECT @curRank := @curRank + 1 as rank,id_log_error,nombre_error,etiqueta_error,descripcion_error,fecha_error,fecha_registro,usuario_registro FROM snor_log_errores,(SELECT @curRank := 0) r where (etiqueta_error LIKE '%$clave%' OR descripcion_error LIKE '%$clave%');";	
					 $results = $mysqli->prepare($query);
				  	 $results->execute();
				  	 $results->bind_result($N_r,$id, $name,$label,$descripcion,$created_at,$fecha_registro,$user); //bind
				  	 //Display records fetched from database.
						while($results->fetch())
						{ //fetch values
						echo'<tr>
							    <td>'.$N_r.'</td>
							    <td>'.$id.'</td>
							    <td>'.$name.'</td>
							    <td>'.$label.'</td>
							    <td>'.$descripcion.'</td>
							    <td>'.$created_at.'</td>
							    <td>'.substr($fecha_registro,0,10).'</td>
							    <td>'.$user.'</td>
							  </tr>';
					
						}
				}
				else
				{
					
					$results = $mysqli->prepare("SELECT @curRank := @curRank + 1 as rank,id_log_error,nombre_error,etiqueta_error,descripcion_error,fecha_error,fecha_registro,usuario_registro FROM snor_log_errores, (SELECT @curRank := 0) r where  id_sistema_error='$id_sistema' and (etiqueta_error LIKE '%$clave%' OR descripcion_error LIKE '%$clave%')");
				  	 $results->execute();
				  	 $results->bind_result($N_r,$id, $name,$label,$descripcion,$created_at,$fecha_registro,$user); //bind
				  	 //Display records fetched from database.
						while($results->fetch())
						{ //fetch values
						echo'<tr>
							    <td>'.$N_r.'</td>
							    <td>'.$id.'</td>
							    <td>'.$name.'</td>
							    <td>'.$label.'</td>
							    <td>'.$descripcion.'</td>
							    <td>'.$created_at.'</td>
							    <td>'.substr($fecha_registro,0,10).'</td>
							    <td>'.$user.'</td>
							  </tr>';
					
						}

			}
			
		}
		if ($informe=="solves") 
		{		
				$array = array(46, 184,114);
				setcookie("color[0]", $array[0], time()+3600);
				setcookie("color[1]", $array[1], time()+3600);
				setcookie("color[2]", $array[2], time()+3600);
				echo "<H3 class='center-align '>Reporte de Soluciones Registrados</H3>";
				echo '<table class="striped">
						        <thead class="green">
						          <tr>
						              <th width="3%">N#</th>
						              <th width="3%">ID</th>
						              <th width="10%">Nombre</th>
						              <th width="50%">Descripcion</th>
						              <th width="10%">Fecha</th>
						              <th width="10%">Fecha registro</th>
						              <th width="3%">Error</th>
						              <th width="7%">Usuario</th>
						          </tr>
						        </thead>
						        <tbody>';
			if ($id_sistema=="999" and $clave=="0") 
			{
					# code...
					$results = $mysqli->prepare("SELECT @curRank := @curRank + 1 as rank,id_log_sol,nombre_sol,descripcion_sol,fecha_sol,fecha_registro_sol,id_error,usuario_registro FROM snor_log_soluciones, (SELECT @curRank := 0) r order by id_log_sol desc");
					  	 $results->execute();
					  	 $results->bind_result($N_r,$id, $name,$descripcion,$created_at,$fecha_registro,$id_error,$user); //bind
					  	 	//Display records fetched from database.
							while($results->fetch())
							{ //fetch values
							echo'<tr>
									<td>'.$N_r.'</td>
								    <td>'.$id.'</td>
								    <td>'.$name.'</td>
								    <td>'.$descripcion.'</td>
								    <td>'.$created_at.'</td>
								    <td>'.substr($fecha_registro,0,10).'</td>
								    <td>'.$id_error.'</td>
								    <td>'.$user.'</td>
								  </tr>';
								
							}
			}
			else if ($id_sistema!="999" and $clave=="0" and $codigo_sol=="0") 
			{
				 $results = $mysqli->prepare("SELECT id_log_sol,nombre_sol,descripcion_sol,fecha_sol,fecha_registro_sol,id_error,usuario_registro FROM snor_log_soluciones where id_sistema_sol='$id_sistema'");
				  	 $results->execute();
				  	 $results->bind_result($id, $name,$descripcion,$created_at,$fecha_registro,$id_error,$user); //bind

							//Display records fetched from database.
							while($results->fetch())
							{ //fetch values
							echo'<tr>
								    <td>'.$id.'</td>
								    <td>'.$name.'</td>
								    <td>'.$descripcion.'</td>
								    <td>'.$created_at.'</td>
								    <td>'.substr($fecha_registro,0,10).'</td>
								    <td>'.$id_error.'</td>
								    <td>'.$user.'</td>
								  </tr>';
								
							}
			}
			else if ($id_sistema!="999" and $codigo_sol!=0) 
			{
				 $results = $mysqli->prepare("SELECT id_log_sol,nombre_sol,descripcion_sol,fecha_sol,fecha_registro_sol,id_error,usuario_registro FROM snor_log_soluciones where id_sistema_sol='$id_sistema' and id_error='$codigo_sol' ");
				  	 $results->execute();
				  	 $results->bind_result($id, $name,$descripcion,$created_at,$fecha_registro,$id_error,$user); //bind

							//Display records fetched from database.
							while($results->fetch())
							{ //fetch values
							echo'<tr>
								    <td>'.$id.'</td>
								    <td>'.$name.'</td>
								    <td>'.$descripcion.'</td>
								    <td>'.$created_at.'</td>
								    <td>'.substr($fecha_registro,0,10).'</td>
								    <td>'.$id_error.'</td>
								    <td>'.$user.'</td>
								  </tr>';
								
							}
			}
			else
			{
					$results = $mysqli->prepare("SELECT id_log_sol,nombre_sol,descripcion_sol,fecha_sol,fecha_registro_sol,id_error,usuario_registro FROM snor_log_soluciones where (nombre_sol LIKE '%$clave%' OR descripcion_sol LIKE '%$clave%') and id_sistema_sol='$id_sistema'");
					  	 $results->execute();
					  	 $results->bind_result($id, $name,$descripcion,$created_at,$fecha_registro,$id_error,$user); //bind

								//Display records fetched from database.
								while($results->fetch())
								{ //fetch values
								echo'<tr>
									    <td>'.$id.'</td>
									    <td>'.$name.'</td>
									    <td>'.$descripcion.'</td>
									    <td>'.$created_at.'</td>
									    <td>'.substr($fecha_registro,0,10).'</td>
									    <td>'.$id_error.'</td>
									    <td>'.$user.'</td>
									  </tr>';
									
								}
			}
		
		}//endsolves	
		 
		if ($informe=="versiones") {
			# code...
			
			echo "<H3 class='center-align'>Reporte de Versiones por Sistema</H3>";
				echo '<table class="striped">
						        <thead class="">
						          <tr>
						              <th width="3%">ID</th>
						              <th width="10%">Nombre</th>
						              <th width="50%">descripcion</th>
						              <th width="10%">fecha</th>
						              <th width="10%">Sistema</th>
						              <th width="7%">Usuario</th>
						          </tr>
						        </thead>
						        <tbody>';
			if ($id_sistema=="0" and $clave=="0") 
			{
					# code...
					$results = $mysqli->prepare("SELECT id,src,created_at,descripcion,sistema,usuario_registro FROM snor_files order by id desc");
					  	 $results->execute();
					  	 $results->bind_result($id,$name,$created_at,$descripcion,$sistema,$user); //bind
					  	 	//Display records fetched from database.
							while($results->fetch())
							{ //fetch values
							echo'<tr>
								    <td>'.$id.'</td>
								    <td>'.$name.'</td>
								    <td>'.$descripcion.'</td>
								    <td>'.substr($created_at,0,10).'</td>
								    <td>'.$sistema.'</td>
								    <td>'.$user.'</td>
								  </tr>';
								
							}
			}
			else if ($id_sistema!="0" and $clave=="0") 
			{
					# code...
					$results = $mysqli->prepare("SELECT id,src,created_at,descripcion,sistema,usuario_registro FROM snor_files  where sistema='$id_sistema' order by id desc");
					  	 $results->execute();
					  	 $results->bind_result($id,$name,$created_at,$descripcion,$sistema,$user); //bind
					  	 	//Display records fetched from database.
							while($results->fetch())
							{ //fetch values
							echo'<tr>
								    <td>'.$id.'</td>
								    <td>'.$name.'</td>
								    <td>'.$descripcion.'</td>
								    <td>'.substr($created_at,0,10).'</td>
								    <td>'.$sistema.'</td>
								    <td>'.$user.'</td>
								  </tr>';
								
							}
			}
			else if ($id_sistema!="0" and $clave!="0") 
			{
					# code...
					$results = $mysqli->prepare("SELECT id,src,created_at,descripcion,sistema,usuario_registro FROM snor_files  where sistema='$id_sistema' and (descripcion LIKE '%$clave%' OR src LIKE '%$clave%') order by id desc");
					  	 $results->execute();
					  	 $results->bind_result($id,$name,$created_at,$descripcion,$sistema,$user); //bind
					  	 	//Display records fetched from database.
							while($results->fetch())
							{ //fetch values
							echo'<tr>
								    <td>'.$id.'</td>
								    <td>'.$name.'</td>
								    <td>'.$descripcion.'</td>
								    <td>'.substr($created_at,0,10).'</td>
								    <td>'.$sistema.'</td>
								    <td>'.$user.'</td>
								  </tr>';
								
							}
			}
			
		}
} // end if iiset 


// informe de empresas
elseif (isset($_POST['sistem']) and isset($_POST['informe']) and isset($_POST['pago']) and isset($_POST['estado'])) 
{
	$id_sistema=$_POST['sistem'];  //type string
  	$informe=$_POST['informe'];	   //type string
  	$pago=$_POST["pago"];          // unknow
  	$estado=$_POST["estado"];

  	$array = array(255, 0, 0);
				setcookie("color[0]", $array[0], time()+3600);
				setcookie("color[1]", $array[1], time()+3600);
				setcookie("color[2]", $array[2], time()+3600);
				echo "<H3 class='center-align'>Reporte de Estado de Empresas</H3>";
				echo '<table class="striped">
						        <thead class="red darken-3">
						          <tr class="red darken-3">
						          	  <th width="3%">N#</th>
						              <th width="5%">licencia</th>
						              <th width="25%">empresa</th>
						              <th width="10%">nit</th>
						              <th width="10%">financiero</th>
						              <th width="10%">comercial</th>
						              <th width="10%">pago</th>
						          </tr>
						        </thead>


						        <tbody>';
//estado 1 no actualizado
//estado 2 actualizado
// sistema 1 comercial
// sistema 5 financiero

$LastSistems=get_last_v();
//last comercial
$lastComerc=$LastSistems['comercial'];
//last Financiero
$lastfinanciero=$LastSistems['financiero'];

if ($id_sistema=="1" and $estado=="1") {
	$query="SELECT @curRank := @curRank + 1 as rank,licencia,empresa, nit, financiero,comercial,pago FROM snor_empresas,(SELECT @curRank := 0) r where pago='$pago' and comercial!='$lastComerc' order by id_empresa desc";
	
}
elseif ($id_sistema=="1" and $estado=="2") {
	$query="SELECT @curRank := @curRank + 1 as rank,licencia,empresa, nit, financiero,comercial,pago FROM snor_empresas,(SELECT @curRank := 0) r where pago='$pago' and comercial='lastComerc' order by id_empresa desc";
	
}
elseif ($id_sistema=="5" and $estado=="1") {
	$query="SELECT @curRank := @curRank + 1 as rank,licencia,empresa, nit, financiero,comercial,pago FROM snor_empresas,(SELECT @curRank := 0) r where pago='$pago' and financiero='No actualizado' order by id_empresa desc";
}
elseif ($id_sistema=="5" and $estado=="2") {
	$query="SELECT @curRank := @curRank + 1 as rank,licencia,empresa, nit, financiero,comercial,pago FROM snor_empresas,(SELECT @curRank := 0) r where pago='$pago' and financiero='Actualizado' order by id_empresa desc";
}
				$results = $mysqli->prepare($query);
				  	 $results->execute();
				  	 $results->bind_result($N_r,$licencia,$empresa,$nit,$financiero,$comercial,$pago); //bind
				  	 //Display records fetched from database.
						while($results->fetch())
						{ //fetch values
						echo'<tr>
							    <td>'.$N_r.'</td>
							    <td>'.$licencia.'</td>
							    <td>'.$empresa.'</td>
							    <td>'.$nit.'</td>
							    <td>'.$financiero.'</td>
							    <td>'.$comercial.'</td>
							    <td>'.get_state($pago).'</td>
							  </tr>';
							
						}


}
else
{
	die("Solicitud no válida.");
}

 ?>


          
      </tbody>
      </table>    
      </div>  <!-- endrow  -->
      </div>   <!--endcontainer-->

<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
</body>
</html>