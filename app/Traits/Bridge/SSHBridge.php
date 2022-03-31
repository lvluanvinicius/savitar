<?php


namespace App\Traits\Bridge;

use App\Libs\SSHExecute;

Trait SSHBridge {

    /**
     * Método ponte responsável por ligar camada de login com controller.
     *
     * @param array $credentials
     * @return string ip_host
     */
    public static function bridgeLoadPons($credentials)
    {
        //
        $ssh = new SSHExecute;

        return $ssh->getInOLTPons($credentials);

    }
}
