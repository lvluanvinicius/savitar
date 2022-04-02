<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKeys;
use App\Models\User;

class IndexController extends Controller
{
    public function home () {

        $users = User::get("*");
        $keys = ApiKeys::get("*");

        return view("admin.home.index")->with([
            "title" => "Início | " . env('APP_NAME'),
            "qnt_users" => $users->count(),
            "qnt_keys" => $keys->count()
        ]);
    }
}
