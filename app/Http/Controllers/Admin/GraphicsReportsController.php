<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libs\Client\HTTPClient;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Illuminate\Http\Request;

class GraphicsReportsController extends Controller
{
    use LoadMessages, AppResponse;

    /**
     * Página inícial de busca por gráficos.
     *
     * @return void
     */
    public function index()
    {
        return view('admin.graphics.index')-> with([
            "title" => "Gráficos | " . env("APP_NAME"),
            "subtitle" => ""
        ]);
    }

    /**
     * Busca por hosts.
     *
     * @param Request $request
     * @return string
     */
    public function getHosts(Request $request)
    {
        //
        $params = $request->all();

        //
        $httpClient = new HTTPClient;

        //
        return $httpClient->get_hosts([
            "output" => [
                "hostid", "name", "host"
            ],
            "groupids" => $params["groupids"]
        ]);
    }

    /**
     * Busca por Gráficos.
     *
     * @param Request $request
     * @return string
     */
    public function getGraphics(Request $request)
    {
        //
        $params = $request->all();

        //
        $httpClient = new HTTPClient;

        //
        return $httpClient->get_graphics([
            "output" => "extend",
            "hostids" => $params["hostids"]
        ]);
    }

    //
    public function getGraphicsGenerate(Request $request)
    {
        //
        $params = $request->all();

        //
        $httpClient = new HTTPClient;

        // 
        $graphcs = [];

        //
        foreach ($params["graphicsid"] as $graph) {
            $graphItem = $httpClient->get_graphics([
                "output" => ["graphid", "name", "ymax_itemid"],
                "graphids" => $graph
            ]);

            $histories = $httpClient->get_history([
                "output" => "extend",
                "itemids" => strval($graphItem[0]["ymax_itemid"]),
                "time_from" => strtotime($params["time_from"]),
                "time_till" => strtotime($params["time_till"])
            ]);

            return $histories;

            // array_push($graphcs, $histories);
        }

        return $graphcs;
    }
}
