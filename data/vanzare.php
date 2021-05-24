<?php
require "../connection.php";
require "../select.php";
require "../validation.php";
require "../header.php";

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);
$_SESSION['previous'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$allowed = array(4, 6, 7);
if (!isset($_SESSION['user']) || !in_array($codlog, $allowed)){
    header("location:../index.php");
}

if (isset($_POST['adauga'])) {
        if (!empty($connect)) {
            if ($_POST['tipprod'] == "Piese")
                $sql = 'INSERT INTO vanzare(tipprod, prod, codp, vin, pret, prettva, codc, numec, 
                    prenumec, angajat, datav, orav) VALUES (:tipprod, :prod, :cod, null, :pret, :prettva, :codc, :numec, 
                                                            :prenumec, :angajat, CURRENT_DATE, CURRENT_TIME)';
            else
                $sql = 'INSERT INTO vanzare(tipprod, prod, codp, vin, pret, prettva, codc, numec, 
                    prenumec, angajat, datav, orav) VALUES (:tipprod, :prod, null, :cod, :pret, :prettva, :codc, :numec, 
                                                            :prenumec, :angajat, CURRENT_DATE, CURRENT_TIME)';
            $stmt = $connect->prepare($sql);
        } else {
            $stmt = null;
        }
        $arr = array(
            'tipprod' => $_POST['tipprod'],
            'prod' => $_POST['prod'],
            'cod' => $_POST['codp'],
            'pret' => $_POST['pret'],
            'prettva' => $_POST['prettva'],
            'codc' => selectFrom("select codc from client where numec = '" . $_POST['conbon'] . "' and prenumec = '" . $_POST['conbop'] . "';", 1),
            'numec' => $_POST['conbon'],
            'prenumec' => $_POST['conbop'],
            'angajat' => $_SESSION['user']
        );
        $stmt->execute($arr);
        try {
            logs($_SESSION['user'], $connect, $stmt->queryString, $arr);
        } catch (Exception $e) {
        }
        header("location:vanzare.php");
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("vanzare", "codv", $_GET['codv'], $_SESSION['user']);
    header("location:vanzare.php");
}
if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM vanzare;');
else
    $stmt = null;
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript" src="../vanzare/getVanzare.js"></script>
    <title>Vanzare</title>
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
    });
</script>

<div id="prod">
<form method="post" autocomplete="off">
    <label><?php echo "Logat cu ".$_SESSION['user'];?></label>
    <a href="../logout.php">Logout</a>
    <select id="comboTip" name="tipprod">
        <option>Piese</option>
        <option>Autoturisme</option>
    </select>
    <select id="combocodp" name="codp">
        <?php foreach (selectFrom("select codp from piese;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>

    <input id="produs" name="prod" type="text" placeholder="Produs" value="<?php echo selectFrom("select denp from piese;", 1)?>" readonly>
    <input name="pret" id="pret" type="number" placeholder="Pret(fara TVA)" value="<?php echo selectFrom("select pretp from piese;", 1)?>" readonly>
    <input name="prettva" id="prettva" type="number" placeholder="Pret" value="<?php echo selectFrom("select pretptva from piese;", 1)?>" readonly>

    <select id="combonumec" name="conbon">
        <?php foreach (selectFrom("select numec from client;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <select id="comboprenumec" name="conbop">
        <option>Selecteaza numele</option>
    </select>
    <input name="adauga" type="submit" value="Adauga">
</form>

    <hr>

    <form method="post" action="../import.php?tab=vanzare" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xls,.xlsx">
        <input type="submit" value="Upload Excel">
    </form>

    <hr>

    <?php if ($codlog != 6):?>
    <div class="link">
        <a id="edit" href="../print.php?tab=vanzare"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfVanzare.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>

        <hr>

    <form method="post" autocomplete="off" action="chart.php?tab=vanzare" enctype="multipart/form-data">
        <select id="combo" name="data">
            <option>Tip produse</option>
            <option>Produse</option>
            <option>Angajati</option>
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
    <input type='text' id='searchTable' placeholder='Cautare'>
</div>

<table id="table">
    <thead>
    <tr>
        <th>Cod vanzare</th>
        <th>Tip Produs</th>
        <th>Produs</th>
        <th>Cod produs</th>
        <th>VIN</th>
        <th>Pret(fara TVA)</th>
        <th>Pret(cu TVA)</th>
        <th>Cod Client</th>
        <th>Nume</th>
        <th>Prenume</th>
        <th>Angajat</th>
        <th>Data</th>
        <th>Ora</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($vz = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $vz->codv; ?></td>
            <td><?php echo $vz->tipprod; ?></td>
            <td><?php echo $vz->prod; ?></td>
            <td><?php echo $vz->codp; ?></td>
            <td><?php echo $vz->vin; ?></td>
            <td><?php echo $vz->pret; ?></td>
            <td><?php echo $vz->prettva; ?></td>
            <td><?php echo $vz->codc; ?></td>
            <td><?php echo $vz->numec; ?></td>
            <td><?php echo $vz->prenumec; ?></td>
            <td><?php echo $vz->angajat; ?></td>
            <td><?php echo $vz->datav; ?></td>
            <td><?php echo $vz->orav; ?></td>

            <td class="link">
                <a id ="edit" href="../pdf/bill.php?codv=<?php echo $vz->codv ?>">Factura</a>
                <?php if ($codlog != 7):?>
                    <a id="edit" href="../edit/editVanzare.php?codv=<?php echo $vz->codv ?>">Editeaza</a>
                    <a id="delete" href="vanzare.php?codv=<?php echo $vz->codv ?>&action=delete">Sterge</a>
                <?php endif ?>
            </td>
        </tr>
    <?php endwhile; ?>
    <tr class='notFound' hidden>
        <td colspan='13'>Nu s-au gasit inregistrari!</td>
    </tr>
    </tbody>
</table>
</body>
</html>