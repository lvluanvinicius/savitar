<?php

use App\Models\AverageDBM;
use App\Models\GraphPonsConfig;

if (!function_exists("getGponsConfig")) {
    function getGponsConfig ($idOlt)
    {
         $pons = GraphPonsConfig::where("ID_OLT_GRAPH", "=", $idOlt)->get();

         return $pons;
    }
}


if (!function_exists("getAveragesDBMOnGpon")) {
    function getAveragesDBMOnGpon ($idOlt, $gpon, $dateStart, $dateEnd)
    {
        $pons = AverageDBM::whereRaw("ID_OLT = $idOlt and PON = '$gpon' and created_at >= '$dateStart' and created_at <= '$dateEnd'")->get();

        $dateArray=[];
        $dbmArray=[];
        // $values=[];
        foreach ($pons as $pn) {
            array_push($dateArray, date("d-m-Y", strtotime($pn->created_at)));
            array_push($dbmArray, floatval(substr($pn->DBM_AVERAGE, 1, 5)));
        }
        //array_push($values, $dateArray);
        //array_push($values, $dbmArray);
        // $values['DBM_AVERAGE'] = $dbmArray;
        // $values['DATE'] = $dateArray;
        return array($dbmArray, $dateArray);
        // return $values;
    }
}
