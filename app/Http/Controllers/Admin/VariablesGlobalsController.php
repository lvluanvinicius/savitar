<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariablesGlobals;
use Illuminate\Http\Request;

class VariablesGlobalsController extends Controller
{
    public function variablesIndex()
    {
        //
        $variables = VariablesGlobals::get();

        return view('admin.globals-variables.index')->with([
            "title" => "Variáveis | " . env("APP_NAME"),
            "variables" => $variables
        ]);
    }
}
