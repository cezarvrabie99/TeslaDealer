<?php
require "../connection.php";
require "../validation.php";
require "../select.php";
require "../header.php";

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);

if (!isset($_SESSION['user']) || $codlog != 4){
    header("location:../index.php");
}
if (!empty($connect)) {
    $stmt = $connect->prepare('SELECT * FROM angajat WHERE coda = :coda');
} else
    $stmt = null;

$stmt->bindValue('coda', $_GET['coda']);
$stmt->execute();
$ang = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_POST['act'])){
    if (isNameValid($_POST['numea']) && isNameValid($_POST['prenumea']) && isCNPValid($_POST['cnp'])
    && isPhoneValid($_POST['telefona']) && isEmailValid($_POST['emaila']) && isJudetValid($_POST['judet'])
    && isCountryCodeValid($_POST['tara'])){
        if (!empty($connect)) {
            $stmt = $connect->prepare('UPDATE angajat SET numea = :numea, prenumea = :prenumea, cnp = :cnp, 
                                  adresaa = :adresaa, telefona = :telefona, emaila = :emaila, localitate = :localitate, 
                   judet = :judet, tara = :tara, codf = :codf WHERE coda = :coda');
        }
        $arr = array(
            'numea' => $_POST['numea'],
            'prenumea' => $_POST['prenumea'],
            'cnp' => $_POST['cnp'],
            'adresaa' => $_POST['adresaa'],
            'telefona' => $_POST['telefona'],
            'emaila' => $_POST['emaila'],
            'localitate' => $_POST['localitate'],
            'judet' => $_POST['judet'],
            'tara' => $_POST['tara'],
            'codf' => selectFrom("select codf from functie where denf = '" . $_POST['functii'] . "';", 1),
            'coda' => $_POST['coda']
        );
        $stmt->execute($arr);
        try {
            logs($_SESSION['user'], $connect, $stmt->queryString, $arr);
        } catch (Exception $e) {
        }
        /*header("location:".$prev);*/
        if (isset($_SESSION['previous'])) {
            header('Location: '. $_SESSION['previous']);
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
    <?php echo "Cod angajat: ".$ang->coda; ?>
    <input name="coda" type="hidden" value="<?php echo $ang->coda; ?>">
    <input name="numea" type="text" placeholder="Nume" value="<?php echo $ang->numea?>">
    <input name="prenumea" type="text" placeholder="Prenume" value="<?php echo $ang->prenumea?>">
    <input name="cnp" type="text" placeholder="CNP" value="<?php echo $ang->cnp?>">
    <input name="adresaa" type="text" placeholder="Adresa" value="<?php echo $ang->adresaa?>">
    <input name="telefona" type="text" placeholder="Nr. de telefon" value="<?php echo $ang->telefona?>">
    <input name="emaila" type="text" placeholder="Email" value="<?php echo $ang->emaila?>">
    <input name="localitate" type="text" placeholder="Localitate" value="<?php echo $ang->localitate?>">
    <input name="judet" type="text" placeholder="Judet" value="<?php echo $ang->judet?>">
    <input name="tara" type="text" placeholder="Tara" value="<?php echo $ang->tara?>">
    <select id="combo" name="functii">
        <?php foreach (selectFrom("select denf from functie;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <script type='text/javascript'>
        $('#combo').val('<?php echo selectFrom("select denf from functie where codf = ".$ang->codf, 1)?>');
    </script>
    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
