<?php


namespace App\Libs\Client;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BASHClient {

    //
    public function execute($command)
    {
        //
        $proc = new Process($command);

        $proc->setTimeout(300000);

        $proc->run();

        if (!$proc->isSuccessful()) {
            throw new ProcessFailedException($proc);
        }

        return $proc->getOutput();
    }
}