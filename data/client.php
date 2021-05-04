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
    if (isNameValid($_POST['numec']) && isNameValid($_POST['prenumec']) && isCNPValid($_POST['cnp'])
        && isPhoneValid($_POST['telefonc']) && isEmailValid($_POST['emailc']) && isJudetValid($_POST['judet'])
        && isCountryCodeValid($_POST['tara'])) {
        if (!empty($connect)) {
            $stmt = $connect->prepare('INSERT INTO client(numec, prenumec, cnp, adresac, telefonc, emailc, localitate, 
                     judet, tara) VALUES (:numec, :prenumec, :cnp, :adresac, :telefonc, :emailc, :localitate, :judet, :tara)');
        } else {
            $stmt = null;
        }
        $stmt->execute(
            array(
                'numec' => $_POST['numec'],
                'prenumec' => $_POST['prenumec'],
                'cnp' => $_POST['cnp'],
                'adresac' => $_POST['adresac'],
                'telefonc' => $_POST['telefonc'],
                'emailc' => $_POST['emailc'],
                'localitate' => $_POST['localitate'],
                'judet' => $_POST['judet'],
                'tara' => $_POST['tara']

            )
        );
        header("location:client.php");
    } else {
        $message = "Date Gresite";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("client", "codc", $_GET['codc']);
}
if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM client');
else
    $stmt = null;
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Clienti</title>
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
    <input name="numec" type="text" placeholder="Nume">
    <input name="prenumec" type="text" placeholder="Prenume">
    <input name="cnp" type="text" placeholder="CNP">
    <input name="adresac" type="text" placeholder="Adresa">
    <input name="telefonc" type="text" placeholder="Nr. de telefon">
    <input name="emailc" type="text" placeholder="Email">
    <input name="localitate" type="text" placeholder="Localitate">
    <input name="judet" type="text" placeholder="Judet">
    <input name="tara" type="text" placeholder="Tara">

    <input name="adauga" type="submit" value="Adauga">
</form>

<table id="table">
    <tr>
        <th>Cod client</th>
        <th>Nume</th>
        <th>Prenume</th>
        <th>CNP</th>
        <th>Adresa</th>
        <th>Telefon</th>
        <th>Email</th>
        <th>Localitate</th>
        <th>Judet</th>
        <th>Tara</th>
    </tr>
    <?php while ($cli = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $cli->codc; ?></td>
            <td><?php echo $cli->numec; ?></td>
            <td><?php echo $cli->prenumec; ?></td>
            <td><?php echo $cli->cnp; ?></td>
            <td><?php echo $cli->adresac; ?></td>
            <td><?php echo $cli->telefonc; ?></td>
            <td><?php echo $cli->emailc; ?></td>
            <td><?php echo $cli->localitate; ?></td>
            <td><?php echo $cli->judet; ?></td>
            <td><?php echo $cli->tara; ?></td>

            <td class="link">
                <a id="edit" href="../edit/editClient.php?codc=<?php echo $cli->codc ?>">Editeaza</a>
                <a id="delete" href="client.php?codc=<?php echo $cli->codc ?>&action=delete">Sterge</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>