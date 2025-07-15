<?php 

$server="localhost";
$user="root";
$password="";
$dbase="fitzone_7306";

$conn=mysqli_connect($server, $user, $password, $dbase );

if(!$conn){

	die("Connection failed: ".mysqli_error());

}
echo "Connected successfully";
 ?>
