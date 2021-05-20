<?php
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
require ("connection.php");
require "vendor/autoload.php";
require "select.php";
session_start();
$codlog = selectFrom("select codf from utilizatori where username = '" . $_SESSION['user'] . "';", 1);

if (!isset($_SESSION['user']) || $codlog != 4){
    header("location:index.php");
}

$tab = $_GET['tab'];

$sql = match ($tab) {
    "angajat" => "INSERT INTO angajat (numea, prenumea, cnp, adresaa, telefona, emaila, localitate, judet, tara, codf) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);",
    "autoturism" => "INSERT INTO autoturism (vin, model, versiune, culoare, jante, interior, autopilot, data_fab, nr_usi, 
                        tractiune, baterie, preta, pretatva, stoc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    "client" => "INSERT INTO client (numec, prenumec, cnp, telefonc, emailc, adresac, localitate, judet, tara) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);",
    "functie" => "INSERT INTO functie (denf, salariubrut, salariunet) VALUES (?, ?, ?);",
    "piese" => "INSERT INTO piese VALUES (?, ?, ?, ?);",
    "service" => "INSERT INTO service (codc, numec, prenumec, vin, model, codp, denp, angajat, stare, garantie, datas, oras) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE , CURRENT_TIME );",
    "utilizatori" => "INSERT INTO utilizatori (username, password, codf) VALUES (?, ?, ?);",
    "vanzare" => "INSERT INTO vanzare (tipprod, prod, codp, vin, pret, prettva, codc, numec, prenumec, angajat, datav, 
                     orav) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE , CURRENT_TIME );",
};

if (isset($_FILES['file'])){
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $allowed = array('xls', 'xlsx');

    if (in_array($file_ext, $allowed) && $file_error == 0 && $file_size < 30000000000000){
        $file_name_new = uniqid('', true) . '.' . $file_ext;
        $file_dest = 'upload/' . $file_name_new;
        if (move_uploaded_file($file_tmp, $file_dest)){
                $reader = new Xlsx();
                $spreadsheet = $reader->load($file_dest);
                $worksheet = $spreadsheet->getActiveSheet();

                foreach ($worksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                    $data = [];
                    foreach ($cellIterator as $cell) {
                        $data[] = $cell->getValue();
                    }
                    try {
                        $stmt = $connect->prepare($sql);
                        $stmt->execute($data);
                    } catch (Exception $ex) {
                        echo $ex->getMessage() . "<br>";
                    }
                    $stmt = null;
                }
            $stm = $connect->prepare("INSERT INTO logs (username, actiune, comanda, datal, oral, codf) VALUES (:username, :actiune, :comanda, CURRENT_DATE, CURRENT_TIME, :codf)");
            $stm->execute(array(
                "username" => $_SESSION['user'],
                "actiune" => "inserare Excel " . $tab,
                "comanda" => $file_name_new,
                "codf" => selectFrom("select codf from utilizatori where username = '" . $_SESSION['user'] . "';", 1)
            ));
            if (isset($_SESSION['previous'])) {
                header('Location: '. $_SESSION['previous']);
            }
            }
    } else{
        echo "ERROR";
    }
}