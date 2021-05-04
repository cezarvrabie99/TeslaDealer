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
if (isNameValid($_POST['numea']) && isNameValid($_POST['prenumea']) && isCNPValid($_POST['cnp'])
    && isPhoneValid($_POST['telefona']) && isEmailValid($_POST['emaila']) && isJudetValid($_POST['judet'])
    && isCountryCodeValid($_POST['tara'])) {
    if (!empty($connect)) {
        $stmt = $connect->prepare('INSERT INTO angajat(numea, prenumea, cnp, adresaa, telefona, emaila, localitate, 
                     judet, tara, codf) VALUES (:numea, :prenumea, :cnp, :adresaa, :telefona, :emaila, :localitate, :judet, :tara, :codf)');
    } else {
        $stmt = null;
    }
    $stmt->execute(
        array(
            'numea' => $_POST['numea'],
            'prenumea' => $_POST['prenumea'],
            'cnp' => $_POST['cnp'],
            'adresaa' => $_POST['adresaa'],
            'telefona' => $_POST['telefona'],
            'emaila' => $_POST['emaila'],
            'localitate' => $_POST['localitate'],
            'judet' => $_POST['judet'],
            'tara' => $_POST['tara'],
            'codf' => selectFrom("select codf from functie where denf = '" . $_POST['functii'] . "';", 1)

        )
    );
    header("location:ang.php");
} else {
    $message = "Date Gresite";
    echo "<script type='text/javascript'>alert('$message');</script>";
}
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("angajat", "coda", $_GET['coda']);
}
if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM angajat');
else
    $stmt = null;
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Angajati</title>
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
    <input name="numea" type="text" placeholder="Nume">
    <input name="prenumea" type="text" placeholder="Prenume">
    <input name="cnp" type="text" placeholder="CNP">
    <input name="adresaa" type="text" placeholder="Adresa">
    <input name="telefona" type="text" placeholder="Nr. de telefon">
    <input name="emaila" type="text" placeholder="Email">
    <input name="localitate" type="text" placeholder="Localitate">
    <input name="judet" type="text" placeholder="Judet">
    <input name="tara" type="text" placeholder="Tara">
    <select id="combo" name="functii">
        <?php foreach (selectFrom("select denf from functie;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <input name="adauga" type="submit" value="Adauga">
</form>

<table id="table">
    <tr>
        <th>Cod angajat</th>
        <th>Nume</th>
        <th>Prenume</th>
        <th>CNP</th>
        <th>Adresa</th>
        <th>Telefon</th>
        <th>Email</th>
        <th>Localitate</th>
        <th>Judet</th>
        <th>Tara</th>
        <th>Functie</th>
    </tr>
    <?php
    while ($ang = $stmt->fetch(PDO::FETCH_OBJ)) {
        ?>
        <tr>
            <td><?php echo $ang->coda; ?></td>
            <td><?php echo $ang->numea; ?></td>
            <td><?php echo $ang->prenumea; ?></td>
            <td><?php echo $ang->cnp; ?></td>
            <td><?php echo $ang->adresaa; ?></td>
            <td><?php echo $ang->telefona; ?></td>
            <td><?php echo $ang->emaila; ?></td>
            <td><?php echo $ang->localitate; ?></td>
            <td><?php echo $ang->judet; ?></td>
            <td><?php echo $ang->tara; ?></td>
            <td><?php echo selectFrom("select denf from functie where codf = '" . $ang->codf . "';", 1)?></td>

            <td class="link">
                <?php if ($_SESSION['user'] == 'manager'):?> <!--pentru privilegii-->
                    <a id="edit" href="../edit/editAngajat.php?coda=<?php echo $ang->coda ?>">Editeaza</a>
                <?php endif ?>
                <a id="delete" href="ang.php?coda=<?php echo $ang->coda ?>&action=delete">Sterge</a>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>