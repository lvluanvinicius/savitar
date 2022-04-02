<?php


namespace App\Traits\Bridge;

use App\Libs\SSHExecute;

Trait SSHBridge {

    /**
     * Método ponte responsável por ligar camada de login com controller.
     * OLT: Datacom
     * @param array $credentials
     * @return string
     */
    public static function bridgeLoadPons($credentials)
    {
        //Instância de SSH Command Execute.
        $ssh = new SSHExecute;

        // Consulta.
        return $ssh->getInOLTPons($credentials);

    }

    public static function bridgeDiscoveryPonsDatacom($credentials)
    {
        //Instância de SSH Command Execute.
        $ssh = new SSHExecute;

        // Consulta.
        return $ssh->discoveryPonsDatacom($credentials);
    }
}
// discoveryPonsDatacom
