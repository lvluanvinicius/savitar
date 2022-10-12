<?php

use App\Models\AverageDBM;
use App\Models\GraphPonsConfig;

if (!function_exists("getGponsConfig")) {
    function getGponsConfig ($idOlt)
    {
         $pons = GraphPonsConfig::where("ID_OLT_GRAPH", "=", $idOlt)->get(["ID_OLT_GRAPH", "PORT", "NAME_GRAPH"]);

         return $pons;
    }
}


if (!function_exists("getAveragesDBMOnGpon")) {
    function getAveragesDBMOnGpon ($idOlt, $gpon, $dateStart, $dateEnd)
    {
        $pons = AverageDBM::whereRaw("ID_OLT = $idOlt and PON = '$gpon' and from_unixtime(COLLECTION_DATE, '%Y-%m-%d') >= '$dateStart' and from_unixtime(COLLECTION_DATE, '%Y-%m-%d') <= '$dateEnd'")->get();

        $dateArray=[];
        $dbmArray=[];
        foreach ($pons as $pn) {
            // array_push($dateArray, date("d-m-Y", strtotime($pn->COLLECTION_DATE)));
            array_push($dateArray, strtotime(date('d-m-Y H:i:s', $pn->COLLECTION_DATE)));
            array_push($dbmArray, floatval(substr($pn->DBM_AVERAGE, 1, 5)));
        }

        return array($dbmArray, $dateArray);
    }
}


if(!function_exists("getGraphOltsConfig")) {
    function getGraphOltsConfig($idOlt)
    {
        $graphConfig = GraphPonsConfig::where("ID_OLT_GRAPH", "=", $idOlt)->get(["ID_OLT_GRAPH", "PORT", "NAME_GRAPH"]);

        return $graphConfig;
    }
}
