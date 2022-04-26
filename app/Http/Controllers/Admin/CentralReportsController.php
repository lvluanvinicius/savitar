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
            "subtitle" => "Busca avançada"
        ]);
    }

    public function generalReports(Request $request)
    {
        return $request->all();
    }
}
