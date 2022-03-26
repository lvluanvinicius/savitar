<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Traits\LoadMessages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponser, LoadMessages;

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function login (Request $request)
    {
        if (Auth::attempt([ "email" => $request->email, "password" => $request->password ]) ){
            $user = Auth::user();

            $token = $user->tokens()->get();

            // Caso exista uma chave em aberto, será excluída.
            if (!is_null($token)) {
                $user->tokens()->delete();
                $token = $user->createToken($user->name)->plainTextToken;
            }

            return $this->success([
                $token,
            ], $this->getMessage("apisuccess", "SuccessGeneratedToken"));
        }

        return $this->error($this->getMessage("apierror", "ErrorLoginNotAssoc"), 401);

    }


}
