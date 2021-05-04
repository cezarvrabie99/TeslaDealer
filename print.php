<?php
require "connection.php";
require "select.php";

session_start();
$codlog = selectFrom("select codf from utilizatori where username = '" . $_SESSION['user'] . "';", 1);

if (!isset($_SESSION['user']) || $codlog != 4){
    header("location:index.php");
}

if (!empty($connect))
    $stmt = $connect->prepare("SELECT * FROM " . $_GET['tab']);
else
    $stmt = null;
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$filename = $_GET['tab'] . '.xls';

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename = $filename");
header("Pragma: no-cache");
header("Expires: 0");

$separator = "\t";

if(!empty($rows)){
    echo implode($separator, array_keys($rows[0])) . "\n";

    foreach($rows as $row){
        foreach($row as $k => $v){
            $row[$k] = str_replace($separator . "$", "", $v);
            $row[$k] = preg_replace("/\r\n|\n\r|\n|\r/", " ", $row[$k]);
            $row[$k] = trim($row[$k]);
        }
    echo implode($separator, $row) . "\n";
    }
}