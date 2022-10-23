<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupUsers;
use App\Models\PermissionsSystem;
use App\Traits\AppResponse;
use Error;
use Exception;
use Illuminate\Http\Request;

class GroupUsersController extends Controller
{
    use AppResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = GroupUsers::all();
        return view('admin.groupusers.index')->with([
            "title" => "Grupos de Usuários | " . env('APP_NAME'),
            "subtitle" => "Grupos de Usuários",
            "group_users" => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $perms = PermissionsSystem::all();

        $perms_page = [
            "pages" => [],
            "actions" => [],
        ];

        foreach ($perms as $per) {
            if ($per->type == 0) {
                array_push($perms_page["pages"], $per);
            } else {
                array_push($perms_page["actions"], $per);
            }
        }

        return view('admin.groupuserscreate.index')->with([
            "title" => "Novo Grupo | " . env('APP_NAME'),
            "subtitle" => "Novo Grupo",
            "perms" => $perms_page,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (in_array('', $request->only(['name']))) throw new Exception("Name not informed");

            $data = $request->all();
            $data['permissions'] = join(";", $data['permissions']);

            $gpusers = new GroupUsers();

            $gpusers->name = $data['name'];
            $gpusers->permissions = $data['permissions'];

            $gpusers->save();
            return $this->success($type = 0, "Grupo criado com sucesso.",  $code = 200);

        } catch (Exception $err) {
            if (str_contains($err->getMessage(), 'Name not informed'))
                return $this->error($type = 0, "Não foi informado nenhum nome para o grupo.",  $code = 400);

            if (str_contains($err->getMessage(), 'Undefined array key "permissions"'))
                return $this->error($type = 0, "Nenhuma permissão foi informada.",  $code = 400);

            if (str_contains($err->getMessage(), "1062 Duplicate entry"))
                return $this->error($type = 0, "O nome do grupo já existe.",  $code = 400);

            return $this->error($type = 0, $err->getMessage(),  $code = 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
