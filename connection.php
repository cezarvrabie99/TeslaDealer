<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "proiect";
try{
    $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
} catch (PDOException $exception){
    $connect = null;
    echo "Conexiune esuata!!!<br>";
    echo $exception;
}
