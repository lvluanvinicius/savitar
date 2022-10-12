<?php

namespace App\Libs;

use Exception;

class SshLib {

    private $connection;

    // Iniciar conexão...
    /**
     * Método de criação de conexão SSH.
     * Inicia uma comunicação com o host a cada chamada.
     * Não conecta diretamente, pois é necessário authenticação, realizada no método authorizationPassword().
     *
     * @param string $host
     * @param integer $port
     * @return boolean
     */
    public function connect($host, $port = 22)
    {
        try {
            $this->connection = \ssh2_connect($host, $port);
            return $this->connection ? true : false;
        } catch (Exception $e) {
            return false;
        }

    }


    /**
     * Método de login com username e password.
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function authorizationPassword($username, $password)
    {

        // tratando erro de excessão que está sendo gerado ao inserir usuário e senha incorretos.
        try {
            // Caso seja autenticado, será retornado true e se não conectar, retorna false.
            return $this->connection ? \ssh2_auth_password($this->connection, $username, $password) : false;
        } catch (Exception $e) {
            // if (\str_contains($e->getMessage(), "Authentication failed")) return false; // Utilizar futuramente na geração de logs, para auditoria.

            // Retorna false, em qualquer excessão.
            return false;
        }
    }


    /**
     * Método de remoção de sessão.
     *
     * @return boolean
     */
    public function disconnection()
    {
        // Desconecta...
        if (!$this->connection) \ssh2_disconnect($this->connection);

        // Limpa sessão...
        $this->connection = null;

        return true;
    }

    /**
     * Método responsável por buscar o retorno de saída do comando a execução.
     *
     * @param resource $stream
     * @param integer $id
     * @return string
     */
    private function getOutput($stream, $id)
    {
        // Saída Stream...
        $stdOut = \ssh2_fetch_stream($stream, $id);

        // Conteudo...
        return \stream_get_contents($stdOut);
    }

    /**
     * Método de execução de commando.
     *
     * @param string $command
     * @param string $stdErr
     * @return string
     */
    public function executeCommand($command, &$stdErr = null)
    {
        // Se conexão existe...
        if (!$this->connection) return null;

        // Executa comando...
        if (!$stream = \ssh2_exec($this->connection, $command)) {
            return null;
        }

        // Bloquear a stream...
        stream_set_blocking($stream, true);

        // Saída de sucesso...
        $stdIo = $this->getOutput($stream, \SSH2_STREAM_STDIO);

        // Saída de erro...
        $stdErr = $this->getOutput($stream, \SSH2_STREAM_STDERR);

        // Desbloquear a stream
        stream_set_blocking($stream, false);

        // Retornar STDIO...
        return $stdIo;

    }
}
