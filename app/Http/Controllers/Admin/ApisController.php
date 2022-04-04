<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKeys;
use App\Models\User;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApisController extends Controller
{
    use LoadMessages, AppResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apikeys = ApiKeys::get();
        return view('admin.apis.index')->with([
            "title" => "Chaves de Acesso | " . env('APP_NAME'),
            "apikeys" => $apikeys,
            "subtitle" => "Chaves de acesso"
        ]);
    }


    public function updatekeyfromusers(Request $request)
    {
        // Verificar se tem permissão para atualização.
        if (!checkNivel(auth()->user()->id, "update") || !checkNivel(auth()->user()->id, "*")) {
            return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRoute"),  $code=401);
        }

        try {
            $user = User::where('id', $request->id)->first();

            $token = $user->tokens();

            if (!is_null($token)) {
                $user->tokens()->delete();
                $token = $user->createToken($user->name)->plainTextToken;
                return $this->success($this->getMessage("apisuccess", "SuccessKeyUpdate"), $code=200, [
                    "new_token" => $token,
                    "status" => "Updated"
                ]);
            } else {
                return $this->info($this->getMessage("apiinfo", "UserDoesNotHaveKey"), $code=400);
            }


        } catch (Exception $e) {
            return $this->error($this->getMessage("apierror", "ErrorRevokeKeyUnauthorized"), $code=400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

        try {
            if (auth()->check()) {
                $user = Auth::user();

                $token = $user->tokens();

                // Caso exista uma chave em aberto, será excluída.
                if (!is_null($token)) {
                    $user->tokens()->delete();
                    $token = $user->createToken($user->name)->plainTextToken;

                    return $this->success($this->getMessage("apisuccess", "SuccessKeyUpdate"), $code=200, [
                        "new_token" => $token,
                        "status" => "Updated"
                    ]);
                } else {
                    return $this->info($this->getMessage("apiinfo", "UserDoesNotHaveKey"), $code=400);
                }

            }

            return $this->error($this->getMessage("apierror", "ErrorRevokeKeyUnauthorized"), $code=400);

        } catch (Exception $e) {
            return $this->error($this->getMessage("apierror", "ErrorRevokeKeyUnauthorized"), $code=400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /// Verificar se tem permissão para exclusão..
        if (!checkNivel(auth()->user()->id, "delete") || !checkNivel(auth()->user()->id, "*")) {
            return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRoute"),  $code=401);
        }

        if (is_numeric($request->id)) {
            $user = ApiKeys::where("id", $request->id)->first();
            try {
                if ($user->delete()) {
                    return $this->success($this->getMessage("appsuccess", "SuccessDeleteApiKey"),  $code=200);
                }
            } catch (Exception $e) {
                return $this->error($this->getMessage("apperror", "ErrorNotExcludeApiKey"),  $code=400);
            }
            return $this->error($this->getMessage("apperror", "ErrorNotExcludeApiKey"),  $code=400);
        }
        return $this->error($this->getMessage("apperror", "ErrorNotExcludeApiKey"),  $code=400);
    }
}
