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
    $stmt = $connect->prepare('SELECT * FROM piese WHERE codp = :codp');
} else
    $stmt = null;

$stmt->bindValue('codp', $_GET['codp']);
/*$stmt->bindValue('codp', "BS-9248HC");*/
$stmt->execute();
$ps = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_POST['act'])){
    if (!empty($connect)) {
        $stmt = $connect->prepare('UPDATE piese SET denp = :denp, pretp = :pretp, pretptva = :pretptva 
                                   WHERE codp = :codp');
    }
    $stmt->execute(
        array(
            'denp' => $_POST['denp'],
            'pretp' => $_POST['pretp'],
            'pretptva' => $_POST['pretptva'],
            'codp' => $_POST['codp']
        )
    );
    /*header("location:../ang.php");*/
    if (isset($_SESSION['previous'])) {
        header('location:'. $_SESSION['previous']);
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
    <?php echo "Cod piesa: ".$ps->codp; ?>
    <input name="codp" type="hidden" value="<?php echo $ps->codp; ?>">
    <input name="denp" type="text" placeholder="Functie" value="<?php echo $ps->denp?>">
    <input name="pretp" id="pretp" type="number" placeholder="Pret(fara TVA)" value="<?php echo $ps->pretp?>" onkeyup="addVat()">
    <input name="pretptva" id="pretptva" type="text" placeholder="Pret" value="<?php echo $ps->pretptva?>" readonly">
    <script type='text/javascript'>
        function addVat() {
            let pret = document.getElementById("pretp").value;
            document.getElementById("pretptva").value = eval(pret) + 0.19 * eval(pret);
        }
    </script>
    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
