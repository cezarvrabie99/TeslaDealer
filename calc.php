<?php

function brutToNet($brut): float
{
    if (!empty($brut) && preg_match("/^[0-9 .]*$/", $brut) && is_numeric($brut)){
        $net1 = $brut - 0.25 * $brut - 0.1 * $brut;
        return $net1 - 0.1 * $net1;
    } else
        return 0;
}

function addVat($price): float
{
    if (!empty($price) && preg_match("/^[0-9 .]*$/", $price) && is_numeric($price)){
        return $price + 0.19 * $price;
    } else
        return 0;
}