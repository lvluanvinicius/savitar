<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKeys;
use App\Models\GroupsRelated;
use App\models\User;
use App\Models\UsersGroups;
use Illuminate\Http\Request;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AppResponse, LoadMessages;


    /**
     * Retorna a página de usuários já com os dados carregados.
     *  Não retorna o usuário logado.
     *  - A atualização do próprio usuário, é necessário estar logado e realizar pela página Profile.
     *
     * @param Request $request
     * @return void
     */
    public function profile(Request $request)
    {
        $user = User::where("id", auth()->user()->id)->first(); // Busca os dados do usuário logado;
        $key = ApiKeys::where("tokenable_id", auth()->user()->id)->first(); // Busca o token usuário logado;

        return view('admin.profile.index')->with([
            "title" => $user->name . " | ". env('APP_NAME'),
            "user" => $user,
            "subtitle" => $user->name,
            "mykey" => $key,
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
        $users = User::get();
        $gusers = UsersGroups::get();

        return view('admin.users.index')->with([
            "title" => "Usuários | ". env('APP_NAME'),
            "users" => $users,
            "gusers" => $gusers,
            "subtitle" => "Usuários"
        ]);
    }

   /**
    * Edit User Method.
    *
    * @param Request $request
    * @return void
    */
    public function edituser(Request $request)
    {
        // Verificar se tem permissão para atualização.
        if (checkNivel(auth()->user()->id, "update") || checkNivel(auth()->user()->id, "*")) {

            // Valida se o e-mail informado é válido.
            if (is_null($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                return $this->error($this->getMessage("apperror", "ErrorEmailNotInformed"),  $code=400);
            }

            // Valida se a senha informada possui mais que 10 caracteres.
            if (strlen($request->password) <= 10) {
                return $this->error($this->getMessage("apperror", "ErrorShortPassword"),  $code=400);
            }

            // Verifica se foi confirmada a alteração;
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

        return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRoute"),  $code=401);
    }

    /**
     * Atualização de permissões para usuários.
     *
     * @param Request $request
     * @return void
     */
    public function updatepermissions(Request $request)
    {
        // Verificar se tem permissão para atualização.
        if (checkNivel(auth()->user()->id, "update") || checkNivel(auth()->user()->id, "*")) {
            if (is_null($request->group_users)) {
                return $this->error($this->getMessage("apperror", "ErrorUpdatedPermissionsSelected"), $code=400);
            }

            try {
                $grouprelated = GroupsRelated::where("id_user", $request->id_user)->first();
                $grouprelated->id_group_users = $request->group_users;
                $grouprelated->save();

                //dd($grouprelated);

                return $this->success($this->getMessage("appsuccess", "SuccessUpdatedUserPermission"),  $code=200);

            } catch(Exception $e) {
                return $this->error($this->getMessage("apperror", "ErrorException"),  $code=400);
            }
        }

        return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRoute"),  $code=401);
    }

    /**
     * Edição de usuários.
     *
     * @param Request $request
     * @return void
     */
    public function listondeuser(Request $request)
    {
        $id_user = $request->all('id');
        $user = User::where('id', $id_user)->first();
        $key = ApiKeys::where("tokenable_id", $id_user)->first();
        $gusers = UsersGroups::get();

        return view('admin.useredit.index')->with([
            "title" => "$user->name | " . env('APP_NAME'),
            "user" => $user,
            "gusers" => $gusers,
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

        // Valida se o e-mail informado é válido.
        if (is_null($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->error($this->getMessage("apperror", "ErrorEmailNotInformed"),  $code=400);
        }

        // Verifica se a senha tem ao menos 10 carracteres.
        if (strlen($request->password) <= 9) {
            return $this->error($this->getMessage("apperror", "ErrorShortPassword"),  $code=400);
        }

        // Verifica se a alteração foi confirmada.
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
        // Verificar se tem permissão para criação.
        if (checkNivel(auth()->user()->id, "create") || checkNivel(auth()->user()->id, "*")) {

            // Verifica se o nome tem mais que 5 caracteres;
            if (strlen($request->name) < 5) {
                return $this->error($this->getMessage("apperror", "ErrorInvalidError"),  $code=400);
            }

            // Verifica se o e-mail informado é válido.
            if (is_null($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                return $this->error($this->getMessage("apperror", "ErrorEmailNotInformed"),  $code=400);
            }

            // Verifica se a senha tem ao menos 10 caracteres.
            if (strlen($request->password) <= 9) {
                return $this->error($this->getMessage("apperror", "ErrorShortPassword"),  $code=400);
            }

            // Verifica se a criação foi confirmada.
            if ($request->confirm_add_user != "on") {
                return $this->error($this->getMessage("apperror", "ErrorAddChange"),  $code=400);
            }

            try {

                $user = new User();
                $grouprelated = new GroupsRelated();

                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->last_access_login = date('Y-m-d H:i:s');
                $user->save();

                $grouprelated->id_group_users = $request->group_users;
                $grouprelated->id_user = $user->id;

                $grouprelated->save();

                return $this->success($this->getMessage("appsuccess", "SuccessAddUser"),  $code=200);

            } catch(Exception $e) {
                if ($e->errorInfo[0] == "23000" && $e->errorInfo[1] == 1062) {
                    return $this->error($this->getMessage("apperror", "ErrorEmailAlreadyExists"),  $code=400);
                }
                return $this->error($this->getMessage("apperror", "ErrorException"),  $code=400);
            }

            return $this->error($this->getMessage("apperror", "ErrorAddNewUser"),  $code=400);

        }

        return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRoute"),  $code=401);

    }


    /**
     * Exclusão de usuários.
     *
     * @param Request $request
     * @return void
     */
    public function deleteuser(Request $request)
    {
	if (auth()->user()->id == $request->id) dd('Você não pode se excluir');
	dd("parado");

        // Verificar se tem permissão para exclusão.
        if (checkNivel(auth()->user()->id, "delete") || checkNivel(auth()->user()->id, "*")) {

            if (is_numeric($request->id)) {
                $user = User::where("id", $request->id)->first();
                $related = GroupsRelated::where("id_user", $request->id)->first();

                try {
                    if ($related->delete()) {
                        if ($user->delete()) {
                            return $this->success($this->getMessage("appsuccess", "SuccessDeleteUser"), $code=200);
                        }
                    }
                } catch (Exception $e) {
                    dd($e);
                    return $this->error($this->getMessage("apperror", "ErrorNotExcludeUser"),  $code=400);
                }
                return $this->error($this->getMessage("apperror", "ErrorNotExcludeUser"),  $code=400);
            }
            return $this->error($this->getMessage("apperror", "ErrorNotExcludeUser"),  $code=400);
        }

        return $this->error($this->getMessage("apperror", "ErrorUnauthorizedRoute"),  $code=401);
    }
}
