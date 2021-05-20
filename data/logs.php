<?php
require "../connection.php";
require "../select.php";
require "../validation.php";
require "../header.php";

session_start();

$codlog = selectFrom("select codf from utilizatori where username = '".$_SESSION['user']."'", 1);

if (!isset($_SESSION['user']) || $codlog != 4){
    header("location:../index.php");
}

if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM logs');
else
    $stmt = null;
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Loguri</title>
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
    <div class="link">
        <a id="edit" href="../print.php?tab=logs"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfLogs.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>
</form>

<table id="table">

    <tr>
        <th>Cod Log</th>
        <th>Username</th>
        <th>Actiune</th>
        <th>Comanda</th>
        <th>Data</th>
        <th>Ora</th>
        <th>Cod functie</th>
    </tr>
    <?php while ($log = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $log->codl; ?></td>
            <td><?php echo $log->username; ?></td>
            <td><?php echo $log->actiune; ?></td>
            <?php if (str_starts_with($log->actiune, "inserare Excel")): ?>
            <td><a href="../download.php?file=<?php echo $log->comanda?>"><?php echo $log->comanda; ?></a></td>
            <?php else: ?>
            <td><?php echo $log->comanda; ?></td>
            <?php endif; ?>
            <td><?php echo $log->datal; ?></td>
            <td><?php echo $log->oral; ?></td>
            <td><?php echo selectFrom("select denf from functie where codf = '" . $log->codf . "';", 1)?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>