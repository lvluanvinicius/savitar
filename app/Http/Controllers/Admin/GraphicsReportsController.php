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


    public function index()
    {
        return view('admin.graphics.index')-> with([
            "title" => "Gráficos | " . env("APP_NAME"),
            "subtitle" => ""
        ]);
    }

    public function getTemplates(Request $request)
    {
        $params = $request->all();

        $httpClient = new HTTPClient;

        return $httpClient->get_templates($params["groupids"]);
    }

    public function getHosts(Request $request)
    {
        $params = $request->all();

        $httpClient = new HTTPClient;

        return $httpClient->get_hosts($params["templateids"]);
    }

    public function getGraphics(Request $request)
    {
        //
        $params = $request->all();

        $httpClient = new HTTPClient;

        return $httpClient->get_graphics($params["hostids"]);
    }
}
