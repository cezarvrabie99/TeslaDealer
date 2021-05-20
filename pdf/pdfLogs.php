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
    $res = $connect->prepare("SELECT * FROM logs");
} else
    $res = null;
$res->execute();


$pdf = new PDF("L","mm","A4", "Loguri");
$offset = 10;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setTitle("Loguri", 1);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont("Arial",'B',12);
$pdf->setX($offset);
$pdf->Cell(20,10,"Cod",1,0,'C',1);
$pdf->Cell(25,10,"Username",1,0,'C',1);
$pdf->Cell(45,10,"Actiune",1,0,'C', 1);
$pdf->Cell(100,10,"Comanda",1,0,'C', 1);
$pdf->Cell(25,10,"Data",1,0,'C',1);
$pdf->Cell(25,10,"Ora",1,0,'C',1);
$pdf->Cell(35,10,"Functie",1,1,'C',1);

$pdf->SetFont('Arial','',10);

while($row = $res->fetch(PDO::FETCH_OBJ))
{
    $pdf->setX($offset);
    $pdf->Cell(20,10,$row->codl,1,0,'C');
    $pdf->Cell(25,10,$row->username,1,0,'C');
    $pdf->Cell(45,10,$row->actiune,1,0,'C');

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 100;
    $pdf->MultiCell(100,5,$row->comanda,1);
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $pdf->Cell(25,10,$row->datal,1,0,'C');
    $pdf->Cell(25,10,$row->oral,1,0,'C');
    $pdf->Cell(35,10,selectFrom("select denf from functie where codf = '" . $row->codf . "';", 1),1,1,'C');
}
$pdf->Output();