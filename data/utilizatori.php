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
    $stmt->execute(
        array(
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'codf' => selectFrom("select codf from functie where denf = '" . $_POST['functii'] . "';", 1),
        )
    );
    header("location:utilizatori.php");
} else {
    $message = "Parolele nu se potrivesc!";
    echo "<script type='text/javascript'>alert('$message');</script>";
}
}

if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    deleteFrom("utilizatori", "userid", $_GET['userid']);
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
        $("#nav-placeholder").load("../nav.html");
    });
</script>

<form id="prod" method="post" autocomplete="off">
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

<table id="table">
    <tr>
        <th>Cod utilizator</th>
        <th>Username</th>
        <th>Parola</th>
        <th>Functie</th>
    </tr>
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
</table>
</body>
</html>