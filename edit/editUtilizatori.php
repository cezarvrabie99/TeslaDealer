<?php
require "../connection.php";
require "../validation.php";
require "../select.php";
require "../calc.php";
require "../header.php";

session_start();
if (!isset($_SESSION['user'])){
    header("location:../index.php");
}
if (!empty($connect)) {
    $stmt = $connect->prepare('SELECT * FROM utilizatori WHERE userid = :userid');
} else
    $stmt = null;

$stmt->bindValue('userid', $_GET['userid']);
/*$stmt->bindValue('userid', 3);*/
$stmt->execute();
$usr = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_POST['act'])){
    if ($_GET['password'] == $_GET['password2']) {
        if (!empty($connect)) {
            $stmt = $connect->prepare('UPDATE utilizatori SET username = :username, password = :password, codf = :codf 
                                   WHERE userid = :userid');
        }
        $stmt->execute(
            array(
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'codf' => selectFrom("select codf from functie where denf = '" . $_POST['functii'] . "';", 1),
                'userid' => $_POST['userid']
            )
        );
        if (isset($_SESSION['previous'])) {
            header('Location: '. $_SESSION['previous']);
        }
    } else{
        $message = "Parolele nu se potrivesc!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
</head>
<body>
<form id="prod" method="post">
    <?php echo "Cod utilizator: ".$usr->userid; ?>
    <input name="userid" type="hidden" value="<?php echo $usr->userid; ?>">
    <input name="username" type="text" placeholder="Utilizator" value="<?php echo $usr->username?>">
    <input name="password" id="pass" type="password" placeholder="Parola" value="<?php echo $usr->password?>">
    <input type="checkbox" id="check" onmousedown="myFunction()" onmouseup="myFunction()">
    <input name="password2" type="password" placeholder="Confirmati">
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
    <select id="combo" name="functii">
        <?php foreach (selectFrom("select denf from functie;", 2) as $row): ?>
            <option><?=$row[0]?></option>
        <?php endforeach ?>
    </select>
    <script type='text/javascript'>
        $('#combo').val('<?php echo selectFrom("select denf from functie where codf = ".$usr->codf, 1)?>');
    </script>
    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
