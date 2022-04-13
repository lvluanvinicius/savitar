<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsersGroups;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Exception;
use Illuminate\Http\Request;

class UsersGroupController extends Controller
{
    use LoadMessages, AppResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gpusers = UsersGroups::get();

        return view("admin.gpusers.index")->with([
            "title" => "Grupo de Usuários | " . env("APP_NAME"),
            "subtitle" => "Grupo de Usuários",
            "gpusers" => $gpusers,
        ]);
    }

    /**
     * Create new Group User.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        // Valida se as sessões informadas são válidas.
        for ($prmIndex = 0; $prmIndex < count($request->permissions); ++$prmIndex) {
            if (!validatePermissions($request->permissions[$prmIndex])) return $this->error($this->getMessage("apperror", "ErrorInvalidPermissions"),  $code=400);
        }

        // Verifica se o nome do grupo tem mais que 5 caracteres.
        if (strlen($request->gname) < 5) {
            return $this->error($this->getMessage("apperror", "ErrorInvalidError"),  $code=400);
        }

        // Verifica se as permissões são nulas.
        if (is_null($request->permissions)) {
            return $this->error($this->getMessage("apperror", "ErrorPermissionNotInformed"),  $code=400);
        }

        // Verifica se a criação foi confirmada.
        if ($request->confirm_add_gpuser != "on") {
            return $this->error($this->getMessage("apperror", "ErrorAddChange"),  $code=400);
        }

        try {

            $gpuser = new UsersGroups();
            $gpuser->gname = $request->gname;
            $gpuser->permissions =  json_encode( $request->permissions);
            $gpuser->save();

            return $this->success($this->getMessage("appsuccess", "SuccessAddUserGroup"),  $code=200);

        } catch(Exception $e) {
            if ($e->errorInfo[0] == "23000" && $e->errorInfo[1] == 1062) {
                return $this->error($this->getMessage("apperror", "ErrorGroupUserAlreadyExists"),  $code=400);
            }
            return $this->error($this->getMessage("apperror", "ErrorException"),  $code=400);
        }

        return $this->error($this->getMessage("apperror", "ErrorAddGroup"),  $code=400);
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
     * Display the specified User Group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $gpuser = UsersGroups::where("id", $request->id)->first();

        return view('admin.gpuser-show.index')->with([
            "title" => $gpuser->gname . " | " . env("APP_NAME"),
            "gpuser" => $gpuser,
        ]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if (strlen($request->gname) < 5) {
            return $this->error($this->getMessage("apperror", "ErrorInvalidError"),  $code=400);
        }

        $permissions = json_encode($request->permissions); // Convertendo em string json o array de permissão.

        /// Atualiza as permissões para somente "*" no caso de o usuário selecionar all.
        if (str_contains($permissions, "*"))
        {
            $permissions = json_encode(["*"]);
        }

       try {
            $gpuser = UsersGroups::where('id', $request->id_user_group)->first();

            $gpuser->gname = $request->gname;
            $gpuser->permissions = $permissions;

            $gpuser->save();

            return $this->success($this->getMessage("appsuccess", "SuccessUpdateUserGroup"),  $code=200);

       } catch (Exception $e) {
            return $this->error($this->getMessage("apperror", "ErrorException"),  $code=400);
        }

        return $this->error($this->getMessage("apperror", "ErrorUpdateGroup"),  $code=400);
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
            $gpuser = UsersGroups::where("id", $request->id)->first();

            try {
                if ($gpuser->delete()) {
                    return $this->success($this->getMessage("appsuccess", "SuccessDeleteUserGroup"), $code=200);
                }
                return $this->error($this->getMessage("apperror", "ErrorNotPossibleExcludeUserGroup"),  $code=400);
            } catch (Exception $e) {
                return $this->error($this->getMessage("apperror", "ErrorNotExcludeUserGroup"),  $code=400);
            }
            return $this->error($this->getMessage("apperror", "ErrorNotExcludeUserGroup"),  $code=400);
        }

        dd($request->all());
    }
}
