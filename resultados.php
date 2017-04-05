<?php 
include_once "conecction.php";
$files = get_imgs();
include "index.php";
  ?>
<head>
<meta charset="utf-8">
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="cxx/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="cxx/stylo.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
</head>	
<main class="container">
		<!-- seccion de botones-->
        <section class="row">          
          <a  href="form.php" class="waves-effect waves-light btn">Cargar</a>
        </section>  
        <div class="row">
        	
	        
	        <ul class="collapsible col s12" data-collapsible="expandable">
	            
	            <?php if(count($files)>0):?>
	            	<?php foreach($files as $f):?>
	            <li>
	              <div class="collapsible-header"><i class="material-icons">done</i>last</div>
	              <div class="collapsible-body">
	              	<table border="1">
		              	<tr>
						<td>Archivo</td>
						<td>Fecha de Subida</td>
						<td><i class="material-icons">system_update_alt</i></td>
						<td><i class="material-icons">delete</i></td>
						</tr>

						<tr>
						<td><?php echo $f->src;?></td>
						<td><?php echo $f->created_at;?></td>
						<td><a href="./download.php?id=<?php echo $f->id; ?>">Descargar</a></td>
						<td><a href="./delete.php?id=<?php echo $f->id; ?>">Eliminar</a></td>
						</tr>
					</table>
							<h5>Descripción de cambios:</h5>
							<p class="wordtext">
								<?php echo "$f->descripcion;"?>
							</p>
					             </div> <!-- end collapsible-body-->
	            </li>
	            <?php endforeach;?>
	        </ul>

	        
        </div>
        <?php else:?>
			<h4>No se han encontrado versiones</h4>
		<?php endif; ?>

</main>
 <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script src="js/materialize-pagination.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>