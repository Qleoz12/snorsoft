<?php 
 include "index.php";
 
 
 if(!isset($_SESSION['userid']))
{
	header("location:index.php");	
}
else
{
	
	include 'html/response.html';

}
