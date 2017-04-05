<?php 

include("conecction.php");  //include config file

$id=isset($_POST["id"])?$_POST["id"]:0 ;

// instance
$mysqli=con();

$sql=("delete from snor_users where iduser='$id'");    
          	if ($mysqli->query($sql) === TRUE) 
          	{
            	echo "New record delete successfully";
        	}
        	else
        	{
            	echo "Error: " . $sql . "<br>" . $mysqli->error;
        	}

          	
          	$mysqli->close();

?>