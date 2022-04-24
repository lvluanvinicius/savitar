<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CentralReportsController extends Controller
{
    public function index()
    {
        return view("admin.central.index")->with([
            "title" => "Relatório Central" . env("APP_NAME")
        ]);
    }
}
