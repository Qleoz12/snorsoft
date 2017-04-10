<?php 

if(isset($_GET["id"])){


	include "conecction.php";
	$img = get_file_sol($_GET["id"]);
	$file_name=$_GET["filename"];

	if($img!=null){
		$fullpath ="files_sol/".$img->folder_files_sol."/".$file_name;
		@ini_set('error_reporting', E_ALL & ~ E_NOTICE);//- turn off compression on the server
		@apache_setenv('no-gzip', 1);
		@ini_set('zlib.output_compression', 'Off');
		// sanitize the file request, keep just the name and extension
		// also, replaces the file location with a preset one ('./myfiles/' in this example)
		$file_path  = $_REQUEST['file'];
		$path_parts = pathinfo($fullpath);
		//$file_name  = $path_parts['basename'];
		$file_ext   = $path_parts['extension'];
		//$file_path  = './files_sol/'.$fullpath;// allow a file to be streamed instead of sent as an attachment
		//$is_attachment = isset($_REQUEST['stream']) ? false : true;// make sure the file exists
		// echo $fullpath;
		// echo "<br>";
		// echo "if null";
		// echo "<br>";
		// echo is_file($file_path);
		$file_size  = filesize($file_path);
		$ctype_default = "application/octet-stream";
		$content_types = array(
                "exe" => "application/octet-stream",
                "zip" => "application/zip",
                "mp3" => "audio/mpeg",
                "mpg" => "video/mpeg",
                "avi" => "video/x-msvideo",
                "avi" => "video/x-msvideo"
		        );
		$ctype = isset($content_types[$file_ext]) ? $content_types[$file_ext] : $ctype_default;
		header("Content-Disposition: attachment; filename=$file_name");
		readfile($fullpath);        
		
	}//end if null
}
?>