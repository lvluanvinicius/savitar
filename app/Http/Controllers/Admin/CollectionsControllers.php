<?php

namespace App\Http\Controllers\Admin;

use App\Charts\GponsCharts;
use App\Http\Controllers\Controller;
use App\Models\AverageDBM;
use App\Models\ImportDBTask;
use App\Models\OltConfig;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class CollectionsControllers extends Controller
{
    use AppResponse, LoadMessages;

    public function dashboard(Request $request)
    {
        // dd($request->start_filter);
        /**
         * Verificando se ID foi informado para busca de dados em relação ao equipamento selecionado.
         * Os dados vem de acordo com o equipamento selecionado em OLT Config.
         */
        if (!$request->id)
        {
            return redirect()->route("admin.collections.olt.config")->with([
                'status' => 'Error',
			    'message' => $this->getMessage("apperror", "ErrorEquipmentSelectedForGraphs")
            ]);
        }

        return view("admin.collections-dashboard.index")->with([
            "title" => "DBM Dashboard | " . env("APP_NAME"),
        ]);
    }

    /**
     * Retornando a página de equipamentos e equipamentos.
     *
     * @return void
     */
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
        //
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

        $dbm = AverageDBM::
                join('olt_config', function ($join) {
                    //
                    $join->on('pons_average_dbm.ID_OLT', "=", "olt_config.id");
                })->take(100)->get();

        $imports_tasks = ImportDBTask::where("finished", "=", 0)->get();

        return view("admin.collections.index")->with([
            "title" => "DBM Coleções | " . env("APP_NAME"),
            "dbm_collections" => $dbm,
            "imports_tasks" => $imports_tasks
        ]);
    }

    public function delete_dbm_import_task(Request $request)
    {
        //
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

            if (str_contains($process->getOutput(), "Error: E01001") )
            {
                return $this->getMessage("apperror", "ErrorFileNotExistsCSVTask");
            }

            ImportDBTask::where('id', "=", $request->idITask)->update([
                "finished" => 1
            ]);

            return $this->getMessage("appsuccess", "SuccessExecuteTask");
        } catch (Exception $err) {
            return $err->getMessage();
            // throw new Error($err);
        }
    }


    public function get_dbm_pons()
    {
        //
    }

}

