<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AverageDBM;
use App\Models\OltConfig;
use App\Models\OltGraphConfig;
use App\Traits\ApiResponser;
use App\Traits\LoadMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CollectionsController extends Controller
{
    use LoadMessages, ApiResponser;

    public function get_collections(Request $request, Response $response)
    {
        $req = $request->all();
        $dbm = AverageDBM::where("ID_OLT", "=", $req["ID_OLT"])
            ->where('PON', "=", $req["PORT"])->get();

        $oltconfig = OltConfig::where("id", "=", $req["ID_OLT"])->get();

        $graphsConfig = OltGraphConfig::where("ID_OLT_GRAPH", "=", $req["ID_OLT"])->get();

        return $this->success(array(
            "olt" => $oltconfig, "graph" => $graphsConfig, "dbm" => $dbm,
        ));
    }
}
