<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AverageDBM;
use App\Traits\ApiResponser;
use App\Traits\LoadMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CollectionsController extends Controller
{
    use LoadMessages, ApiResponser;

    public function get_collections(Request $request, Response $response)
    {
        $dbm = AverageDBM::where("ID_OLT", "=", $request->ID_OLT)
            ->where('PON', "=", $request->PORT)->get();
        return $this->success($dbm);
    }
}
