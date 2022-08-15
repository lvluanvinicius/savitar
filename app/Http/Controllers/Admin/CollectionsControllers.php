<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AverageDBM;
use App\Models\OltConfig;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionsControllers extends Controller
{
    use AppResponse, LoadMessages;

    public function dashboard()
    {

        return view("admin.collections-dashboard.index")->with([
            "title" => "DBM Dashboard | " . env("APP_NAME")
        ]);
    }

    /**
     * Carregamento de coletas de DBM.
     *
     * @return void
     */
    public function list_dbm_collections()
    {
        //$dbm = AverageDBM::limit(10)->orderBy("created_at", "desc")->get();

        // $dbm = AverageDBM::where('DBM_AVERAGE', "<=", -27)->get();

        $dbm = AverageDBM::where('DBM_AVERAGE', "<=", -27)
                ->join('olt_config', function ($join) {
                    //
                    $join->on('pons_average_dbm.ID_OLT', "=", "olt_config.id");
                })->get();


        // $dbm = DB::table('pons_average_dbm')
        //     ->join('olt_config', function () {

        //     });

        return view("admin.collections.index")->with([
            "title" => "DBM Coleções | " . env("APP_NAME"),
            "dbm_collections" => $dbm
        ]);
    }


    public function list_olt_config()
    {
        $olts = OltConfig::get();

        return view('admin.olt-config.index')->with([
            "title" => "Configuração de OLTs | " . env("APP_NAME"),
            "olts" => $olts
        ]);
    }

    public function update_olt_config(Request $request)
    {
        dd($request->id);
        // $olt = OltConfig::where('id', "=", $request->id);
    }


    public function save_dbm_collections(Request $request)
    {
        $ext = $request->data_file->getClientOriginalExtension();
        if ($request->data_file) {
            $request->data_file->storeAs('data', 'datacom.' . $ext);
            return $this->success($this->getMessage("appsuccess", "SuccessUploadFile"),  $code=200);
        }

        return $this->error($this->getMessage("apperror", "ErrorFileNotInformed"),  $code=400);
    }


    public function get_dbm_pons()
    {
        //
    }

}
