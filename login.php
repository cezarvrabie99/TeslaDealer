<?php
require "connection.php";
require "validation.php";
require "select.php";

    if (isset($_POST["submit"])) {
        if (/*empty($_POST["nume"]) || */empty($_POST["user"]) || empty($_POST["parola"])) {
            header("location:index.php");
            exit();
        } else {
            $query = "SELECT codf FROM utilizatori WHERE username = :user AND password = :parola";
            if (!empty($connect)) {
                $statement = $connect->prepare($query);
            }
            $statement->execute(
                array(
                    /*'nume' => $_POST["nume"],*/
                    'user' => $_POST["user"],
                    'parola' => $_POST["parola"]
                )
            );
            $count = $statement->rowCount();
            $result = $statement->fetch();
            if ($count > 0) {
                if (isset($_POST["remember"])){
                    setcookie('user', $_POST["user"], time()+60*60*4);
                    setcookie('parola', $_POST["parola"], time()+60*60*4);
                }
                session_start();
                $_SESSION['user'] = $_POST["user"];
                //header("location:ang.php");
                switch ($result[0]){
                    case 4:
                        logsConnect($_SESSION['user'], true);
                        header("location:data/ang.php");
                        break;
                    case 7:
                    case 6:
                        logsConnect($_SESSION['user'], true);
                        header("location:data/auto.php");
                        break;
                    case 1:
                        logsConnect($_SESSION['user'], true);
                        header("location:data/piese.php");
                        break;
                    default:
                        header("location:error.php?usr=neconf");
                        break;
                }
            } else {
                header("location:index.php");
                exit();
            }
        }
}