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
/*$stmt->bindValue('vin', $_GET['vin']);*/
$stmt->bindValue('vin', "5YJSA2DP1DFP26966");
$stmt->execute();
$auto = $stmt->fetch(PDO::FETCH_OBJ);

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
    $stmt->bindValue('autopilot', $_POST['autopilot']);
    $stmt->bindValue('data_fab', $_POST['data_fab']);
    $stmt->bindValue('nr_usi', $_POST['nr_usi']);
    $stmt->bindValue('tractiune', $_POST['tractiune']);
    $stmt->bindValue('baterie', $_POST['baterie']);
    $stmt->bindValue('preta', $_POST['preta']);
    $stmt->bindValue('pretatva', $_POST['pretatva']);
    $stmt->bindValue('stoc', $_POST['stoc']);
    $stmt->bindValue('vin', $_POST['vin']);
    $stmt->execute();
    header("location:ang.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
</head>
<body>
<form id="prod" method="post">
    <?php echo "VIN: ".$auto->vin; ?>
    <input name="vin" type="hidden" value="<?php echo $auto->vin; ?>">
    <input name="model" type="text" placeholder="Introduceti denumirea" value="<?php echo $auto->model?>">
    <input name="versiune" type="text" placeholder="Introduceti denumirea" value="<?php echo $auto->versiune?>">
    <input name="culoare" type="text" placeholder="Introduceti pretul" value="<?php echo $auto->culoare?>">
    <input name="jante" type="text" placeholder="Introduceti stocul" value="<?php echo $auto->jante?>">
    <input name="interior" type="text" placeholder="Introduceti UM" value="<?php echo $auto->interior?>">
    <input name="autopilot" type="text" placeholder="Introduceti denumirea" value="<?php echo $auto->autopilot?>">
    <input name="data_fab" type="text" placeholder="Introduceti pretul" value="<?php echo $auto->data_fab?>">
    <input name="nr_usi" type="text" placeholder="Introduceti stocul" value="<?php echo $auto->nr_usi?>">
    <input name="tractiune" type="text" placeholder="Introduceti UM" value="<?php echo $auto->tractiune?>">
    <input name="baterie" type="text" placeholder="Introduceti pretul" value="<?php echo $auto->baterie?>">
    <input name="preta" type="text" placeholder="Introduceti stocul" value="<?php echo $auto->preta?>">
    <input name="pretatva" type="text" placeholder="Introduceti UM" value="<?php echo $auto->pretatva?>">
    <input name="stoc" type="text" placeholder="Introduceti stocul" value="<?php echo $auto->stoc?>">
    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
