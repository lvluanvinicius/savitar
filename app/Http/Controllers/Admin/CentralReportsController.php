<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libs\Client\HTTPClient;
use Illuminate\Http\Request;

class CentralReportsController extends Controller
{
    /**
     * Indexação da página de reposts.
     *
     * @return void
     */
    public function index()
    {
        return view("admin.central.index")->with([
            "title" => "Relatório Central | " . env("APP_NAME"),
            "subtitle" => "Relatórios"
        ]);
    }

    public function generalReportsGraphs(Request $request)
    {
        $http = new HTTPClient();

        // Get data
        $respHttp = $http->get_central_report_queue_statistics([
            "dataInicial" => "$request->start_date $request->start_hours",
            "dataFinal" => "$request->stop_date $request->stop_hours",
            "filas" => $request->queues_filter,
        ]);

        $newDataCentral = [];

        foreach ($respHttp as $results) {
            \array_push($newDataCentral, [
                "data" => $results[0]["data"],
                "total_chamadas" => $results[0]["data"],
                "total_abandonadas" => $results[0]["total_abandonadas"],
                "porcen_abandonadas" => $results[0]["porcen_abandonadas"],
                "porcen_atendidas" => $results[0]["porcen_atendidas"]
            ]);
        }

        return view("admin.central-reports-graphs.index")->with([
            "title" => "Relatório Central | " . env("APP_NAME"),
            "subtitle" => "Relatórios"
        ]);
    }
}
