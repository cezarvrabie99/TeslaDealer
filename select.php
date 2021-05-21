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

function deleteFrom($delete, $where, $equals, $user){
    require "connection.php";
    if (!empty($connect)) {
        $sql = "delete from " . $delete . " where " . $where . " = " . $equals . ";";
        $stm = $connect->prepare($sql);
        $stm->execute();

        $stm = $connect->prepare("INSERT INTO logs (username, actiune, comanda, datal, oral, codf) VALUES (:username, :actiune, :comanda, CURRENT_DATE, CURRENT_TIME, :codf)");
        $stm->execute(array(
            "username" => $user,
            "actiune" => "stergere",
            "comanda" => $sql,
            "codf" => selectFrom("select codf from utilizatori where username = '" . $user . "';", 1)
        ));
    }
}

function logsConnect(string $user, bool $action){
    require "connection.php";
    if (!empty($connect)) {
        if ($action)
            $action2 = "login";
        else
            $action2 = "logout";
        $stm = $connect->prepare("INSERT INTO logs (username, actiune, comanda, datal, oral, codf) VALUES (:username, :actiune, :comanda, CURRENT_DATE, CURRENT_TIME, :codf)");
        $stm->execute(array(
            "username" => $user,
            "actiune" => $action2,
            "comanda" => php_uname(),
            "codf" => selectFrom("select codf from utilizatori where username = '" . $user . "';", 1)
        ));
    }
}

/**
 * @throws Exception
 */
function logs(string $user, PDO $pdo, string $query, array $params){
    require "connection.php";
    if (!empty($connect)) {
        $query2 = interpolateSQL($pdo, $query, $params);
        if (str_starts_with($query, "UPDATE"))
            $action = "editare";
        else
            $action = "adaugare";
        $stm = $connect->prepare("INSERT INTO logs (username, actiune, comanda, datal, oral, codf) VALUES (:username, :actiune, :comanda, CURRENT_DATE, CURRENT_TIME, :codf)");
        try {
            $stm->execute(array(
                "username" => $user,
                "actiune" => $action,
                "comanda" => $query2,
                "codf" => selectFrom("select codf from utilizatori where username = '" . $user . "';", 1)
            ));
        } catch (Exception $e) {
            echo "Error " . $e;
        }
    }
}

/**
 * @throws Exception
 */
function interpolateSQL(PDO $pdo, string $query, array $params) : string {
    $s = chr(2);
    $e = chr(3);
    $keys = [];
    $values = [];

    foreach ($params as $value) {
        while( mb_stripos($value, $s) !== false ) $s .= $s;
        while( mb_stripos($value, $e) !== false ) $e .= $e;
    }

    foreach ($params as $key => $value) {
        $keys[] = is_string($key) ? "/$s:$key$e/" : "/$s\?$e/";

        if( is_null($value) ){
            $values[$key] = 'NULL';
        }
        elseif( is_int($value) || is_float($value) ){
            $values[$key] = $value;
        }
        elseif( is_bool($value) ){
            $values[$key] = $value ? 'true' : 'false';
        }
        else{
            $value = str_replace('\\', '\\\\', $value);
            $values[$key] = $pdo->quote($value);
        }
    }

    $query = preg_replace(['/\?/', '/(:[a-zA-Z0-9_]+)/'], ["$s?$e", "$s$1$e"], $query);

    $query = preg_replace($keys, $values, $query, 1, $count);

    if( $count !== count($keys) || $count !== count($values) ){
        throw new Exception('Number of replacements not same as number of keys and/or values');
    }

    return $query;
}