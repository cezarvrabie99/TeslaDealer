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
</form>

<table id="table">

    <tr>
        <th>Cod Log</th>
        <th>Username</th>
        <th>Data</th>
        <th>Ora</th>
        <th>Cod functie</th>
    </tr>
    <?php while ($log = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $log->codl; ?></td>
            <td><?php echo $log->username; ?></td>
            <td><?php echo $log->datal; ?></td>
            <td><?php echo $log->oral; ?></td>
            <td><?php echo $log->codf; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>