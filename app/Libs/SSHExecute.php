<?php

namespace App\Libs;

use App\Libs\SshLib as LibsSshLib;
use Error;

class SSHExecute {

    /**
     * Método de consulta de pons.
     * Retorna uma string da consulta
     * @param Request $credentials
     * @return string
     */
    public function getInOLTPonsOnus($credentials)
    {
        // Instancia de SSH Libs
        $ssh = new LibsSshLib();

        // Buscando Host e Porta.
        $splitHost = explode(":", $credentials->ip_host);


        // Conexão com o Host.
        if (!$ssh->connect($splitHost[0], $splitHost[1])) return "E00160";

        // Verificando se credencias são compatíveis.
        if (!$ssh->authorizationPassword($credentials->username, $credentials->password)) return "E00161";

        /**
         * Executar o comando de consulta.
         * Não há adaptação para consulta na OLT diretamente.
         */
        $consult = $ssh->executeCommand("show interface gpon 1/1/$credentials->ponid onu", $error);

        $ssh->disconnection();

        /**
         * Captura e retorna um erro sem entradas.
         */
        if (str_contains($consult, 'No entries found')) return "E00173";


        /**
         * Captura erro de saída e retorna um código para tratamento.
         */
        if($error) return "E00171";

        if (\str_contains($consult, "syntax error")) return "E00172";

        return $consult;
    }

    /**
     * Método de consulta de pons.
     * Retorna uma string da consulta
     * OLT: Datacom
     *
     * @param Request $credentials
     * @return string
     */
    public function discoveryPonsDatacom($credentials)
    {
        // Instancia de SSH Libs
        $ssh = new LibsSshLib();

        // Buscando Host e Porta.
        $splitHost = explode(":", $credentials->ip_host);


        // Conexão com o Host.
        if (!$ssh->connect($splitHost[0], $splitHost[1])) return "E00160";


        // Verificando se credencias são compatíveis.
        if (!$ssh->authorizationPassword($credentials->username, $credentials->password)) return "E00161";

        /**
         * Executar o comando de consulta.
         * Não há adaptação para consulta na OLT diretamente.
         */
        $consult = $ssh->executeCommand("show interface gpon | nomore", $error); // dis pons
        // $consult = $ssh->executeCommand("show interface gpon brief", $error); // dis ponsshow interface gpon brief

        $ssh->disconnection();

        /**
         * Captura erro de saída e retorna um código para tratamento.
         */
        if($error) return "E00171";

        if (\str_contains($consult, "syntax error")) return "E00172";

        return $consult;
    }

    public function loadAlarmsInPons($credentials)
    {
        // Instancia de SSH Libs
        $ssh = new LibsSshLib();

        // Buscando Host e Porta.
        $splitHost = explode(":", $credentials->ip_host);


        // Conexão com o Host.
        if (!$ssh->connect($splitHost[0], $splitHost[1])) return "E00160";

        // Verificando se credencias são compatíveis.
        if (!$ssh->authorizationPassword($credentials->username, $credentials->password)) return "E00161";

        /**
         * Executar o comando de consulta.
         * Não há adaptação para consulta na OLT diretamente.
         */
        $consult = $ssh->executeCommand("show alarm | include 1/1/$credentials->ponid/ | nomore", $error);

        $ssh->disconnection();

        /**
         * Captura e retorna um erro sem entradas.
         */
        if (str_contains($consult, 'No entries found')) return "E00173";


        /**
         * Captura erro de saída e retorna um código para tratamento.
         */
        if($error) return "E00171";

        if (\str_contains($consult, "syntax error")) return "E00172";

        return $consult;
    }
}
