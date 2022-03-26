<?php


if (!function_exists("convetDate")) {
    function convetDate($datetime) {
        $dtStart = new DateTime($datetime);
        $dtEnd   = new DateTime();
        $dtDiff = $dtStart->diff($dtEnd);

        $D = $dtDiff->format('%d');
        $H = $dtDiff->format('%H');
        $M = $dtDiff->format('%I');
        $S = $dtDiff->format('%S');

        if ($D == 0 && $H == 0 && $M == 0 && $S == 0) return  "ainda não foi utilizada";
        if ($D == 0 && $H == 0 && $M == 0) return  "$S segundos atrás";
        if ($D == 0 && $H == 0) return  "$M minutos atrás";
        if ($D == 0 ) return  "$H horas atrás";
        if ($D != 0) return  "$D dias atras";
    }
}

if (!function_exists("convetDateCreated")) {
    function convetDateCreated($datetime) {
        $dtStart = new DateTime($datetime);
        $dtEnd   = new DateTime();
        $dtDiff = $dtStart->diff($dtEnd);

        $D = $dtDiff->format('%d');
        $H = $dtDiff->format('%H');
        $M = $dtDiff->format('%I');
        $S = $dtDiff->format('%S');

        if ($D == 0 && $H == 0 && $M == 0 && $S == 0) return  "criado agora";
        if ($D == 0 && $H == 0 && $M == 0) return  "$S segundos atrás";
        if ($D == 0 && $H == 0) return  "$M minutos atrás";
        if ($D == 0 ) return  "$H horas atrás";
        if ($D != 0) return  "$D dias atras";
    }
}


