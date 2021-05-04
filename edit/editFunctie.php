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
    $stmt = $connect->prepare('SELECT * FROM functie WHERE codf = :codf');
} else
    $stmt = null;

$stmt->bindValue('codf', $_GET['codf']);
/*$stmt->bindValue('codf', 3);*/
$stmt->execute();
$fc = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_POST['act'])){
    /*if (isSalaryValid(strval($_GET['salariubrut']))){*/
        if (!empty($connect)) {
            $stmt = $connect->prepare('UPDATE functie SET denf = :denf, salariubrut = :salariubrut, salariunet = :salariunet 
                                   WHERE codf = :codf');
        }
        $stmt->execute(
            array(
                'denf' => $_POST['denf'],
                'salariubrut' => $_POST['salariubrut'],
                'salariunet' => $_POST['salariunet'],
                'codf' => $_POST['codf']
            )
        );
        /*header("location:../data/functii.php");*/
    if (isset($_SESSION['previous'])) {
        header('location:'. $_SESSION['previous']);
    }
    /*} else{                 Undefined array key
        $message = "Date Gresite";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }*/
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
</head>
<body>
<form id="prod" method="post">
    <?php echo "Cod functie: ".$fc->codf; ?>
    <input name="codf" type="hidden" value="<?php echo $fc->codf; ?>">
    <input name="denf" type="text" placeholder="Functie" value="<?php echo $fc->denf?>">
    <input name="salariubrut" id="salariubrut" type="number" placeholder="Salariul brut" value="<?php echo $fc->salariubrut?>" onkeyup="updateSal()">
    <input name="salariunet" id="salariunet" type="text" placeholder="Salariul net" value="<?php echo $fc->salariunet?>" readonly">
    <script type='text/javascript'>
        function updateSal() {
            let brut = document.getElementById("salariubrut").value;
            let net1 = brut - 0.25 * brut - 0.1 * brut;
            document.getElementById("salariunet").value = net1 - 0.1 * net1;
        }
    </script>
    <input name="act" type="submit" value="Actualizeaza">
</form>
</body>
</html>
