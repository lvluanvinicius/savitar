<?php

use App\Models\GroupsRelated;
use App\Models\User;
use App\Models\UsersGroups;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("tmp", function () {

    // $gp = new UsersGroups();
    // $gp->gname = "administrator";
    // $gp->permissions = '["*"]';
    // $gp->save();

    // $related = new GroupsRelated();
    // $related->id_user = 1;
    // $related->id_group_users = 1;
    // $related->save();

    // $user = new User();
    // $user->name = "Luan Santos";
    // $user->email = "luan@teste.com";
    // $user->password = Hash::make("1234");
    // $user->last_access_login = date('Y-m-d H:i:s');
    // $user->save();
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route("app.home");
    }
    return view("index.login")->with(["title" => "Login | " . env("APP_NAME")]);
})->name("login");

Route::post('/login-auth', [App\Http\Controllers\Index\AuthController::class, "logindo"])->name("login.auth");

// Grupo principal do App.
Route::middleware(['auth'])->prefix("app")->group(function () {
    // Home page - Dashbord
    Route::get('/home', [App\Http\Controllers\Admin\IndexController::class, "home"])->name("app.home");

    // Logout app
    Route::post('/logout', [App\Http\Controllers\Index\AuthController::class, "exit"])->name("app.logout");

    // Rotas não privadas a usuários normais.
    Route::get("profile", [App\Http\Controllers\Admin\UserController::class, "profile"])->name('app.profile');
    Route::put("profile-edit", [App\Http\Controllers\Admin\UserController::class, "profileedit"])->name('app.profile.edit');

    // ApisController
    // Chave de usuário apenas.
    Route::put("user-relogin-api", [App\Http\Controllers\Admin\ApisController::class, "update"])->name('app.relogin.api');

    // Grupo de admin/rotas privadas.
    Route::prefix('admin')->group(function () {

        // ApisController
        Route::middleware("keypages")->group(function () {
            Route::get("users-apis-keys", [App\Http\Controllers\Admin\ApisController::class, "index"])->name('admin.apis.list');
            Route::put("user-relogin-api-user", [App\Http\Controllers\Admin\ApisController::class, "updatekeyfromusers"])->name('admin.relogin.api.user');
            Route::delete("user-api-key", [App\Http\Controllers\Admin\ApisController::class, "destroy"])->name('admin.apis.delete');
        });

        // UserController
        Route::middleware("userspage")->group(function () {
            Route::get("users", [App\Http\Controllers\Admin\UserController::class, "listusers"])->name('admin.users');
            Route::get("users-list-one", [\App\Http\Controllers\Admin\UserController::class, "listondeuser"])->name("admin.list.onde.user");
            Route::put("add-new-user", [\App\Http\Controllers\Admin\UserController::class, "adduser"])->name("admin.new.user");
            Route::put("user-edit", [App\Http\Controllers\Admin\UserController::class, "edituser"])->name('admin.user.edit');
            Route::put("user-update-permissions", [App\Http\Controllers\Admin\UserController::class, "updatepermissions"])->name('admin.user.update.permissions');
            Route::delete("user-delete", [App\Http\Controllers\Admin\UserController::class, "deleteuser"])->name('admin.user.delete');
        });

        // UsersGroupController
        Route::middleware("groupuserspage")->group(function () {
            Route::get("group-users", [App\Http\Controllers\Admin\UsersGroupController::class, "index"])->name('admin.users.group');
            Route::get("group-users-edit", [App\Http\Controllers\Admin\UsersGroupController::class, "show"])->name('admin.users.group.store');
            Route::put("group-users-create", [App\Http\Controllers\Admin\UsersGroupController::class, "create"])->name('admin.users.group.create');
            Route::patch("group-users-update", [App\Http\Controllers\Admin\UsersGroupController::class, "update"])->name('admin.users.group.update');
            Route::delete("group-users-delete", [App\Http\Controllers\Admin\UsersGroupController::class, "destroy"])->name('admin.users.group.delete');
        });


        // GraphicsReportsController
        Route::middleware("reportspage")->group(function () {
            Route::get("graphics-reports", [App\Http\Controllers\Admin\GraphicsReportsController::class, "index"])->name('admin.graphcs.reports');
            Route::post("graphics-load-hosts", [App\Http\Controllers\Admin\GraphicsReportsController::class, "getHosts"])->name('admin.graphcs.load.hosts');
            Route::post("graphics-load-graphics", [App\Http\Controllers\Admin\GraphicsReportsController::class, "getGraphics"])->name('admin.graphcs.load.graphics');
            Route::post("graphics-load-graphics-generate", [App\Http\Controllers\Admin\GraphicsReportsController::class, "getGraphicsGenerate"])->name('admin.graphcs.load.graphics.generate');
        });


        // CentralReportsController
        Route::middleware("centralpage")->group(function () {
            Route::get("central", [App\Http\Controllers\Admin\CentralReportsController::class, "index"])->name('admin.central.reports');
            Route::get("central-reports-graphs", [App\Http\Controllers\Admin\CentralReportsController::class, "generalReportsGraphs"])->name('admin.central.reports.general');
            Route::get("central-reports-bi", [App\Http\Controllers\Admin\CentralReportsController::class, "pageTesteBi"])->name('admin.central.reports.bi');
        });


        // CollectionsControllers
        Route::middleware("collections")->group(function () {
            // Dashboard
            Route::get("collections-dbms-dashboard", [App\Http\Controllers\Admin\CollectionsControllers::class, "dashboard"])->name("admin.collections.dbms.dashboard");

            Route::get("collections-olt-config", [App\Http\Controllers\Admin\CollectionsControllers::class, "list_olt_config"])->name("admin.collections.olt.config");
            Route::get("collections-olt-config-update", [App\Http\Controllers\Admin\CollectionsControllers::class, "update_olt_config"])->name("admin.collections.olt.config.update");
            Route::get("collections-dbms-pons", [App\Http\Controllers\Admin\CollectionsControllers::class, "list_dbm_collections"])->name("admin.collections.dbms.pons");

            // Create new OLT.
            Route::put("collections-olt-config-create", [App\Http\Controllers\Admin\CollectionsControllers::class, "create_olt_config"])->name("admin.collections.olt.config.create");

            // Save Export Datacom File and Save in DBM.
            Route::put("collections-dbms-pons-upload-export", [App\Http\Controllers\Admin\CollectionsControllers::class, "save_dbm_collections"])->name("admin.collections.dbms.pons.upload.export");

            // Executa uma importação ao banco de dados.
            Route::post("collections-dbms-pons-imports-execute", [App\Http\Controllers\Admin\CollectionsControllers::class, "execute_dbm_import_task"])->name("admin.collections.dbms.pons.import.execute");

            // Route::delete("collections-olt-config", [App\Http\Controllers\Admin\CollectionsControllers::class, "list_olt_config"])->name("admin.collections.olt.config");


            // Collections Graphs
            Route::post("collections-dbms-get-olts-and-pons", [App\Http\Controllers\Admin\CollectionsControllers::class, "get_olts_and_pons"])->name("admin.collections.dbms.get.olts.and.pons");

        });

    });

});
