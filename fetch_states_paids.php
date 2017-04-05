<?php 

include("conecction.php");  //include config file

// instance
$mysqli=con();  
$data = array();     



if(isset($_POST["type"]))
{	

  $tipo=$_POST["type"];
	//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
	$results = $mysqli->query("SELECT id_state,state FROM `snor_states` where id_state='$tipo'");
	
	while($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
  { //fetch values
  	   $nestedData=array(); 
  	   $data=$row;
  }	
  echo($data['state']);
  
}
else
{
 $results = $mysqli->prepare("SELECT id_state,state FROM `snor_states`");
        $results->execute();
        $results->bind_result($id, $data);		
 echo "<option  disabled selected>Selecciona una estado</option>"; 
   while($results->fetch())
  { //fetch values
       echo "<option value=".$id.">".$data."</option>";
  }
	
}
?>