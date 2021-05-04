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
    $res = $connect->prepare("SELECT * FROM angajat");
} else
    $res = null;
$res->execute();


$pdf = new PDF("L","mm","A4", "Angajati");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setTitle("Angajati", 1);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont("Arial",'B',12);
$pdf->Cell(20,8,"Cod",1,0,'C',1);
$pdf->Cell(20,8,"Nume",1,0,'C',1);
$pdf->Cell(20,8,"Prenume",1,0,'C',1);
$pdf->Cell(40,8,"CNP",1,0,'C',1);
$pdf->Cell(35,8,"Adresa",1,0,'C',1);
$pdf->Cell(25,8,"Telefon",1,0,'C',1);
$pdf->Cell(45,8,"Email",1,0,'C',1);
$pdf->Cell(25,8,"Localitate",1,0,'C',1);
$pdf->Cell(15,8,"Judet",1,0,'C',1);
$pdf->Cell(10,8,"Tara",1,0,'C',1);
$pdf->Cell(20,8,"Functie",1,1,'C',1);

$pdf->SetFont('Arial','',10);

while($row = $res->fetch(PDO::FETCH_OBJ))
{
    $pdf->Cell(20,8,$row->coda,1,0,'C');
    $pdf->Cell(20,8,$row->numea,1,0,'C');
    $pdf->Cell(20,8,$row->prenumea,1,0,'C');
    $pdf->Cell(40,8,$row->cnp,1,0,'C');
    $pdf->Cell(35,8,$row->adresaa,1,0,'C');
    $pdf->Cell(25,8,$row->telefona,1,0,'C');
    $pdf->Cell(45,8,$row->emaila,1,0,'C');
    $pdf->Cell(25,8,$row->localitate,1,0,'C');
    $pdf->Cell(15,8,$row->judet,1,0,'C');
    $pdf->Cell(10,8,$row->tara,1,0,'C');
    $pdf->Cell(20,8,selectFrom("select denf from functie where codf = '" . $row->codf . "';", 1),1,1,'C');
}
$pdf->Output();