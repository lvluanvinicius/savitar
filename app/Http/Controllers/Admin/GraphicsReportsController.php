<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
