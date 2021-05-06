<?php
require "../connection.php";
require "../validation.php";
require "../header.php";

session_start();
if (!isset($_SESSION['user'])){
    header("location:../index.php");
}
if (!empty($connect)) {
    $stmt = $connect->prepare('SELECT * FROM autoturism WHERE vin = :vin');
}
$stmt->bindValue('vin', $_GET['vin']);
/*$stmt->bindValue('vin', "5YJSA2DP1DFP26966");*/
$stmt->execute();
$auto = $stmt->fetch(PDO::FETCH_OBJ);

$models = array("Model S", "Model 3", "Model X", "Model Y");
$versionS = array("Long Range", "Plaid", "Plaid +");
$version3 = array("Standard Range Plus", "Long Range", "Performance");
$versionX = array("Long Range", "Plaid");
$versionY = array("Long Range", "Performance");
$colors = array("Alb", "Negru", "Argintiu", "Albastru", "Rosu");
$wheelsS = array("19'' Silver", "21'' Carbon");
$wheels3 = array("18'' Aero", "19'' Sport");
$wheelsX = array("20'' Silver", "22'' Black");
$wheelsY = array("19'' Silver", "20'' Black");
$interiorSX = array("Negru", "Alb", "Crem");
$interior3Y = array("Negru", "Alb");

$tempVersion = match ($auto->model) {
    "Model S" => $versionS,
    "Model 3" => $version3,
    "Model X" => $versionX,
    "Model Y" => $versionY
};

$tempWheels = match ($auto->model) {
    "Model S" => $wheelsS,
    "Model 3" => $wheels3,
    "Model X" => $wheelsX,
    "Model Y" => $wheelsY
};

$tempInterior = match ($auto->model){
    "Model S", "Model X" => $interiorSX,
    "Model 3", "Model Y" => $interior3Y
};

if ($auto->versiune == "Performance") {
    if ($auto->model == "Model 3")
        $tempWheels = array("20'' Black");
    if ($auto->model == "Model Y")
        $tempWheels = array("21'' Black");
}

if (isset($_POST['autopilot']))
    $autopilot = 1;
else
    $autopilot = 0;

if (isset($_POST['act'])){
    $stmt = $connect->prepare('UPDATE autoturism SET model = :model, versiune = :versiune, culoare = :culoare, 
                                  jante = :jante, interior = :interior, autopilot = :autopilot, data_fab = :data_fab, 
                      nr_usi = :nr_usi, tractiune = :tractiune, baterie = :baterie, preta = :preta, pretatva = :pretatva, 
                      stoc = :stoc WHERE vin = :vin');
    $stmt->bindValue('model', $_POST['model']);
    $stmt->bindValue('versiune', $_POST['versiune']);
    $stmt->bindValue('culoare', $_POST['culoare']);
    $stmt->bindValue('jante', $_POST['jante']);
    $stmt->bindValue('interior', $_POST['interior']);
    $stmt->bindValue('autopilot', $autopilot);
    $stmt->bindValue('data_fab', $_POST['data_fab']);
    $stmt->bindValue('nr_usi', $_POST['nr_usi']);
    $stmt->bindValue('tractiune', $_POST['tractiune']);
    $stmt->bindValue('baterie', $_POST['baterie']);
    $stmt->bindValue('preta', $_POST['preta']);
    $stmt->bindValue('pretatva', $_POST['pretatva']);
    $stmt->bindValue('stoc', $_POST['stoc']);
    $stmt->bindValue('vin', $_POST['vin']);
    $stmt->execute();
    if (isset($_SESSION['previous'])) {
        header('Location: '. $_SESSION['previous']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
    <script type="text/javascript" src="../auto/getAuto.js"></script>
</head>
<body>
<form id="prod" method="post">
    <?php echo "VIN: ".$auto->vin; ?>
    <input name="vin" type="hidden" value="<?php echo $auto->vin; ?>">

    <select name="model" id="model">
        <?php foreach ($models as $model): ?>
            <option><?=$model?></option>
        <?php endforeach; ?>
    </select>
    <script type='text/javascript'>
        $('#model').val('<?php echo $auto->model?>');
    </script>

    <select name="versiune" id="versiune">
        <?php foreach ($tempVersion as $version): ?>
            <option><?=$version?></option>
        <?php endforeach; ?>
    </select>
    <script type='text/javascript'>
        $('#versiune').val('<?php echo $auto->versiune?>');
    </script>

    <select name="culoare" id="culoare">
        <?php foreach ($colors as $color): ?>
            <option><?=$color?></option>
        <?php endforeach;?>
    </select>
    <script type='text/javascript'>
        $('#culoare').val('<?php echo $auto->culoare?>');
    </script>

    <select name="jante" id="jante">
        <?php foreach ($tempWheels as $wheel): ?>
            <option><?=$wheel ?></option>
        <?php endforeach; ?>
    </select>
    <script type='text/javascript'>
        $('#jante').val('<?php echo $auto->jante?>');
    </script>

    <select name="interior" id="interior">
        <?php foreach ($tempInterior as $int): ?>
            <option><?=$int?></option>
        <?php endforeach; ?>
    </select>
    <script type='text/javascript'>
        $('#interior').val('<?php echo $auto->interior?>');
    </script>

    <?php if ($auto->autopilot == 1): ?>
        <input name="autopilot" id="autopilot" type="checkbox" value="Autopilot" checked>
    <?php else: ?>
        <input name="autopilot" id="autopilot" type="checkbox" value="Autopilot">
    <?php endif; ?>
    <label for="autopilot">Autopilot</label>

    <input name="data_fab" id="data_fab" type="date" value="<?php echo $auto->data_fab; ?>">
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
    <input name="nr_usi" id="nr_usi" type="number" placeholder="Nr. usi" value="<?php echo $auto->nr_usi; ?>" readonly style="cursor: not-allowed">
    <input name="tractiune" id="tractiune" type="text" placeholder="Tractiune" value="<?php echo $auto->tractiune; ?>" readonly style="cursor: not-allowed">
    <input name="baterie" id="baterie" type="number" placeholder="Bateriei" value="<?php echo $auto->baterie; ?>" readonly style="cursor: not-allowed">
    <input name="preta" id="preta" type="number" placeholder="Pret(fara TVA)" value="<?php echo $auto->preta; ?>" onkeyup="addVat()">
    <input name="pretatva" id="pretatva" type="number" value="<?php echo $auto->pretatva; ?>" placeholder="Pret(cu TVA)" readonly>
    <script type='text/javascript'>
        function addVat() {
            let pret = document.getElementById("preta").value;
            document.getElementById("pretatva").value = eval(pret) + 0.19 * eval(pret);
        }
    </script>
    <input name="stoc" type="number" placeholder="Stoc" value="<?php echo $auto->stoc; ?>">

    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
