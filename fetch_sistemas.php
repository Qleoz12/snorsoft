<?php 

include("conecction.php");  //include config file

// instance
$mysqli=con();  
        $results = $mysqli->prepare("select idsistema,nombre from snor_sistemas");
        $results->execute();
        $results->bind_result($id, $name);

     
 echo "<option value disabled selected>Seleccione sistema</option>"; 
   while($results->fetch())
  { //fetch values
       echo "<option value=".$id.">".$name."</option>";
  }


?>