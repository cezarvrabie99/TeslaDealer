<?php

function selectFrom($query, $type){
    require "connection.php";
    if (!empty($connect)) {
        $stm = $connect->prepare($query);
    } else
        $stm = null;
    $stm->execute();
    if ($type === 1) {
        return $stm->fetch()[0];
    }
    else
        return $stm->fetchAll();
}

function deleteFrom($delete, $where, $equals){
    require "connection.php";
    if (!empty($connect)) {
        $stm = $connect->prepare("delete from ".$delete." where ".$where." = ".$equals);
    } else
        $stm = null;
    $stm->execute();
}