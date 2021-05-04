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
        if (!empty($connect)) {
            $stmt = $connect->prepare('INSERT INTO functie(denf, salariubrut, salariunet) VALUES (:denf, :salariubrut, :salariunet)');
        } else {
            $stmt = null;
        }
        $stmt->execute(
            array(
                'denf' => $_POST['denf'],
                'salariubrut' => $_POST['salariubrut'],
                'salariunet' => $_POST['salariunet']
            )
        );
        header("location:functii.php");
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("functie", "codf", $_GET['codf']);
}
if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM functie');
else
    $stmt = null;
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Functii</title>
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
    <input name="denf" type="text" placeholder="Denumire">
    <input name="salariubrut" id="salariubrut" type="number" placeholder="Salariul brut" onkeyup="updateSal()">
    <input name="salariunet" id="salariunet" type="text" placeholder="Salariul net" readonly>
    <script type='text/javascript'>
        function updateSal() {
            let brut = document.getElementById("salariubrut").value;
            let net1 = brut - 0.25 * brut - 0.1 * brut;
            document.getElementById("salariunet").value = net1 - 0.1 * net1;
        }
    </script>

    <input name="adauga" type="submit" value="Adauga">
</form>

<table id="table">
    <tr>
        <th>Cod functie</th>
        <th>Denumire</th>
        <th>Salariul brut</th>
        <th>Salariul net</th>
    </tr>
    <?php while ($fc = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $fc->codf; ?></td>
            <td><?php echo $fc->denf; ?></td>
            <td><?php echo $fc->salariubrut; ?></td>
            <td><?php echo $fc->salariunet; ?></td>

            <td class="link">
                <a id="edit" href="../edit/editFunctie.php?codf=<?php echo $fc->codf ?>">Editeaza</a>
                <a id="delete" href="functii.php?codf=<?php echo $fc->codf ?>&action=delete">Sterge</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>