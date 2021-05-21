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
    if (isSalaryValid($_POST['salariubrut'])) {
        if (!empty($connect)) {
            $stmt = $connect->prepare('INSERT INTO functie(denf, salariubrut, salariunet) VALUES (:denf, :salariubrut, :salariunet)');
        } else {
            $stmt = null;
        }
        $arr = array(
            'denf' => $_POST['denf'],
            'salariubrut' => $_POST['salariubrut'],
            'salariunet' => $_POST['salariunet']
        );
        $stmt->execute($arr);
        try {
            logs($_SESSION['user'], $connect, $stmt->queryString, $arr);
        } catch (Exception $e) {
        }
        header("location:functii.php");
    } else{
        $message = "Date Gresite";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("functie", "codf", $_GET['codf'], $_SESSION['user']);
    header("location:utilizatori.php");
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
        $("#nav-placeholder").load("../nav/manager.html");
    });
</script>

<div id="prod">
<form method="post" autocomplete="off">
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

    <form method="post" action="../import.php?tab=functie" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xls,.xlsx">
        <input type="submit" value="Upload Excel">
    </form>

    <div class="link">
        <a id="edit" href="../print.php?tab=functie"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfFunctii.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>
    <input type='text' id='searchTable' placeholder='Cautare'>
</div>

<table id="table">
    <thead>
    <tr>
        <th>Cod functie</th>
        <th>Denumire</th>
        <th>Salariul brut</th>
        <th>Salariul net</th>
    </tr>
    </thead>
    <tbody>
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
    <tr class='notFound' hidden>
        <td colspan='4'>Nu s-au gasit inregistrari!</td>
    </tr>
    </tbody>
</table>
</body>
</html>