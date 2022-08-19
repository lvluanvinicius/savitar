<?php

use App\Models\AverageDBM;
use App\Models\GraphPonsConfig;

if (!function_exists("getGponsConfig")) {
    function getGponsConfig ($idOlt)
    {
         $pons = GraphPonsConfig::where("ID_OLT_GRAPH", "=", $idOlt)->get();

         dd($pons);

         return $pons;
    }
}


if (!function_exists("getAveragesDBMOnGpon")) {
    function getAveragesDBMOnGpon ($idOlt, $gpon, $dateStart, $dateEnd)
    {
        $pons = AverageDBM::whereRaw("ID_OLT = $idOlt and PON = '$gpon' and created_at >= '$dateStart' and created_at <= '$dateEnd'")->get();
        dd($pons);
        $dateArray=[];
        $dbmArray=[];
        //$values=[];
        foreach ($pons as $pn) {
            dd($pn->created_at);
            //array_push($dateArray, strtotime());
            array_push($dbmArray, floatval(substr($pn->DBM_AVERAGE, 1, 5)));
        }
        //array_push($values, $dateArray);
        //array_push($values, $dbmArray);
        // $values["DBM_AVERAGE"] = $dbmArray;
        // $values["DATE"] = $dateArray;
        return array($dateArray, $dbmArray);
    }
}
