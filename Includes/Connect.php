<?php

$host = "localhost";
$db_name = "cp";
$user = "root";
$pass = "";
$msg = null;

try{
    $con = new PDO("mysql:host=$host; dbname=$db_name; charset=utf8", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $msg = "Connexion Réussie";
}catch(PDOException $e){
    $msg = "Connexion Echoue" . $e->getMessage();
}