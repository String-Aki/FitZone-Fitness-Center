<?php 
$server="localhost";
$user="root";
$password="";
$dbase="fitzone_7306";

$conn=mysqli_connect($server, $user, $password, $dbase );
if(!$conn){
	die();
}
echo '<script type="text/javascript">console.log("Database Connected successfully");</script>';
 ?>
