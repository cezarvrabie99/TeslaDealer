<?php
require "../connection.php";
require "../validation.php";
require "../select.php";
require "../calc.php";
require "../header.php";

session_start();
if (!isset($_SESSION['user'])){
    header("location:../index.php");
}
if (!empty($connect)) {
    $stmt = $connect->prepare('SELECT * FROM vanzare WHERE codv = :codv');
} else
    $stmt = null;

$stmt->bindValue('codv', $_GET['codv']);
/*$stmt->bindValue('codv', 2);*/
$stmt->execute();
$vz = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_POST['act'])){
    if (!empty($connect)) {
        if ($_POST['tipprod'] == "Piese")
            $sql = 'UPDATE vanzare SET tipprod = :tipprod, prod = :prod, codp = :cod, vin = null, 
                   pret = :pret, prettva = :prettva, codc = :codc, numec = :numec, prenumec = :prenumec WHERE codv = :codv';
        else
            $sql = 'UPDATE vanzare SET tipprod = :tipprod, prod = :prod, codp = null, vin = :cod, 
                   pret = :pret, prettva = :prettva, codc = :codc, numec = :numec, prenumec = :prenumec WHERE codv = :codv';

        $stmt = $connect->prepare($sql);
    }
    $stmt->execute(
        array(
            'tipprod' => $_POST['tipprod'],
            'prod' => $_POST['prod'],
            'cod' => $_POST['codp'],
            'pret' => $_POST['pret'],
            'prettva' => $_POST['prettva'],
            'codc' => selectFrom("select codc from client where numec = '" . $_POST['conbon'] . "' and prenumec = '" . $_POST['conbop'] . "';", 1),
            'numec' => $_POST['conbon'],
            'prenumec' => $_POST['conbop'],
            'codv' => $_POST['codv']
        )
    );
    if (isset($_SESSION['previous'])) {
        header('Location: '. $_SESSION['previous']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript" src="../vanzare/getVanzare.js"></script>
    <title>Edit</title>
</head>
<body>
<form id="prod" method="post">
    <?php echo "Cod vanzare: ".$vz->codv; ?>
    <input name="codv" type="hidden" value="<?php echo $vz->codv; ?>">
    <select id="comboTip" name="tipprod">
        <option>Piese</option>
        <option>Autoturisme</option>
    </select>
    <script type='text/javascript'>
        $('#comboTip').val('<?php echo selectFrom("select tipprod from vanzare where codv = ".$vz->codv, 1)?>');
    </script>

    <select id="combocodp" name="codp">
        <?php
        $prodType = selectFrom("select tipprod from vanzare where codv = ".$vz->codv, 1);
        if ($prodType === "Autoturisme")
            $products = selectFrom("select vin from autoturism where stoc > 0;", 2);
        else
            $products = selectFrom("select codp from piese;", 2);
        foreach ($products as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <script type='text/javascript'>
        $('#combocodp').val('<?php
            if ($prodType === "Autoturisme")
                echo selectFrom("select vin from vanzare where codv = ".$vz->codv, 1);
            else
                echo selectFrom("select codp from vanzare where codv = ".$vz->codv, 1);?>');
    </script>

    <input id="produs" name="prod" type="text" placeholder="Produs" value="<?php echo $vz->prod?>" readonly>
    <input name="pret" id="pret" type="number" placeholder="Pret(fara TVA)" value="<?php echo $vz->pret?>" readonly>
    <input name="prettva" id="prettva" type="number" placeholder="Pret" value="<?php echo $vz->prettva?>" readonly>
    <select id="combonumec" name="conbon">
        <?php foreach (selectFrom("select numec from client;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <script type='text/javascript'>
        $('#combonumec').val('<?php echo selectFrom("select numec from vanzare where codv = " . $vz->codv, 1)?>');
    </script>

    <select id="comboprenumec" name="conbop">
        <?php foreach (selectFrom("select prenumec from client where numec = (select numec from vanzare where codv = " . $vz->codv . ");", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <script type='text/javascript'>
        $('#comboprenumec').val('<?php echo selectFrom("select prenumec from vanzare where codv = ".$vz->codv, 1)?>');
    </script>

    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
