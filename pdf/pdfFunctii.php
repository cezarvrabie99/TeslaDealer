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
    $res = $connect->prepare("SELECT * FROM functie");
} else
    $res = null;
$res->execute();


$pdf = new PDF("P","mm","A4", "Functii");
$offset = 50;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setTitle("Functii", 1);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont("Arial",'B',12);
$pdf->setX($offset);
$pdf->Cell(20,8,"Cod",1,0,'C',1);
$pdf->Cell(25,8,"Denumire",1,0,'C',1);
$pdf->Cell(35,8,"Salariul brut",1,0,'C',1);
$pdf->Cell(35,8,"Salariul net",1,1,'C',1);

$pdf->SetFont('Arial','',10);

while($row = $res->fetch(PDO::FETCH_OBJ))
{
    $pdf->setX($offset);
    $pdf->Cell(20,8,$row->codf,1,0,'C');
    $pdf->Cell(25,8,$row->denf,1,0,'C');
    $pdf->Cell(35,8,$row->salariubrut,1,0,'C');
    $pdf->Cell(35,8,$row->salariunet,1,1,'C');
}
$pdf->Output();