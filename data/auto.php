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
    if (isVINValid($_POST['vin']) && getModel($_POST['vin']) == $_POST['model'] && $_POST['stoc'] >= 0) {
        if ($_POST['$autopilot'])
            $autopilot = 1;
        else
            $autopilot = 0;
        if (!empty($connect)) {
            $stmt = $connect->prepare('INSERT INTO autoturism (vin, model, versiune, culoare, jante, interior, 
                    autopilot, data_fab, nr_usi, tractiune, baterie, preta, pretatva, stoc) VALUES (:vin, :model, :versiune, 
                    :culoare, :jante, :interior, :autopilot, :data_fab, :nr_usi, :tractiune, :baterie, :preta, :pretatva, :stoc)');
        } else {
            $stmt = null;
        }
        $stmt->execute(
            array(
                'vin' => $_POST['vin'],
                'model' => $_POST['model'],
                'versiune' => $_POST['versiune'],
                'culoare' => $_POST['culoare'],
                'jante' => $_POST['jante'],
                'interior' => $_POST['interior'],
                'autopilot' => $autopilot,
                'data_fab' => $_POST['data_fab'],
                'nr_usi' => $_POST['nr_usi'],
                'tractiune' => $_POST['tractiune'],
                'baterie' => $_POST['baterie'],
                'preta' => $_POST['preta'],
                'pretatva' => $_POST['pretatva'],
                'stoc' => $_POST['stoc']
            )
        );
        header("location:auto.php");
    } else {
        $message = "Date Gresite";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("autoturism", "vin", $_GET['vin'], $_SESSION['user']);
    header("location:utilizatori.php");
}
if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM autoturism');
else
    $stmt = null;
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Autoturisme</title>
    <script type="text/javascript" src="../auto/getAuto.js"></script>
</head>
<body>

<div id="nav-placeholder">

</div>

<script>
    $(function(){
        $("#nav-placeholder").load("../nav.html");
    });
</script>

<div id="prod">
<form method="post" autocomplete="off">
    <label><?php echo "Logat cu ".$_SESSION['user'];?></label>
    <a href="../logout.php">Logout</a>
    <input name="vin" type="text" placeholder="VIN">
    <select name="model" id="model">
        <option>Model S</option>
        <option>Model 3</option>
        <option>Model X</option>
        <option>Model Y</option>
    </select>
    <select name="versiune" id="versiune">
        <option>Long Range</option>
        <option>Plaid</option>
        <option>Plaid +</option>
    </select>
    <select name="culoare" id="culoare">
        <option>Alb</option>
        <option>Negru</option>
        <option>Gri</option>
        <option>Albastru</option>
        <option>Rosu</option>
    </select>
    <select name="jante" id="jante">
        <option>19'' Silver</option>
        <option>21'' Carbon</option>
    </select>
    <select name="interior" id="interior">
        <option>Negru</option>
        <option>Alb</option>
        <option>Crem</option>
    </select>

    <input name="autopilot" id="autopilot" type="checkbox" value="Autopilot">
    <label for="autopilot">Autopilot</label>

    <input name="data_fab" id="data_fab" type="date">
    <script type="text/javascript">
        $(function() {
            $(document).ready(function () {
                let todaysDate = new Date();
                let year = todaysDate.getFullYear();
                let month = ("0" + (todaysDate.getMonth() + 1)).slice(-2);
                let day = ("0" + todaysDate.getDate()).slice(-2);
                let maxDate = (year +"-"+ month +"-"+ day);
                $('#data_fab').attr('max',maxDate);
            });
        });
    </script>
    <input name="nr_usi" id="nr_usi" type="number" placeholder="Nr. usi" value="5" readonly style="cursor: not-allowed">
    <input name="tractiune" id="tractiune" type="text" placeholder="Tractiune" value="Integrala" readonly style="cursor: not-allowed">
    <input name="baterie" id="baterie" type="number" placeholder="Bateriei" value="100" readonly style="cursor: not-allowed">
    <input name="preta" id="preta" type="number" placeholder="Pret(fara TVA)" onkeyup="addVat()">
    <input name="pretatva" id="pretatva" type="text" placeholder="Pret(cu TVA)" readonly>
    <script type='text/javascript'>
        function addVat() {
            let pret = document.getElementById("preta").value;
            document.getElementById("pretatva").value = eval(pret) + 0.19 * eval(pret);
        }
    </script>
    <input name="stoc" type="number" placeholder="Stoc">
    <input name="adauga" type="submit" value="Adauga">
</form>
    <form method="post" action="../import.php?tab=autoturism" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xls,.xlsx">
        <input type="submit" value="Upload Excel">
    </form>

    <div class="link">
        <a id="edit" href="../print.php?tab=autoturism"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfAuto.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>
</div>

<table id="table">
    <tr>
        <th>VIN</th>
        <th>Model</th>
        <th>Versiune</th>
        <th>Culoare</th>
        <th>Jante</th>
        <th>Interior</th>
        <th>Autopilot</th>
        <th>Data fab</th>
        <th>Nr usi</th>
        <th>Tractiune</th>
        <th>Baterie</th>
        <th>Pret</th>
        <th>Pret(cu TVA)</th>
        <th>Stoc</th>
    </tr>
    <?php
    while ($auto = $stmt->fetch(PDO::FETCH_OBJ)) {
        ?>
        <tr>
            <td><?php echo $auto->vin; ?></td>
            <td><?php echo $auto->model; ?></td>
            <td><?php echo $auto->versiune; ?></td>
            <td><?php echo $auto->culoare; ?></td>
            <td><?php echo $auto->jante; ?></td>
            <td><?php echo $auto->interior; ?></td>
            <?php if ($auto->autopilot == 1): ?>
                <td>Da</td>
            <?php else: ?>
                <td>Nu</td>
            <?php endif; ?>
            <td><?php echo $auto->data_fab; ?></td>
            <td><?php echo $auto->nr_usi; ?></td>
            <td><?php echo $auto->tractiune; ?></td>
            <td><?php echo $auto->baterie; ?></td>
            <td><?php echo $auto->preta; ?></td>
            <td><?php echo $auto->pretatva; ?></td>
            <td><?php echo $auto->stoc; ?></td>
            <td class="link">
                <?php if ($_SESSION['user'] == 'manager'):?> <!--pentru privilegii-->
                    <a id="edit" href="../edit/editAutoturism.php?vin=<?php echo $auto->vin ?>">Editeaza</a>
                <?php endif ?>
                <a id="delete" href="ang.php?vin=<?php echo $auto->vin ?>&action=delete">Sterge</a>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>