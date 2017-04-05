<?php 

if(isset($_GET["id"])){
	include "conecction.php";
	$img = get_doc($_GET["id"]);
	if($img!=null){
		$fullpath = $img->folder_doc."/".$img->name_doc;
		header("Content-Disposition: attachment; filename=$img->name_doc");
		echo $fullpath;
		readfile($fullpath);
		
	}
}
 ?>