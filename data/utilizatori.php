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
if ($_GET['password'] == $_GET['password2']) {
    if (!empty($connect)) {
        $stmt = $connect->prepare('INSERT INTO utilizatori(username, password, codf) VALUES (:username, :password, :codf)');
    } else {
        $stmt = null;
    }
    $arr = array(
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'codf' => selectFrom("select codf from functie where denf = '" . $_POST['functii'] . "';", 1),
    );
    $stmt->execute($arr);
    try {
        logs($_SESSION['user'], $connect, $stmt->queryString, $arr);
    } catch (Exception $e) {
    }
    header("location:utilizatori.php");
} else {
    $message = "Parolele nu se potrivesc!";
    echo "<script type='text/javascript'>alert('$message');</script>";
}
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("utilizatori", "userid", $_GET['userid'], $_SESSION['user']);
    header("location:utilizatori.php");
}
if(!empty($connect))
    $stmt = $connect->prepare('SELECT * FROM utilizatori');
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
    <input name="username" type="text" placeholder="Denumire">
    <input name="password" id="pass" type="password" placeholder="Parola">
    <input type="checkbox" id="check" onmousedown="myFunction()" onmouseup="myFunction()">
    <input name="password2" type="password" placeholder="Confirmati">
    <select id="comboFuncii" name="functii">
        <?php foreach (selectFrom("select denf from functie;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <script>
        function myFunction() {
            let pw_ele = document.getElementById("pass");
            if (pw_ele.type === "password") {
                pw_ele.type = "text";
            } else {
                pw_ele.type = "password";
            }
        }
    </script>
    <input name="adauga" type="submit" value="Adauga">
</form>

    <form method="post" action="../import.php?tab=utilizatori" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xls,.xlsx">
        <input type="submit" value="Upload Excel">
    </form>

    <div class="link">
        <a id="edit" href="../print.php?tab=utilizatori"><img src="../img/excel.png" alt="Export Excel" title="Export Excel"></a>
        <a id="edit" href="../pdf/pdfUtilizatori.php"><img src="../img/pdf.png" alt="Export PDF" title="Export PDF"></a>
    </div>

    <form method="post" autocomplete="off" action="chart.php?tab=utilizatori" enctype="multipart/form-data">
        <select id="combo" name="data">
            <option>Functii</option>
        </select>
        <select id="combo" name="chart">
            <option>PieChart</option>
            <option>BarChart</option>
            <option>ColumnChart</option>
            <option>SteppedAreaChart</option>
        </select>
        <input name="gen" type="submit" value="Genereaza Chart">
    </form>

    <input type='text' id='searchTable' placeholder='Cautare'>
</div>

<table id="table">
    <thead>
    <tr>
        <th>Cod utilizator</th>
        <th>Username</th>
        <th>Parola</th>
        <th>Functie</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($usr = $stmt->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?php echo $usr->userid; ?></td>
            <td><?php echo $usr->username; ?></td>
            <td><?php echo $usr->password; ?></td>
            <td><?php echo selectFrom("select denf from functie where codf = '" . $usr->codf . "';", 1)?></td>

            <td class="link">
                <a id="edit" href="../edit/editUtilizatori.php?userid=<?php echo $usr->userid ?>">Editeaza</a>
                <a id="delete" href="utilizatori.php?userid=<?php echo $usr->userid ?>&action=delete">Sterge</a>
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