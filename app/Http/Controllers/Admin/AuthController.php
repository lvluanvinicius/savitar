<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AppResponse;
use Exception;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Auth;
use PDOException;

class AuthController extends Controller
{
    use AppResponse;

    public function index(Request $request, Response $response) {

        if(Auth::check()) {
            return redirect()->route('admin.home.page');
        }

        return view('login')->with([
            "title" => "Login | " . env('APP_NAME'),
        ]);
    }

    public function do(Request $request, Response $response) {
        try {
            if (in_array('', $request->only(["username", "password"]))) {
                return $this->error($type=0, "Usuário e senha devem ser informados.",  $code=400);
            }
    
            if (is_null($request->username) || is_null($request->password)) {
                return $this->error($type=0, "Usuário ou senha não pode ser vazio.",  $code=400);
            }
    
            try {
                // Verificando se email e senha existem.
                if (!Auth::attempt($request->only(["username", "password"]))) {
                    return $this->error($type=0, "Usuário ou senha incorretos.",  $code=400);
                } else {
                    return redirect()->route('admin.home.page');
                }
            } catch (PDOException $err) {
                if (\str_contains($err->getMessage(), "Connection refused") || $err->getCode() == 2002)
                {
                    return $this->error($type=0, "Erro ao tentar se conectar com o banco de dados.",  $code=400);
                }
    
                return $this->error($type=0, $err->getMessage(),  $code=400);
    
            }
        } catch (Exception $err) {
            return $this->error($type=0, $err->getMessage(),  $code=400);
        }
    }


    public function logout() {
        Auth::logout();
        return redirect()->route('login.page');
    }
}
