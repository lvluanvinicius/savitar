<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKeys;
use App\models\User;
use Illuminate\Http\Request;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AppResponse, LoadMessages;

   /**
    * Edit User Method
    *
    * @param Request $request
    * @return void
    */
    public function edituser(Request $request)
    {
        /**
         * Verificar permissão de acesso do usuário que está tentando manipular.
         */
        if (!checkNivel(auth()->user()->id) == 0) {
            return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRouteCreateUser"), $code=400);
        }

        if (is_null($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->error($this->getMessage("apperror", "ErrorEmailNotInformed"),  $code=400);
        }


        if (strlen($request->password) < 10) {
            return $this->error($this->getMessage("apperror", "ErrorShortPassword"),  $code=400);
        }


        if ($request->confirm_alter_user != "on") {
            return $this->error($this->getMessage("apperror", "ErrorConfirmChange"),  $code=400);
        }


        try {
            $user = User::where("id", $request->id_user)->first();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            return $this->success($this->getMessage("appsuccess", "SuccessUpdatedUser"),  $code=200);

        } catch(Exception $e) {
            if ($e->errorInfo[0] == "23000" && $e->errorInfo[1] == 1062) {
                return $this->error($this->getMessage("apperror", "ErrorEmailAlreadyExists"),  $code=400);
            }
            return $this->error($this->getMessage("apperror", "ErrorException"),  $code=400);
        }
    }

    /**
     * Load user from edit,
     *
     * @param Request $request
     * @return void
     */
    public function listondeuser(Request $request)
    {
        $id_user = $request->all('id');
        $user = User::where('id', $id_user)->first();
        $key = ApiKeys::where("tokenable_id", $id_user)->first();

        return view('admin.useredit.index')->with([
            "title" => "$user->name | " . env('APP_NAME'),
            "user" => $user,
            "keyuser" => $key
        ]);
    }

    /**
     * Edição de perfil
     *
     * @param Request $request
     * @return void
     */
    public function profileedit(Request $request)
    {

        if (is_null($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->error($this->getMessage("apperror", "ErrorEmailNotInformed"),  $code=400);
        }

        if (strlen($request->password) < 10) {
            return $this->error($this->getMessage("apperror", "ErrorShortPassword"),  $code=400);
        }

        if ($request->confirm_alter_user != "on") {
            return $this->error($this->getMessage("apperror", "ErrorConfirmChange"),  $code=400);
        }

        try {
            $user = User::where("id", auth()->user()->id)->first();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            return $this->success($this->getMessage("appsuccess", "SuccessUpdatedUser"),  $code=200);

        } catch(Exception $e) {
            if ($e->errorInfo[0] == "23000" && $e->errorInfo[1] == 1062) {
                return $this->error($this->getMessage("apperror", "ErrorEmailAlreadyExists"),  $code=400);
            }
            return $this->error($this->getMessage("apperror", "ErrorException"),  $code=400);
        }
    }

    /**
     * Cadastro de usuário.
     *
     * @param Request $request
     * @return void
     */
    public function adduser(Request $request)
    {
        if (!checkNivel(auth()->user()->id) == 0) {
            return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRouteCreateUser"), $code=400);
        }

        if (strlen($request->name) < 5) {
            return $this->error($this->getMessage("apperror", "ErrorInvalidError"),  $code=400);
        }

        if (is_null($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->error($this->getMessage("apperror", "ErrorEmailNotInformed"),  $code=400);
        }

        if (strlen($request->password) < 10) {
            return $this->error($this->getMessage("apperror", "ErrorShortPassword"),  $code=400);
        }

        //permissions
        if (is_null($request->permissions)) {
            return $this->error($this->getMessage("apperror", "ErrorSelectedPermissions"),  $code=400);
        }

        if ($request->confirm_add_user != "on") {
            return $this->error($this->getMessage("apperror", "ErrorAddChange"),  $code=400);
        }

        try {

            //

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            return $this->success($this->getMessage("appsuccess", "SuccessAddUser"),  $code=200);

        } catch(Exception $e) {
            if ($e->errorInfo[0] == "23000" && $e->errorInfo[1] == 1062) {
                return $this->error($this->getMessage("apperror", "ErrorEmailAlreadyExists"),  $code=400);
            }
            return $this->error($this->getMessage("apperror", "ErrorException"),  $code=400);
        }

        return $this->error($this->getMessage("apperror", "ErrorAddNewUser"),  $code=400);
    }


    /**
     * Retorna a página de usuários já com os dados carregados.
     *  Não retorna o usuário logado.
     *  - A atualização do próprio usuário, é necessário estar logado e realizar pela página Profile.
     * @param Request $request
     * @return void
     */
    public function profile(Request $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $key = ApiKeys::where("tokenable_id", auth()->user()->id)->first();

        return view('admin.profile.index')->with([
            "title" => $user->name . " | ". env('APP_NAME'),
            "user" => $user,
            "subtitle" => $user->name,
            "mykey" => $key
        ]);
    }

    /**
     * Listagem de usuários.
     *
     * @param Request $request
     * @return void
     */
    public function listusers(Request $request)
    {
        $users = User::where("id", "!=", auth()->user()->id)->get();

        return view('admin.users.index')->with([
            "title" => "Usuários | ". env('APP_NAME'),
            "users" => $users,
            "subtitle" => "Usuários"
        ]);
    }

    /**
     * Exclusão de usuários.
     *
     * @param Request $request
     * @return void
     */
    public function deleteuser(Request $request)
    {
        /**
         * Verificar permissão de acesso do usuário que está tentando manipular.
         */
        if (!checkNivel(auth()->user()->id) == 0) {
            return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRouteCreateUser"), $code=400);
        }

        if (is_numeric($request->id)) {
            $user = User::where("id", $request->id)->first();
            try {
                if ($user->delete()) {
                    return $this->success($this->getMessage("appsuccess", "SuccessDeleteUser"), $code=200);
                }
            } catch (Exception $e) {
                return $this->error($this->getMessage("apperror", "ErrorNotExcludeUser"),  $code=400);
            }
            return $this->error($this->getMessage("apperror", "ErrorNotExcludeUser"),  $code=400);
        }
        return $this->error($this->getMessage("apperror", "ErrorNotExcludeUser"),  $code=400);
    }
}
