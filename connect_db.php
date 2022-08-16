<?php 

$dsn="mysql:host=localhost;dbname=client";
$username="root";
$pass="";

try{
    $con = new PDO($dsn , $username , $pass);
}catch(PDOException $e){
    echo "<script>alert('DataBase Connection Is Failed!')</script>";
}