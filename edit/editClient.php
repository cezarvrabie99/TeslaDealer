<?php
require "../connection.php";
require "../validation.php";
require "../select.php";
require "../header.php";

session_start();
if (!isset($_SESSION['user'])){
    header("location:../index.php");
}
if (!empty($connect)) {
    $stmt = $connect->prepare('SELECT * FROM client WHERE codc = :codc');
} else
    $stmt = null;

$stmt->bindValue('codc', $_GET['codc']);
/*$stmt->bindValue('codc', 1);*/
$stmt->execute();
$cli = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_POST['act'])){
    if (isNameValid($_POST['numec']) && isNameValid($_POST['prenumec']) && isCNPValid($_POST['cnp'])
        && isPhoneValid($_POST['telefonc']) && isEmailValid($_POST['emailc']) && isJudetValid($_POST['judet'])
        && isCountryCodeValid($_POST['tara'])){
        if (!empty($connect)) {
            $stmt = $connect->prepare('UPDATE client SET numec = :numec, prenumec = :prenumec, cnp = :cnp, 
                                   telefonc = :telefonc, emailc = :emailc, adresac = :adresac, localitate = :localitate, 
                   judet = :judet, tara = :tara WHERE codc = :codc');
        }
        $arr = array(
            'numec' => $_POST['numec'],
            'prenumec' => $_POST['prenumec'],
            'cnp' => $_POST['cnp'],
            'telefonc' => $_POST['telefonc'],
            'emailc' => $_POST['emailc'],
            'adresac' => $_POST['adresac'],
            'localitate' => $_POST['localitate'],
            'judet' => $_POST['judet'],
            'tara' => $_POST['tara'],
            'codc' => $_POST['codc']
        );
        $stmt->execute($arr);
        try {
            logs($_SESSION['user'], $connect, $stmt->queryString, $arr);
        } catch (Exception $e) {
        }
        /*header("location:../data/client.php");*/
        if (isset($_SESSION['previous'])) {
            header('location:'. $_SESSION['previous']);
        }
    } else{
        $message = "Date Gresite";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
</head>
<body>
<form id="prod" method="post">
    <?php echo "Cod client: ".$cli->codc; ?>
    <input name="codc" type="hidden" value="<?php echo $cli->codc; ?>">
    <input name="numec" type="text" placeholder="Nume" value="<?php echo $cli->numec?>">
    <input name="prenumec" type="text" placeholder="Prenume" value="<?php echo $cli->prenumec?>">
    <input name="cnp" type="text" placeholder="CNP" value="<?php echo $cli->cnp?>">
    <input name="adresac" type="text" placeholder="Adresa" value="<?php echo $cli->adresac?>">
    <input name="telefonc" type="text" placeholder="Nr. de telefon" value="<?php echo $cli->telefonc?>">
    <input name="emailc" type="text" placeholder="Email" value="<?php echo $cli->emailc?>">
    <input name="localitate" type="text" placeholder="Localitate" value="<?php echo $cli->localitate?>">
    <input name="judet" type="text" placeholder="Judet" value="<?php echo $cli->judet?>">
    <input name="tara" type="text" placeholder="Tara" value="<?php echo $cli->tara?>">
    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
