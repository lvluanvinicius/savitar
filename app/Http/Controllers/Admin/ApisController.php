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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function updatekeyfromusers(Request $request)
    {
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
