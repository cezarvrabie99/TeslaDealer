<?php
require "../connection.php";
require "../select.php";
require "../validation.php";
require "../header.php";

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);
$_SESSION['previous'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['user']) || $codlog != 4){
    header("location:../index.php");
}
if (isset($_POST['adauga'])) {
    if (isVinValid($_POST['vin'])) {
        if ($_POST['garantie'])
            $garantie = 1;
        else
            $garantie = 0;
        if (!empty($connect)) {
            $sql = 'INSERT INTO service(codc, numec, prenumec, vin, model, codp, denp, angajat, stare, garantie, datas, oras) 
VALUES (:codc, :numec, :prenumec, :vin, :model, :codp, :denp, :angajat, :stare, :garantie, CURRENT_DATE , CURRENT_TIME )';

            $stmt = $connect->prepare($sql);
        } else {
            $stmt = null;
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
                'angajat' => $_SESSION['user'],
                'stare' => $_POST['status'],
                'garantie' => $garantie
            )
        );
        header("location:service.php");
    } else{
        $message = "Date Gresite";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("service", "cods", $_GET['cods']);
}
if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM service;');
else
    $stmt = null;
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript" src="../vanzare/getVanzare.js"></script>
    <title>Service</title>
</head>
<body>

<div id="nav-placeholder">

</div>

<script>
    $(function(){
        $("#nav-placeholder").load("../nav.html");
    });
</script>

<form id="prod" method="post" autocomplete="off">
    <label><?php echo "Logat cu ".$_SESSION['user'];?></label>
    <a href="../logout.php">Logout</a>
    <select id="combonumec" name="conbon">
        <?php foreach (selectFrom("select numec from client;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <select id="comboprenumec" name="conbop">
        <option>Selecteaza numele</option>
    </select>
    <input id="vin" name="vin" type="text" placeholder="VIN">
    <select id="combocodp" name="codp">
        <?php foreach (selectFrom("select codp from piese;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <input id="produs" name="prod" type="text" placeholder="Produs" value="<?php echo selectFrom("select denp from piese;", 1)?>" readonly>
    <select id="status" name="status">
        <option>In asteptare</option>
        <option>In reparatie</option>
        <option>Finalizata</option>
        <option>Ridicata</option>
    </select>
    <input name="garantie" id="garantie" type="checkbox" value="Garantie">
    <label for="garantie">Garantie</label>

    <input name="adauga" type="submit" value="Adauga">
    <div class="link">
        <a id="edit" href="../print.php?tab=service"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfService.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>
</form>

<table id="table">
    <tr>
        <th>Cod service</th>
        <th>Cod client</th>
        <th>Nume</th>
        <th>Prenume</th>
        <th>VIN</th>
        <th>Model</th>
        <th>Cod piesa</th>
        <th>Piesa</th>
        <th>Angajat</th>
        <th>Stare</th>
        <th>Garantie</th>
        <th>Data</th>
        <th>Ora</th>
    </tr>
    <?php while ($sv = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $sv->cods; ?></td>
            <td><?php echo $sv->codc; ?></td>
            <td><?php echo $sv->numec; ?></td>
            <td><?php echo $sv->prenumec; ?></td>
            <td><?php echo $sv->vin; ?></td>
            <td><?php echo $sv->model; ?></td>
            <td><?php echo $sv->codp; ?></td>
            <td><?php echo $sv->denp; ?></td>
            <td><?php echo $sv->angajat; ?></td>
            <td><?php echo $sv->stare; ?></td>
            <?php if ($sv->garantie == 1): ?>
                <td>Da</td>
            <?php else: ?>
                <td>Nu</td>
            <?php endif; ?>
            <td><?php echo $sv->datas; ?></td>
            <td><?php echo $sv->oras; ?></td>

            <td class="link">
                <a id="edit" href="../edit/editService.php?cods=<?php echo $sv->cods ?>">Editeaza</a>
                <a id="delete" href="service.php?cods=<?php echo $sv->cods ?>&action=delete">Sterge</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>