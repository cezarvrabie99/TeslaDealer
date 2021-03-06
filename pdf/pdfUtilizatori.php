<?php
include 'template.php';
require "../connection.php";
require "../select.php";

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);
if (!isset($_SESSION['user']) || $codlog != 4){
    header("location:../index.php");
}

if (!empty($connect)){
    $res = $connect->prepare("SELECT * FROM utilizatori");
} else
    $res = null;
$res->execute();


$pdf = new PDF("P","mm","A4", "Utilizatori");
$offset = 60;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setTitle("Utilizatori", 1);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont("Arial",'B',12);
$pdf->setX($offset);
$pdf->Cell(20,8,"ID",1,0,'C',1);
$pdf->Cell(25,8,"Username",1,0,'C',1);
$pdf->Cell(25,8,"Parola",1,0,'C',1);
$pdf->Cell(20,8,"Functie",1,1,'C',1);

$pdf->SetFont('Arial','',10);

while($row = $res->fetch(PDO::FETCH_OBJ))
{
    $pdf->setX($offset);
    $pdf->Cell(20,8,$row->userid,1,0,'C');
    $pdf->Cell(25,8,$row->username,1,0,'C');
    $pdf->Cell(25,8,$row->password,1,0,'C');
    $pdf->Cell(20,8,selectFrom("select denf from functie where codf = '" . $row->codf . "';", 1),1,1,'C');

}
$pdf->Output();