<?php 

$error_log_path = __DIR__ . "/../logs/errors.log";

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

ini_set('log_errors', 1);
ini_set('error_log', $error_log_path);

error_reporting(E_ALL);

$server="localhost";
$user="root";
$password="";
$dbase="fitzone_7306";

$conn=mysqli_connect($server, $user, $password, $dbase );
if(!$conn){
	die();
}
 ?>
