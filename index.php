<?php
require "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style/styles.css"/>
    <meta charset="UTF-8">
    <title>Log In</title>
</head>
<body>
<form id="main" action="login.php" method="post">
    <h1 id="title">Log in</h1>
    <div class = "login">
        <img src="tesla_logo.png" alt="tesla logo" width="200" height="200">
        <input name="user" id="user" type="text" placeholder="Introduceti username-ul">
        <input name="parola" id="parola" type="password" placeholder="Introduceti parola">

        <input class="submit" type="submit" name="submit">
    </div>

    <input name="remember" id="remember" type="checkbox" value="Tine minte username-ul">
    <label for="remember">Tine minte username-ul</label>
</form>
</body>
</html>

<?php
if (isset($_COOKIE['user']) and isset($_COOKIE['parola'])){
    $user = $_COOKIE['user'];
    $parola = $_COOKIE['parola'];
echo "<script>
document.getElementById('user').value = '$user';
document.getElementById('parola').value = '$parola';
</script>";
}
?>