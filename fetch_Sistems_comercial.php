<?php 

include("conecction.php");  //include config file

// instance
$mysqli=con();  
        $results = $mysqli->prepare("SELECT id,concat(id,SUBSTRING(created_at,1,4),SUBSTRING(created_at,6,2),SUBSTRING(created_at,9,2)) as cod FROM `snor_files` where sistema=1");
        $results->execute();
        $results->bind_result($id, $data);

     
 echo "<option  disabled selected>Selecciona una versión</option>"; 
   while($results->fetch())
  { //fetch values
       echo "<option value=".$id.">".$data."</option>";
  }


?>