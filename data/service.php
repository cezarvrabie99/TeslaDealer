<?php
require "../connection.php";
require "../select.php";
require "../validation.php";
require "../header.php";

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);
$_SESSION['previous'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$allowed = array(4, 6, 7, 1);
if (!isset($_SESSION['user']) || !in_array($codlog, $allowed)){
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
        $arr = array(
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
        );
        $stmt->execute($arr);
        try {
            logs($_SESSION['user'], $connect, $stmt->queryString, $arr);
        } catch (Exception $e) {
        }
        header("location:service.php");
    } else{
        $message = "Date Gresite";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("service", "cods", $_GET['cods'], $_SESSION['user']);
    header("location:utilizatori.php");
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
        const cod = '<?php echo $codlog; ?>';
        if (cod == 4)
            $("#nav-placeholder").load("../nav/manager.html");
        else if (cod == 6 || cod == 7)
            $("#nav-placeholder").load("../nav/consilier.html");
        else if (cod == 1)
            $("#nav-placeholder").load("../nav/mecanic.html");
    });
</script>

<div id="prod">
    <label><?php echo "Logat cu ".$_SESSION['user'];?></label>
    <a href="../logout.php">Logout</a>
    <?php if ($codlog != 1): ?>
<form method="post" autocomplete="off">
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
</form>

    <hr>

    <form method="post" action="../import.php?tab=service" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xls,.xlsx">
        <input type="submit" value="Upload Excel">
    </form>

    <hr>

    <?php if ($codlog != 6 && $codlog != 1):?>
    <div class="link">
        <a id="edit" href="../print.php?tab=service"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfService.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>

        <hr>

        <form method="post" autocomplete="off" action="chart.php?tab=service" enctype="multipart/form-data">
            <select id="combo" name="data">
                <option>Modele</option>
                <option>Produse</option>
                <option>Angajati</option>
                <option>Stari</option>
                <option>Garantie</option>
            </select>
            <select id="combo" name="chart">
                <option>PieChart</option>
                <option>BarChart</option>
                <option>ColumnChart</option>
                <option>SteppedAreaChart</option>
            </select>
            <input name="gen" type="submit" value="Genereaza Chart">
        </form>
        <hr>
    <?php endif;?>
    <?php endif;?>
    <input type='text' id='searchTable' placeholder='Cautare'>
</div>

<table id="table">
    <thead>
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
    </thead>
    <tbody>
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

            <?php if ($codlog != 7):?>
            <td class="link">
                <a id="edit" href="../edit/editService.php?cods=<?php echo $sv->cods ?>">Editeaza</a>
                <?php if ($codlog != 1):?>
                    <a id="delete" href="service.php?cods=<?php echo $sv->cods ?>&action=delete">Sterge</a>
                <?php endif;?>
            </td>
            <?php endif?>
        </tr>
    <?php endwhile; ?>
    <tr class='notFound' hidden>
        <td colspan='13'>Nu s-au gasit inregistrari!</td>
    </tr>
    </tbody>
</table>
</body>
</html>