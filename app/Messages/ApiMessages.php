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
        "ErrorLoginNotAssoc" => "Usuário ou senha incorretos.",
        "ErrorLoginNotInformed" => "Dados de autenticação não foram informados corretamente.",
        "ErrorUnauthorizedRoute" => "Você não tem permissão para acessar esse recurso.",
        "ErrorRevokeKeyUnauthorized" => "Você precisa estar logado para revogar sua chave de acesso.",
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
