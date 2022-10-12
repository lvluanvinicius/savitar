<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKeys;
use App\Models\User;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;

class IndexController extends Controller
{
    use LoadMessages, AppResponse;
    
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
