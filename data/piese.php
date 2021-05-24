<?php
require "../connection.php";
require "../select.php";
require "../validation.php";
require "../header.php";

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);
$_SESSION['previous'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$allowed = array(4, 6, 7, 1);
if (!isset($_SESSION['user']) || !in_array($codlog, $allowed)){
    header("location:../index.php");
}

if (isset($_POST['adauga'])) {
    if (!empty($connect)) {
        $stmt = $connect->prepare('INSERT INTO piese(codp, denp, pretp, pretptva) VALUES (:codp, :denp, :pretp, :pretptva)');
    } else {
        $stmt = null;
    }
    $arr = array(
        'codp' => $_POST['codp'],
        'denp' => $_POST['denp'],
        'pretp' => $_POST['pretp'],
        'pretptva' => $_POST['pretptva']
    );
    $stmt->execute($arr);
    try {
        logs($_SESSION['user'], $connect, $stmt->queryString, $arr);
    } catch (Exception $e) {
    }
    header("location:piese.php");
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("piese", "codp", "'".$_GET['codp']."'", $_SESSION['user']);
    header("location:piese.php");
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
        const cod = '<?php echo $codlog; ?>';
        if (cod == 4)
            $("#nav-placeholder").load("../nav/manager.html");
        else if (cod == 6 || cod == 7)
            $("#nav-placeholder").load("../nav/consilier.html");
        else if (cod == 1)
            $("#nav-placeholder").load("../nav/mecanic.html");
    });
</script>

<div id="prod">
    <label><?php echo "Logat cu ".$_SESSION['user'];?></label>
    <a href="../logout.php">Logout</a>
    <?php if ($codlog != 1): ?>
<form method="post" autocomplete="off">
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
</form>

    <hr>

    <form method="post" action="../import.php?tab=piese" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xls,.xlsx">
        <input type="submit" value="Upload Excel">
    </form>

    <hr>
    <?php if ($codlog != 6 && $codlog != 1):?>
    <div class="link">
        <a id="edit" href="../print.php?tab=piese"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfPiese.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>

        <hr>
    <?php endif;?>
    <?php endif;?>
    <input type='text' id='searchTable' placeholder='Cautare'>
</div>

<table id="table">
    <thead>
    <tr>
        <th>Cod piesa</th>
        <th>Denumire</th>
        <th>Pret(fara TVA)</th>
        <th>Pret(cu TVA)</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($ps = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $ps->codp; ?></td>
            <td><?php echo $ps->denp; ?></td>
            <td><?php echo $ps->pretp; ?></td>
            <td><?php echo $ps->pretptva; ?></td>

            <?php if ($codlog != 7 && $codlog != 1):?>
            <td class="link">
                <a id="edit" href="../edit/editPiese.php?codp=<?php echo $ps->codp ?>">Editeaza</a>
                <a id="delete" href="piese.php?codp=<?php echo $ps->codp ?>&action=delete">Sterge</a>
            </td>
            <?php endif ?>
        </tr>
    <?php endwhile; ?>
    <tr class='notFound' hidden>
        <td colspan='4'>Nu s-au gasit inregistrari!</td>
    </tr>
    </tbody>
</table>
</body>
</html>