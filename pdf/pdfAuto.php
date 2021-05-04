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
    $res = $connect->prepare("SELECT * FROM autoturism");
} else
    $res = null;
$res->execute();


$pdf = new PDF("L","mm","A4", "Autoturisme");
$offset = 5;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setTitle("Autoturisme", 1);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont("Arial",'B',12);
$pdf->setX($offset);
$pdf->Cell(38,8,"VIN",1,0,'C',1);
$pdf->Cell(18,8,"Model",1,0,'C',1);
$pdf->Cell(30,8,"Versiune",1,0,'C',1);
$pdf->Cell(17,8,"Culoare",1,0,'C',1);
$pdf->Cell(21,8,"Jante",1,0,'C',1);
$pdf->Cell(16,8,"Interior",1,0,'C',1);
$pdf->Cell(20,8,"Autopilot",1,0,'C',1);
$pdf->Cell(22,8,"Data fab",1,0,'C',1);
$pdf->Cell(15,8,"Nr usi",1,0,'C',1);
$pdf->Cell(20,8,"Tractiune",1,0,'C',1);
$pdf->Cell(15,8,"Baterie",1,0,'C',1);
$pdf->Cell(17,8,"Pret",1,0,'C',1);
$pdf->Cell(28,8,"Pret(cu TVA)",1,0,'C',1);
$pdf->Cell(10,8,"Stoc",1,1,'C',1);

$pdf->SetFont('Arial','',10);

while($row = $res->fetch(PDO::FETCH_OBJ))
{
    $pdf->setX($offset);
    $pdf->Cell(38,8,$row->vin,1,0,'C');
    $pdf->Cell(18,8,$row->model,1,0,'C');
    $pdf->Cell(30,8,$row->versiune,1,0,'C');
    $pdf->Cell(17,8,$row->culoare,1,0,'C');
    $pdf->Cell(21,8,$row->jante,1,0,'C');
    $pdf->Cell(16,8,$row->interior,1,0,'C');
    if ($row->autopilot == 1)
        $pdf->Cell(20,8,"Da",1,0,'C');
    else
        $pdf->Cell(20,8,"Nu",1,0,'C');
    $pdf->Cell(22,8,$row->data_fab,1,0,'C');
    $pdf->Cell(15,8,$row->nr_usi,1,0,'C');
    $pdf->Cell(20,8,$row->tractiune,1,0,'C');
    $pdf->Cell(15,8,$row->baterie,1,0,'C');
    $pdf->Cell(17,8,$row->preta,1,0,'C');
    $pdf->Cell(28,8,$row->pretatva,1,0,'C');
    $pdf->Cell(10,8,$row->stoc,1,1,'C');
}
$pdf->Output();