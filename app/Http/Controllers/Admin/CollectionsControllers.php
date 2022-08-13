<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AverageDBM;
use Illuminate\Http\Request;

class CollectionsControllers extends Controller
{
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
        $dbm = AverageDBM::limit(10)->orderByDesc("created_at")->get();

        return view("admin.collections.index")->with([
            "title" => "DBM Coleções | " . env("APP_NAME"),
            "dbm_collections" => $dbm
        ]);
    }

}
