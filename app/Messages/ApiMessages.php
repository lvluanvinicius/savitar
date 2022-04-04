<?php

namespace App\Messages;


Trait ApiMessages {

    /**
     * Mensagens de sucesso.
     *
     * @var array
     */
    private $apisuccess = [
        "SuccessGeneratedToken" => "Token gerado com sucesso.",
        "SuccessKeyUpdate" => "Token revogado com sucesso."
    ];

    /**
     * Mensagens de erro.
     *
     * @var array
     */
    private $apierror = [
        /// AuthController
        "ErrorLoginNotAssoc" => "Usuário ou senha incorretos.",
        "ErrorLoginNotInformed" => "Dados de autenticação não foram informados corretamente.",
        "ErrorUnauthorizedRoute" => "Você não tem permissão para acessar esse recurso.",
        "ErrorRevokeKeyUnauthorized" => "Você precisa estar logado para revogar sua chave de acesso.",


        /// DatacomController
        "ErrorTryingInitiateConnectionHost" => "Erro ao tentar iniciar uma conexão com o host.",
        "ErrorSSHCredentials" => "Erro na autenticação. Usuário ou senha não confere.",
        "ErrorStdOut" => "Houve um erro no processamento dos dados ou foi gerado um erro na saída da consulta.",
        "ErrorSintaxCommand" => "Houve um erro de sintax ou o comando não é válido.",
        "ErrorNoEntriesFound" => "Nenhuma entrada para encontrada para a consulta executada.",
    ];

    /**
     * Mensagens de informações.
     *
     * @var array
     */
    private $apiinfo = [
        "UserDoesNotHaveKey" => "Você não possui nenhuma chave ativa."
    ];

}
