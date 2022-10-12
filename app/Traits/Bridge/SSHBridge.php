<?php


namespace App\Traits\Bridge;

use App\Libs\SSHExecute;

Trait SSHBridge {

    /**
     * Método ponte responsável por ligar camada de login com controller.
     * Equipamentos OLTs ou Switchs Datacom DMOS
     * @param array $credentials
     * @return string
     */
    public static function bridgeLoadPons($credentials)
    {
        //Instância de SSH Command Execute.
        $ssh = new SSHExecute;

        // Consulta.
        return $ssh->getInOLTPonsOnus($credentials);

    }

    /**
     * Método de descobeta de pons em Equipamentos OLTs ou Switchs Datacom DMOS.
     * Interliga a classe de conexão ssh.
     * @param array $credentials
     * @return string
     */
    public static function bridgeDiscoveryPonsDatacom($credentials)
    {
        //Instância de SSH Command Execute.
        $ssh = new SSHExecute;

        // Consulta.
        return $ssh->discoveryPonsDatacom($credentials);
    }

    /**
     * Método de consulta de alarms em Equipamentos OLTs ou Switchs Datacom DMOS.
     * Interliga a classe de conexão ssh.
     * @param array $credentials
     * @return string
     */
    public static function bridgeLoadAlarmsInPons($credentials)
    {
        //Instância de SSH Command Execute.
        $ssh = new SSHExecute;

        return $ssh->loadAlarmsInPons($credentials);
    }
}
// discoveryPonsDatacom
