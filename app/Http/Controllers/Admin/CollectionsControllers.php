<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollectionsControllers extends Controller
{
    public function index()
    {
        return view("admin.collections.index")->with([
            "title" => "DBM Coleções | " . env("APP_NAME"),
        ]);
    }
}
