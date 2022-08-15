<?php

namespace App\Messages;


Trait AppMessages {

    /**
     * Mensagens de sucesso
     *
     * @var array
     */
    private $appsuccess = [
        // Usuários
        "SuccessLoginUser" => "Seja bem vindo!",
        "SuccessDeleteUser" => "Usuário excluído com sucessso.",
        "SuccessUpdatedUser" => "Usuário atualizado com sucesso.",
        "SuccessAddUser" => "Usuário criado com sucesso.",
        "SuccessUpdatedUserPermission" => "Permissões atualizadas com sucesso.",

        // Apis Keys
        "SuccessDeleteApiKey" => "Chave deletada com sucesso",

        // Users Group
        "SuccessAddUserGroup" => "Grupo criado com sucesso.",
        "SuccessDeleteUserGroup" => "Grupo de Usuário excluído com sucesso.",
        "SuccessUpdateUserGroup" => "Grupo de Usuário atualizado com sucesso.",

        // Collections
        "SuccessUploadFile" => "Arquivo salvo com sucesso.",
    ];

     /**
     * Mensagens de erro
     *
     * @var array
     */
    private $apperror = [
        // Other
        "ErrorUnauthorizedRoute" => "Você não tem permissão para acessar esse recurso.",

        // Usuários
        "ErrorUnableToConnectToDataServer" => "Houve um erro ao tentar se conectar a base de dados para localizar seu usuário. Se esse erro persistir, consulte nosso suporte.",
        "ErrorLoginUser" => "Usuário ou senha incorretos",
        "ErrorNotExcludeUser" => "Falha na exclusão ou cliente não foi localizado.",
        "ErrorEmailAlreadyExists" => "O E-mail já existe.",
        "ErrorEmailNotInformed" => "E-mail informado não é válido.",
        "ErrorShortPassword" => "Sua senha deve possui 10 ou mais caracteres.",
        "ErrorConfirmChange" => "Você precisa confirmar a alteração.",
        "ErrorUserOrPassNotSnown" => "Usuário ou senha não foi informado.",
        "ErrorIncorrectUserOrPass" => "E-mail ou senha estão incorretos.",
        "ErrorAddNewUser" => "Houve um erro ao tentar salvar o usuário.",
        "ErrorInvalidError" => "O nome precisa ser informado ou termais que 5 caractere.",
        "ErrorAddChange" => "Você precisa confirmar a criação.",
        "ErrorUnauthorizedRouteCreateUser" => "Você não possui permissão para adicionar novos usuários.",
        "ErrorUnauthorizedRouteUpdateUser" => "Você não possui permissão para atualizar usuários.",
        "ErrorUnauthorizedRouteDeleteUser" => "Você não possui permissão para excluír usuários.",
        "ErrorSelectedPermissions" => "Selecione as permissões para esse usuário.",
        "ErrorUpdatedPermissionsSelected" => "Você precisa selecionar uma permissão antes.",

        // Users Group
        "ErrorPermissionNotInformed" => "Selecione ao menos uma permissão para esse grupo.",
        "ErrorGroupUserAlreadyExists" => "O Grupo de Usuário já existe.",
        "ErrorAddGroup" => "Houve um erro ao tentar criar o grupo de usuários.",
        "ErrorNotExcludeUserGroup" => "Erro ao tentar excluír esse grupo de usuário.",
        "ErrorNotPossibleExcludeUserGroup" => "Não foi possível excluir esse grupo de usuário ou não foi encontrado.",
        "ErrorUnauthorizedRouteCreateGroup" => "Você não possui permissão para adicionar novos grupos de usuários.",
        "ErrorUnauthorizedRouteUpdateGroup" => "Você não possui permissão para atualizar grupos de usuários.",
        "ErrorUnauthorizedRouteDeleteGroup" => "Você não possui permissão para excluír grupos de usuários.",
        "ErrorUpdateGroup" => "Não foi possível atualizar esse grupo de usuário ou não foi encontrado.",
        "ErrorInvalidPermissions" => "Você informou uma permissão inválida ou que não existe.",


        // Exception
        "ErrorException" => "Houve um erro ao tentar salvar o usuário.",

        // Apis Keys
        "ErrorNotExcludeApiKey" => "Falha na exclusão da api ou ela não foi encontrada.",

        // Collections
        "ErrorFileNotInformed" => "Arquivo não informado.",
    ];
}
