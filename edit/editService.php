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
    $stmt = $connect->prepare('SELECT * FROM service WHERE cods = :cods');
} else
    $stmt = null;

$stmt->bindValue('cods', $_GET['cods']);
/*$stmt->bindValue('cods', 2);*/
$stmt->execute();
$sv = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_POST['act'])){
    if (isVinValid($_POST['vin'])) {
        if (isset($_POST['garantie']))
            $garantie = 1;
        else
            $garantie = 0;
        if (!empty($connect)) {
            $stmt = $connect->prepare('UPDATE service SET codc = :codc, numec = :numec, prenumec = :prenumec, 
                   vin = :vin, model = :model, codp = :codp, denp = :denp, stare = :stare, garantie = :garantie WHERE cods = :cods');
        }
        $stmt->execute(
            array(
                'codc' => selectFrom("select codc from client where numec = '" . $_POST['conbon'] . "' and prenumec = '" . $_POST['conbop'] . "';", 1),
                'numec' => $_POST['conbon'],
                'prenumec' => $_POST['conbop'],
                'vin' => $_POST['vin'],
                'model' => getModel($_POST['vin']),
                'codp' => $_POST['codp'],
                'denp' => $_POST['prod'],
                'stare' => $_POST['status'],
                'garantie' => $garantie,
                'cods' => $_POST['cods']
            )
        );
        if (isset($_SESSION['previous'])) {
            header('location:' . $_SESSION['previous']);
        }
    } else{
        $message = "VIN gresit";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
    <script type="text/javascript" src="../vanzare/getVanzare.js"></script>
</head>
<body>
<form id="prod" method="post">
    <?php echo "Cod service: ".$sv->cods; ?>
    <input name="cods" type="hidden" value="<?php echo $sv->cods; ?>">
    <select id="combonumec" name="conbon">
        <?php foreach (selectFrom("select numec from client;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <script type="text/javascript">
        $("#combonumec").val('<?php echo selectFrom("select numec from service where cods = " . $sv->cods, 1)?>')
    </script>

    <select id="comboprenumec" name="conbop">
        <?php foreach (selectFrom("select prenumec from service where cods = " . $sv->cods, 2) as $row): ?>
        <option><?=$row[0]?></option>
        <?php endforeach; ?>
    </select>
    <script type="text/javascript">
        $("#comboprenumec").val('<?php echo selectFrom("select prenumec from service where cods = " . $sv->cods, 1)?>')
    </script>

    <input id="vin" name="vin" type="text" placeholder="VIN" value="<?php echo $sv->vin; ?>">
    <select id="combocodp" name="codp">
        <?php foreach (selectFrom("select codp from piese;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <script type="text/javascript">
        $("#combocodp").val('<?php echo selectFrom("select codp from service where cods = " . $sv->cods, 1)?>')
    </script>

    <input id="produs" name="prod" type="text" placeholder="Produs" value="<?php echo $sv->denp?>" readonly>
    <select id="status" name="status">
        <option>In asteptare</option>
        <option>In reparatie</option>
        <option>Finalizata</option>
        <option>Ridicata</option>
    </select>
    <script type="text/javascript">
        $("#status").val('<?php echo selectFrom("select stare from service where cods = " . $sv->cods, 1)?>')
    </script>

    <?php if ($sv->garantie == 1): ?>
        <input name="garantie" id="garantie" type="checkbox" value="Garantie" checked>
    <?php else: ?>
        <input name="garantie" id="garantie" type="checkbox" value="Garantie">
    <?php endif; ?>
    <label for="garantie">Garantie</label>
    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
