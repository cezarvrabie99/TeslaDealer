<?php
require("invoice.php");
require ("../connection.php");
require ("../select.php");

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);

if (!isset($_SESSION['user']) || $codlog != 4){
    header("location:../index.php");
}

if(!empty($connect))
    $vz = $connect->prepare("SELECT * FROM vanzare where codv = :codv");
else
    $vz = null;
$vz->bindValue('codv', $_GET['codv']);
$vz->execute();
$vz = $vz->fetch(PDO::FETCH_OBJ);

if ($vz->tipprod == "Autoturisme"){
    if(!empty($connect))
        $auto = $connect->prepare("SELECT * FROM autoturism where vin = '" . $vz->vin . "';");
    else
        $auto = null;
    $auto->execute();
    $auto = $auto->fetch(PDO::FETCH_OBJ);
    $pilot = ($auto->autopilot = 1) ? "Da" : "Nu";
    $codTitle = "VIN";
    $cod = $vz->vin;
    $product = $vz->prod . " " . $auto->versiune . "\n" .
        "Culoare: " . $auto->culoare . "\n" .
        "Jante: " . $auto->jante . "\n" .
        "Interior: " . $auto->interior . "\n" .
        "Autopilot: " . $pilot . "\n" .
        "Fabricatie: " . $auto->data_fab . "\n" .
        "Nr. usi: " . $auto->nr_usi . "\n" .
        "Tractiune: " . $auto->tractiune . "\n" .
        "Baterie: " . $auto->baterie . " kWh\n";
} else{
    if(!empty($connect))
        $ps = $connect->prepare("SELECT * FROM piese where codp = '" . $vz->codp . "';");
    else
        $ps = null;
    $ps->execute();
    $ps = $ps->fetch(PDO::FETCH_OBJ);
    $codTitle = "COD PRODUS";
    $cod = $vz->codp;
    $product = $vz->prod;
}

if(!empty($connect))
    $cl = $connect->prepare("SELECT * FROM client where codc = " . $vz->codc . ";");
else
    $cl = null;
$cl->execute();
$cl = $cl->fetch(PDO::FETCH_OBJ);

$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->Image("../img/tesla_t.png", 92, 2, 27, 25);
$pdf->setTitle("Factura" . $vz->codv);
$pdf->addCompany( "Tesla Motors Romania",
    "Calea Serban Voda\n" .
    "040201 Bucuresti\n".
    "Romania\n".
    "0712345678\n".
    "EUSales@teslamotors.com\n".
    "tesla.com");
$pdf->fact( "Factura ", $vz->codv);
$pdf->waterMark("Factura");
$pdf->addDate($vz->datav);
$pdf->addClient($vz->codc);
$pdf->addPageNumber("1");
$pdf->addClientAddress($cl->numec . " " .
    $cl->prenumec . "\n" .
    $cl->adresac . "\n" .
    $cl->localitate . ", " . $cl->judet . "\n" .
    $cl->tara . "\n" .
    $cl->telefonc . "\n" .
    $cl->emailc);
$pdf->addPaymentType("Virament bancar");
$pdf->addInvoiceDate($vz->datav);
$pdf->addNumTVA("RO123456789");

$cols=array("NR" => 10,
    "TIP" => 25,
    "PRODUS" => 65,
    $codTitle => 45,
    "BUC" => 10,
    "PRET(FARA TVA)" => 35);
$pdf->addCols($cols);
$cols=array("NR" => "C",
    "TIP" => "C",
    "PRODUS" => "L",
    $codTitle => "C",
    "BUC" => "C",
    "PRET(FARA TVA)" => "C");
$pdf->addLineFormat($cols);
$pdf->addLineFormat($cols);

$y    = 109;
$line = array("NR" => "1",
    "TIP" => $vz->tipprod,
    "PRODUS" => $product,
    $codTitle => $cod,
    "BUC" => "1",
    "PRET(FARA TVA)" => $vz->pret);
$size = $pdf->addLine($y, $line);
$y   += $size + 2;

$pdf->addTotal($vz->pret);
$pdf->addTotalTable();
$pdf->Output();