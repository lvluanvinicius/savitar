<?php

namespace App\Http\Controllers\Admin;

use App\Charts\GponsCharts;
use App\Http\Controllers\Controller;
use App\Models\AverageDBM;
use App\Models\ImportDBTask;
use App\Models\OltConfig;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Error;
use Exception;
use Illuminate\Http\Request;
use PDOException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class CollectionsControllers extends Controller
{
    use AppResponse, LoadMessages;

    public function dashboard()
    {
        $olts = OltConfig::get();

        return view("admin.collections-dashboard.index")->with([
            "title" => "DBM Dashboard | " . env("APP_NAME"),
            "olts" => $olts
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

    public function get_olts_and_pons(Request $request)
    {
        $olts = OltConfig::whereIn("id", $request->olts)->get();
        $dbms = AverageDBM::whereIn("ID_OLT", $request->olts)->get();

        $graphPons = new GponsCharts;


        return $dbms;
    }

    public function create_olt_config(Request $request)
    {

        try {
            $olt = OltConfig::create([
                "OLT_NAME" => str_replace(" ", "-", $request->name),
                "PONS" => $request->pons
            ]);

            // Retornando resposta ao usuário.
            return $this->success($this->getMessage("appsuccess", "SuccessEquipmentSaved"),  $code=200);

        } catch (\PDOException $err) {
            if (str_contains($err->getMessage(), "1062 Duplicate entry") )
                return $this->error($this->getMessage("apperror", "ErrorEquipmentAlreadyExists"),  $code=400);;
        }


    }

    public function update_olt_config(Request $request)
    {
        dd($request->id);
        // $olt = OltConfig::where('id', "=", $request->id);
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

        return view("admin.collections.index")->with([
            "title" => "DBM Coleções | " . env("APP_NAME"),
            "dbm_collections" => $dbm,
            "imports_tasks" => $imports_tasks
        ]);
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
            $process = new Process(["python3", env("PATH_SCRIPTS") . "main.py", $task->path]);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            ImportDBTask::where('id', "=", $request->idITask)->update([
                "finished" => 1
            ]);

            // return $process->getOutput();

            return $this->getMessage("appsuccess", "SuccessExecuteTask");
        } catch (Exception $err) {
            return $err->getMessage();
            // throw new Error($err);
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
