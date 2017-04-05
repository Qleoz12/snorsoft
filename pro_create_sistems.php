<?php 

include("conecction.php");  //include config file

$nombre_sistema=isset($_POST["nombre_sistema"])?$_POST["nombre_sistema"]:0 ;
$descripcion_sistema=isset($_POST["descripcion_sistema"])?$_POST["descripcion_sistema"]:0 ;
$id=get_Slast_id("snor_sistemas","idsistema")+1;
echo $id;
// instance
$mysqli=con();


$sql=("Insert Into snor_sistemas(idsistema,
                                 nombre,
                                 descripcion
                    					   ) 
          								VALUES
          								('$id',
                          '$nombre_sistema',
          								 '$descripcion_sistema')");    
          	if ($mysqli->query($sql) === TRUE) 
          	{
            	echo "New record created successfully";
        	}
        	else
        	{
            	echo "Error: " . $sql . "<br>" . $mysqli->error;
        	}

          	
          	$mysqli->close();

?>