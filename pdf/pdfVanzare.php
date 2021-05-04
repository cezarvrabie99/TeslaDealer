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
    $res = $connect->prepare("SELECT * FROM vanzare");
} else
    $res = null;
$res->execute();


$pdf = new PDF("L","mm","A4", "Vanzari");
$offset = 17;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setTitle("Vanzari", 1);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont("Arial",'B',12);
$pdf->setX($offset);
$pdf->Cell(20,8,"Cod",1,0,'C',1);
$pdf->Cell(25,8,"Tip produs",1,0,'C',1);
$pdf->Cell(22,8,"Produs",1,0,'C',1);
$pdf->Cell(38,8,"Cod produs",1,0,'C',1);
$pdf->Cell(20,8,"Pret",1,0,'C',1);
$pdf->Cell(30,8,"Pret(cu TVA)",1,0,'C',1);
$pdf->Cell(25,8,"Nume",1,0,'C',1);
$pdf->Cell(25,8,"Prenume",1,0,'C',1);
$pdf->Cell(20,8,"Angajat",1,0,'C',1);
$pdf->Cell(20,8,"Data",1,0,'C',1);
$pdf->Cell(20,8,"Ora",1,1,'C',1);

$pdf->SetFont('Arial','',10);

while($row = $res->fetch(PDO::FETCH_OBJ))
{
    $pdf->setX($offset);
    $pdf->Cell(20,8,$row->codv,1,0,'C');
    $pdf->Cell(25,8,$row->tipprod,1,0,'C');
    $pdf->Cell(22,8,$row->prod,1,0,'C');
    if ($row->tipprod === "Autoturisme")
        $pdf->Cell(38,8,$row->vin,1,0,'C');
    else
        $pdf->Cell(38,8,$row->codp,1,0,'C');
    $pdf->Cell(20,8,$row->pret,1,0,'C');
    $pdf->Cell(30,8,$row->prettva,1,0,'C');
    $pdf->Cell(25,8,$row->numec,1,0,'C');
    $pdf->Cell(25,8,$row->prenumec,1,0,'C');
    $pdf->Cell(20,8,$row->angajat,1,0,'C');
    $pdf->Cell(20,8,$row->datav,1,0,'C');
    $pdf->Cell(20,8,$row->orav,1,1,'C');
}
$pdf->Output();