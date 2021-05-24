<?php
require "header.php";
if (isset($_GET['usr']) && $_GET['usr'] == "neconf"){
    $message = "Utilizator neconfigurat!";
}
else{
    $message = "Te-ai ratacit?";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log In</title>
</head>
<body>
<form id="main" action="login.php" method="post">
    <div class = "login">
        <img src="img/err.png" alt="tesla logo" width="200" height="200">
        <h1 id="title"><?php echo $message;?></h1>
        <a href="index.php">Inapoi la Log In</a>
    </div>
</form>
</body>
</html>
