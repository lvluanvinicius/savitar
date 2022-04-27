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
        $respHttp = $http->get_central_reports_attended([
            "dataInicial" => "$request->start_date $request->start_hours",
            "dataFinal" => "$request->stop_date $request->stop_hours",
            "agente" => $request->agents_filter,
            "filas" => $request->queues_filter,
            "numeroPagina" => 1
        ]);

        dd($respHttp);

        return view("admin.central-reports-graphs.index")->with([
            "title" => "Relatório Central | " . env("APP_NAME"),
            "subtitle" => "Relatórios"
        ]);
    }
}
