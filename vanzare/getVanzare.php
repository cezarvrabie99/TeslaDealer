<?php
require "../select.php";

if (isset($_POST['type'])){
    if ($_POST['type'] == "Piese"){
        echo json_encode(selectFrom("select codp from piese;", 2));
    } else if ($_POST['type'] == "Autoturisme"){
        echo json_encode(selectFrom("select vin from autoturism where stoc > 0;", 2));
    }
}

if (isset($_POST['typeS']) && isset($_POST['codpS'])){
    if ($_POST['typeS'] == "Piese"){
        echo json_encode(selectFrom("select denp, pretp, pretptva from piese where codp = '" . $_POST['codpS'] . "';", 2));
    } else if ($_POST['typeS'] == "Autoturisme"){
        echo json_encode(selectFrom("select model, preta, pretatva from autoturism where vin = '" . $_POST['codpS'] . "';", 2));
    }
}

if (isset($_POST['numec'])){
    echo json_encode(selectFrom("select prenumec from client where numec = '" . $_POST['numec'] . "';", 2));
}