<?php 

include("conecction.php");  //include config file

$nombre_usuario=isset($_POST["nombre_usuario"])?$_POST["nombre_usuario"]:0 ;
$contraseña_usuario=isset($_POST["contraseña_usuario"])?$_POST["contraseña_usuario"]:0 ;
$email_usuario=isset($_POST["email_usuario"])?$_POST["email_usuario"]:0 ;
$fechaactual=isset($_POST["fechaactual"])?$_POST["fechaactual"]:0 ;
$privilegio=isset($_POST["privilegio"])?$_POST["privilegio"]:0 ;
// convert true== 51
$privilegio = ($privilegio=="false")? 51 : 0 ;

// instance
$mysqli=con();

$sql=("Insert Into snor_users(					usuario,
                                                password,
                            					email,
                            					fechaRegistro, 
                            					snor_privilegios) 
          								VALUES
          								('$nombre_usuario',
          								 '$contraseña_usuario',
          								 '$email_usuario', 
          								 '$fechaactual',
          								 '$privilegio')");    
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