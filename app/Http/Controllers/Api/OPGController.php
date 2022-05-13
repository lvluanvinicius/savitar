<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Client\BASHClient;
use App\Libs\Client\HTTPClient;
use App\Traits\ApiResponser;
use App\Traits\LoadMessages;
use Exception;
use Illuminate\Http\Request;

class OPGController extends Controller
{
    use LoadMessages, ApiResponser;

    private function getOffSet()
    {
        //
    }
    
    public function getAlertsBkp(Request $request)
    {
        $http = new HTTPClient();

        // Recuperar dados na API.
        $respData = $http->get_reports_alerts($request->all());
        
        // Salvar dados do request em params.
        $requestParams = $request->all();

        // Recuperar o OffSet da primeira requisição.
        $offset = intval(explode("=", explode("&", $respData["paging"]["last"])[2])[1]);

        // Array geral para concatenar os dados.
        $newDataResponse = [];

        // Contador de OffSet.
        $countSet=0;
        while ($countSet < $offset) 
        {
            // Alterar OffSet nos parametros.
            $requestParams["offset"] = $countSet;

            // Recuperar novos dados na API a partir de um novo OffSet.
            $resp = $http->get_reports_alerts($requestParams);
            
            try {
                array_push($newDataResponse, $resp["data"]);
            } catch (Exception $err) {
                break;
            }

            // Contagem do countSet.
            $countSet+=1;
        }

        // Retornar novo json.
        json_encode($newDataResponse);
    }

    public function getAlerts(Request $request)
    {
        // 
        $bash = new BASHClient;
        $output = $bash->execute(["/usr/bin/python3", "/var/www/html/scripts/script.py"]);

        return $this->success($output);
    }
}
