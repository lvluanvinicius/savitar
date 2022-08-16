<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AverageDBM;
use App\Models\ImportDBTask;
use App\Models\OltConfig;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Error;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CollectionsControllers extends Controller
{
    use AppResponse, LoadMessages;

    public function dashboard()
    {

        return view("admin.collections-dashboard.index")->with([
            "title" => "DBM Dashboard | " . env("APP_NAME")
        ]);
    }

    public function list_olt_config()
    {
        $olts = OltConfig::get();

        return view('admin.olt-config.index')->with([
            "title" => "Configuração de OLTs | " . env("APP_NAME"),
            "olts" => $olts
        ]);
    }

    /**
     * Carregamento de coletas de DBM.
     *
     * @return void
     */
    public function list_dbm_collections()
    {

        $dbm = AverageDBM::where('DBM_AVERAGE', "<=", -27)
                ->join('olt_config', function ($join) {
                    //
                    $join->on('pons_average_dbm.ID_OLT', "=", "olt_config.id");
                })->get();

        $imports_tasks = ImportDBTask::where("finished", "=", 0)->get();


        // $dbm = DB::table('pons_average_dbm')
        //     ->join('olt_config', function () {

        //     });

        return view("admin.collections.index")->with([
            "title" => "DBM Coleções | " . env("APP_NAME"),
            "dbm_collections" => $dbm,
            "imports_tasks" => $imports_tasks
        ]);
    }


    public function update_olt_config(Request $request)
    {
        dd($request->id);
        // $olt = OltConfig::where('id', "=", $request->id);
    }


    public function save_dbm_collections(Request $request)
    {
        // Validando arquivo e extensão
        $request->validate([
            "data_file" => "required|mimes:csv"
        ]);

        // Carregando Extensão.
        $ext = $request->data_file->getClientOriginalExtension();

        // Se existe arquivo selecionado.
        if ($request->data_file) {
            try {
                // Carregando nome para arquivo.
                $nameFile = time() . '-DATACOM.' . $ext;

                // Salvando arquivo e retornando path.
                $path = $request->data_file->storeAs('data', $nameFile);

                // Salvando dados de acesso ao arquivo em banco.
                ImportDBTask::create([
                    "name_file" => $nameFile,
                    "path" => $path,
                    "id_user" => auth()->id()
                ]);

                // Retornando resposta ao usuário.
                return $this->success($this->getMessage("appsuccess", "SuccessUploadFile"),  $code=200);
            } catch (Exception $err) {
                // $this->getMessage("apperror", "ErrorFileNotInformed")
                return $this->error($err->getMessage(),  $code=400);
            }
        }

        return $this->error($this->getMessage("apperror", "ErrorFileNotInformed"),  $code=400);
    }

    public function execute_dbm_import_task(Request $request)
    {
        $task = ImportDBTask::where('id', "=", $request->idITask)->first();

        if ($task->finished != 0) return $this->getMessage("apperror", "ErrorTaskAlreadyPerformed");

        try {
            $process = new Process(["python3", "/var/www/html/scripts/main.py", "data/1660612628-DATACOM.csv"]);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            ImportDBTask::where('id', "=", $request->idITask)->update([
                "finished" => 1
            ]);

            return $this->getMessage("appsuccess", "SuccessExecuteTask");
        } catch (Exception $err) {
            throw new Error($err);
        }
    }

    public function delete_dbm_import_task(Request $request)
    {
        //
    }


    public function get_dbm_pons()
    {
        //
    }

}
