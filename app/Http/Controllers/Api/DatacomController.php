<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Traits\Bridge\SSHBridge;
use App\Traits\LoadMessages;
use Illuminate\Http\Request;


class DatacomController extends Controller
{
    use SSHBridge, LoadMessages, ApiResponser;

    /**
     * Método de consulta de PONs.
     * Retorna total de ONUs Off e Total de ONUs On em valor de porcentagem.
     * Retorna o total de ONUs na PON.
     *
     * @param Request $request
     * @return Array
     */
    public function loadPons(Request $request)
    {
        // Consulta.
        $sshConsult = $this->bridgeLoadPons($request);

        // Se houver erro de comunicação.
        if ($sshConsult == "E00160") return $this->error($this->getMessage("apierror", "ErrorTryingInitiateConnectionHost"), 200);

        // Se houver erro de autenticação.
        if ($sshConsult == "E00161") return $this->error($this->getMessage("apierror", "ErrorSSHCredentials"), 200);

        // Se houver erro na saída do comando.
        if ($sshConsult == "E00171") return $this->error($this->getMessage("apierror", "ErrorStdOut"), 200);

        // Se houve um erro de sintax no comando.
        if ($sshConsult == "E00172") return $this->error($this->getMessage("apierror", "ErrorSintaxCommand"), 200);

        // Tratar dados...
        $sshArray = explode("\n", $sshConsult);
        $TotalDown = 0; // Totaliza quantas ONUs estão off.
        $TotalUp = 0; // Totaliza quantas ONUs estão on.
        $total = 0; // Totaliza quantas ONUs estão visiveis a serem tratadas.

        // Percorrendo dados recebidos e realizando o tratamento.
        foreach ($sshArray as $line) {

            // Contagem de quantas ONUs estão Off.
            if (\str_contains($line, "Down")) {
                if (!\str_contains($line, "Serial Number")) {
                    $TotalDown+=1;
                    $total+=1;
                }
            }
            // Contagem de quantas ONUs estão On.
            elseif (\str_contains($line, "Up")) {
                if (!\str_contains($line, "Serial Number")) {
                    $TotalUp+=1;
                    $total+=1;
                }
            }

        }

        // Dados de retorno.
        $responseStatus = [
            "TotalONUs" => $total,
            "totalUp"=> $TotalUp / $total * 100,
            "totalDown" => $TotalDown / $total * 100,
        ];

        // Retornar resultado do processamento.
        return $this->success($responseStatus);
    }

    /**
     * Undocumented function
     * OLT: Datacom
     * @param Request $request
     * @return void
     */
    public function discoveryPonsDatacom(Request $request)
    {
        // Consulta.
        $sshConsult = $this->bridgeDiscoveryPonsDatacom($request);

        // Se houver erro de comunicação.
        if ($sshConsult == "E00160") return $this->error($this->getMessage("apierror", "ErrorTryingInitiateConnectionHost"), 200);

        // Se houver erro de autenticação.
        if ($sshConsult == "E00161") return $this->error($this->getMessage("apierror", "ErrorSSHCredentials"), 200);

        // Se houver erro na saída do comando.
        if ($sshConsult == "E00171") return $this->error($this->getMessage("apierror", "ErrorStdOut"), 200);

        // Se houve um erro de sintax no comando.
        if ($sshConsult == "E00172") return $this->error($this->getMessage("apierror", "ErrorSintaxCommand"), 200);

        // Tratar dados...
        $sshArray = explode("\n", $sshConsult);
        $newSSHArray = [];
        foreach ($sshArray as $line) {
            if (\str_contains($line, "Physical interface")) {
                // Limpando String para filtro da pon.
                $tmp01 = explode(",", $line)[0];
                $tmp02 = explode("gpon", $tmp01);
                $tmp03 = explode("/", str_replace(" ", "", $tmp02[1]));

                // Salvando as pons descobertas.
                \array_push($newSSHArray, ["pon" => $tmp03[2]]);
            }
        }

        // Retornar resultado do processamento.
        return $this->success($newSSHArray);
    }
}

//
