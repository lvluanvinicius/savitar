<?php

namespace App\Libs;

use App\Libs\SshLib as LibsSshLib;
use Error;

class SSHExecute {

    public function getInOLTPons($credentials)
    {
        // Instancia
        $ssh = new LibsSshLib();

        // Conexão com o Host.
        if (!$ssh->connect($credentials["ip_host"])) return "E00160";

        // Verificando se credencias são compatíveis.
        if (!$ssh->authorizationPassword($credentials["username"], $credentials["password"])) return "E00161";

        /**
         * Executar o comando de consulta.
         * Nesse exemplo, é realizado uma consulta em um arquivo armazenado no diretório /tmp.
         * Não há adaptação para consulta na OLT diretamente.
         *
         * Comando executado: cat /tmp/ssh_olt.txt
         */
        $consult = $ssh->executeCommand("cat /tmp/ssh_olt.txt", $error);

        if($error) {
            return "E00171";
        }

        return $consult;

    }
}
