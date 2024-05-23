<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "register_system";

$conn = mysqli_connect($server , $username , $password , $database);

if(!$conn){
    die("<script>alert('Database not connected.')</script>");
}


?>