<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;

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
            return $this->error($this->getMessage("apperror", "ErrorUserOrPassNotSnown"), $code=400);
        }

        // Filtrando se o e-mail é válido.
        if (is_null($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->error($this->getMessage("apperror", "ErrorEmailNotInformed"), $code=400);
        }

        try {
            // Verificando se email e senha existem.
            if (!Auth::attempt($request->only(["email", "password"]))) {
                return $this->error($this->getMessage("apperror", "ErrorIncorrectUserOrPass"), $code=400);
            }
        } catch (PDOException $err) {
            if (\str_contains($err->getMessage(), "Connection refused") || $err->getCode() == 2002)
            {
                return $this->error($this->getMessage("apperror", "ErrorUnableToConnectToDataServer"), $code=400);
            }
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
