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
        $stmt = $connect->prepare('INSERT INTO piese(codp, denp, pretp, pretptva) VALUES (:codp, :denp, :pretp, :pretptva)');
    } else {
        $stmt = null;
    }
    $stmt->execute(
        array(
            'codp' => $_POST['codp'],
            'denp' => $_POST['denp'],
            'pretp' => $_POST['pretp'],
            'pretptva' => $_POST['pretptva']
        )
    );
    header("location:piese.php");
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("piese", "codp", "'".$_GET['codp']."'");
}
if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM piese');
else
    $stmt = null;
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Piese</title>
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
    <input name="codp" type="text" placeholder="Cod piesa">
    <input name="denp" type="text" placeholder="Denumire">
    <input name="pretp" id="pretp" type="number" placeholder="Pret(fara TVA)" onkeyup="addVat()">
    <input name="pretptva" id="pretptva" type="text" placeholder="Pret(cu TVA)" readonly>
    <script type='text/javascript'>
        function addVat() {
            let pret = document.getElementById("pretp").value;
            document.getElementById("pretptva").value = eval(pret) + 0.19 * eval(pret);
        }
    </script>

    <input name="adauga" type="submit" value="Adauga">
    <div class="link">
        <a id="edit" href="../print.php?tab=piese"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfPiese.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>
</form>

<table id="table">
    <tr>
        <th>Cod piesa</th>
        <th>Denumire</th>
        <th>Pret(fara TVA)</th>
        <th>Pret(cu TVA)</th>
    </tr>
    <?php while ($ps = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $ps->codp; ?></td>
            <td><?php echo $ps->denp; ?></td>
            <td><?php echo $ps->pretp; ?></td>
            <td><?php echo $ps->pretptva; ?></td>

            <td class="link">
                <a id="edit" href="../edit/editPiese.php?codp=<?php echo $ps->codp ?>">Editeaza</a>
                <a id="delete" href="piese.php?codp=<?php echo $ps->codp ?>&action=delete">Sterge</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>