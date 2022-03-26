<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    use AppResponse, LoadMessages;

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function logindo(Request $request) {
        // Verificando se os dados foram preenchidos corretamente. $this->getMessage("apperror", "ErrorEmailNotInformed")
        if (in_array('', $request->only(["email", "password"]))) {
            return $this->error($this->getMessage("apperror", "ErrorUserOrPassNotSnown"), $troute="login", $code=400);
        }

        // Filtrando se o e-mail é válido.
        if (is_null($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->error($this->getMessage("apperror", "ErrorEmailNotInformed"), $troute="login", $code=400);
        }

        // Verificando se email e senha existem.
        if (!Auth::attempt($request->only(["email", "password"]))) {
            return $this->error($this->getMessage("apperror", "ErrorIncorrectUserOrPass"), $troute="login", $code=400);
        }

        // Retorna home se os dados baterem com os do db.
        return redirect()->route("app.home");

    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function exit () {
        Auth::logout();
        return redirect()->route("login");
    }
}
