<?php

function isVinValid($vin): bool
{
    if (strlen($vin) != 17)
        return false;
    $vin = strtoupper($vin);
    $vin3 = $vin[3];
    $vin4 = $vin[4];
    $vin5 = $vin[5];
    $vin6 = $vin[6];
    $vin7 = $vin[7];
    $vin9 = $vin[9];
    $vin10 = $vin[10];
    $vin11 = $vin[11];
    return str_starts_with($vin, "5YJ")
        && !str_contains($vin, 'I') && !str_contains($vin, 'Q') && !str_contains($vin, "O")
        && ($vin3 == 'S' || $vin3 == '3' || $vin3 == 'X' || $vin3 == 'Y')
        && ($vin4 >= 'A' && $vin4 <= 'F')
        && (($vin5 >= '1' && $vin5 <= '8') || ($vin5 >= 'A' && $vin5 <= 'D'))
        && (($vin6 >= 'A' && $vin6 <= 'E') || $vin6 == 'H' || $vin6 == 'S' || $vin6 == 'V')
        && (($vin7 >= '1' && $vin7 <= '4') || ($vin7 >= 'A' && $vin7 <= 'C') || $vin7 == 'G' || $vin7 == 'N' || $vin7 == 'P')
        && (($vin9 >= 'D' && $vin9 <= 'H') || ($vin9 >= 'J' && $vin9 <= 'L'))
        && ($vin10 == 'F' || $vin10 == 'P')
        && (($vin11 >= '0' && $vin11 <= '9') || $vin11 == 'P');
}

function getModel($vin): string
{
    $vin = strtoupper($vin);
    $vin3 = $vin[3];
    return match ($vin3) {
        'S' => "Model S",
        '3' => "Model 3",
        'X' => "Model X",
        'Y' => "Model Y",
        default => "error",
    };
}

function isCNPValid($cnp): bool
{
    if (strlen($cnp) == 13 && preg_match("/^[0-9]*$/", $cnp)){
        $firstDigit = intval(substr($cnp, 0, 1));
        $date = intval(substr($cnp, 1,7));
        $lastDigit = intval(substr($cnp, -1, 1));
        $first12 = intval(substr($cnp, 0, 12));

        if ($firstDigit != 0 && isDateValid($date)){
            $controlDigit = getControlDigit($first12);
            if ($controlDigit == 10)
                $controlDigit = 1;
            return $controlDigit == $lastDigit;
        } else
            return false;
    } else
        return false;
}

function getControlDigit($first12): int
{
    $number = 0;
    $controlDigits = "279146358279";

    for ($i = 0; $i < 12 ;$i++) {
        $number += intval(substr($first12, $i, 1)) *
            intval(substr($controlDigits, $i, 1));
    }

    return $number % 11;
}

function isDateValid($date): bool
{
    $day = substr($date, 4, 2);
    $month = substr($date, 2, 2);
    $year = substr($date, 0, 2);
    return checkdate($month, $day, $year);
}

function isNameValid($name): bool
{
    return preg_match("/^[ A-Za-z.-]*$/",$name);
}

function isPhoneValid($phone): bool
{
    return (strlen($phone) == 10 && preg_match("/^[0-9]*$/", $phone)) ||
        (strlen($phone) == 12 && preg_match("/^[0-9 +]*$/", $phone));
}

function isEmailValid($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isCountryCodeValid($country): bool
{
    $country = strtoupper($country);
    $countryCodes = array('AF', 'AX', 'AL', 'DZ', 'AS', 'AD', 'AO', 'AI', 'AQ', 'AG', 'AR', 'AM', 'AW', 'AU', 'AT', 'AZ', 'BS', 'BH', 'BD', 'BB', 'BY', 'BE', 'BZ', 'BJ', 'BM', 'BT', 'BO', 'BQ', 'BA', 'BW', 'BV', 'BR', 'IO', 'BN', 'BG', 'BF', 'BI', 'KH', 'CM', 'CA', 'CV', 'KY', 'CF', 'TD', 'CL', 'CN', 'CX', 'CC', 'CO', 'KM', 'CG', 'CD', 'CK', 'CR', 'CI', 'HR', 'CU', 'CW', 'CY', 'CZ', 'DK', 'DJ', 'DM', 'DO', 'EC', 'EG', 'SV', 'GQ', 'ER', 'EE', 'ET', 'FK', 'FO', 'FJ', 'FI', 'FR', 'GF', 'PF', 'TF', 'GA', 'GM', 'GE', 'DE', 'GH', 'GI', 'GR', 'GL', 'GD', 'GP', 'GU', 'GT', 'GG', 'GN', 'GW', 'GY', 'HT', 'HM', 'VA', 'HN', 'HK', 'HU', 'IS', 'IN', 'ID', 'IR', 'IQ', 'IE', 'IM', 'IL', 'IT', 'JM', 'JP', 'JE', 'JO', 'KZ', 'KE', 'KI', 'KP', 'KR', 'KW', 'KG', 'LA', 'LV', 'LB', 'LS', 'LR', 'LY', 'LI', 'LT', 'LU', 'MO', 'MK', 'MG', 'MW', 'MY', 'MV', 'ML', 'MT', 'MH', 'MQ', 'MR', 'MU', 'YT', 'MX', 'FM', 'MD', 'MC', 'MN', 'ME', 'MS', 'MA', 'MZ', 'MM', 'NA', 'NR', 'NP', 'NL', 'NC', 'NZ', 'NI', 'NE', 'NG', 'NU', 'NF', 'MP', 'NO', 'OM', 'PK', 'PW', 'PS', 'PA', 'PG', 'PY', 'PE', 'PH', 'PN', 'PL', 'PT', 'PR', 'QA', 'RE', 'RO', 'RU', 'RW', 'BL', 'SH', 'KN', 'LC', 'MF', 'PM', 'VC', 'WS', 'SM', 'ST', 'SA', 'SN', 'RS', 'SC', 'SL', 'SG', 'SX', 'SK', 'SI', 'SB', 'SO', 'ZA', 'GS', 'SS', 'ES', 'LK', 'SD', 'SR', 'SJ', 'SZ', 'SE', 'CH', 'SY', 'TW', 'TJ', 'TZ', 'TH', 'TL', 'TG', 'TK', 'TO', 'TT', 'TN', 'TR', 'TM', 'TC', 'TV', 'UG', 'UA', 'AE', 'GB', 'US', 'UM', 'UY', 'UZ', 'VU', 'VE', 'VN', 'VG', 'VI', 'WF', 'EH', 'YE', 'ZM', 'ZW');
    return in_array($country, $countryCodes);
}

function isJudetValid($judet): bool
{
    $judet = strtoupper($judet);
    $judete = array("AB", "AG", "AR", "B", "BC", "BH", "BN", "BR", "BT", "BV", "BZ", "CJ", "CL", "CS", "CT",
        "CV", "DB", "DJ", "GJ", "GL", "GR", "HD", "HR", "IF", "IL", "IS", "MH", "MM", "MS", "NT", "OT", "PH",
        "SB", "SJ", "SM", "SV", "TL", "TM", "TR", "VL", "VN", "VS");
    return in_array($judet, $judete);
}

function isSalaryValid($salary): bool
{
    return is_numeric($salary) && $salary >= 2000 && $salary <= 20000;
}

/*echo "getModel: ".getModel("5YJ37EA4LF673789")."<br>";
echo "isNameValid".isNameValid("Vrabie Cezar")."<br>";
echo "isPhoneValid".isPhoneValid("0785967542")."<br>";
echo "isVinValid".isVinValid("5YJ3E7EA4LF673789")."<br>";
echo "isEmailValid".isEmailValid("test@gmail.com")."<br>";
echo "isJudetValid".isJudetValid("GL")."<br>";
echo "isCountryCodeValid".isCountryCodeValid("ro")."<br>";
echo "isSalaryValid".isSalaryValid("2000")."<br>";
echo "getControlDigit".getControlDigit("2990503248928")."<br>";
echo "isDateValid".isDateValid("990513")."<br>";
echo "isCNPValid".isCNPValid("2990503248928");*/