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
    $res = $connect->prepare("SELECT * FROM service");
} else
    $res = null;
$res->execute();


$pdf = new PDF("L","mm","A4", "Service");
$offset = 5;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setTitle("Service", 1);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont("Arial",'B',12);
$pdf->setX($offset);
$pdf->Cell(10,8,"Cod",1,0,'C',1);
$pdf->Cell(25,8,"Nume",1,0,'C',1);
$pdf->Cell(25,8,"Prenume",1,0,'C',1);
$pdf->Cell(37,8,"VIN",1,0,'C',1);
$pdf->Cell(20,8,"Model",1,0,'C',1);
$pdf->Cell(32,8,"Cod piesa",1,0,'C',1);
$pdf->Cell(27,8,"Denumire",1,0,'C',1);
$pdf->Cell(25,8,"Angajat",1,0,'C',1);
$pdf->Cell(20,8,"Stare",1,0,'C',1);
$pdf->Cell(20,8,"Garantie",1,0,'C',1);
$pdf->Cell(25,8,"Data",1,0,'C',1);
$pdf->Cell(20,8,"Ora",1,1,'C',1);

$pdf->SetFont('Arial','',10);

while($row = $res->fetch(PDO::FETCH_OBJ))
{
    $pdf->setX($offset);
    $pdf->Cell(10,8,$row->cods,1,0,'C');
    $pdf->Cell(25,8,$row->numec,1,0,'C');
    $pdf->Cell(25,8,$row->prenumec,1,0,'C');
    $pdf->Cell(37,8,$row->vin,1,0,'C');
    $pdf->Cell(20,8,$row->model,1,0,'C');
    $pdf->Cell(32,8,$row->codp,1,0,'C');
    $pdf->Cell(27,8,$row->denp,1,0,'C');
    $pdf->Cell(25,8,$row->angajat,1,0,'C');
    $pdf->Cell(20,8,$row->stare,1,0,'C');
    if ($row->garantie == 1)
        $pdf->Cell(20,8,"Da",1,0,'C');
    else
        $pdf->Cell(20,8,"Nu",1,0,'C');
    $pdf->Cell(25,8,$row->datas,1,0,'C');
    $pdf->Cell(20,8,$row->oras,1,1,'C');
}
$pdf->Output();