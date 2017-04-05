<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include_once "conecction.php";
//debug
require_once('lib/FirePHPCore/FirePHP.class.php');
require_once('lib/FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);

$var=isset($_SESSION['userid']);
$firephp->info("Info test '$var");
$myfile = fopen("html/login.html", "r") or die("Unable to open file!");

if(!isset($_SESSION['userid']))
{
    
    if(isset($_POST['login']))
    {
        if(verificar_login($_POST['user'],$_POST['password'],$result) == 1)
        {
            $_SESSION['userid'] = $result->usuario;
            $_SESSION['privilegio'] = $result->snor_privilegios;    
            header("location:default.php");
        }
        else
        {
            echo '<div class="error">Su usuario es incorrecto, intente nuevamente.</div>';
        }
    }

        while(!feof($myfile)) 
        {
          echo fgets($myfile);
        }
} 
else 
{

    echo '<div class="fonttest">Bienvenido: '.$_SESSION['userid'].'</div>';;
    echo '<a href="logout.php">Logout</a>';
    $host= $_SERVER["HTTP_HOST"];
    $url= $_SERVER["REQUEST_URI"];
    $url="http://".$host.$url;
    if ("http://localhost:8088/snorsoft/Utilities/index.php"==$url) 
    {
        //echo("http://localhost:8088/snorsoft/Utilities/index.php"==$url);
        header("location:default.php");
    }


}

?>