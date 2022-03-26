<?php

use App\Models\GroupsRelated;
use App\Models\UsersGroups;

/**
 * Permissions:
 *     - 0: All permissions. (Super Administrador)
 *     - 1: Write, Update, Create and Update. (Administrador)
 *     - 2: Read and Write.   (Utilizador)
 *     -
 */

if (!function_exists("checkNivel")) {
    function checkNivel($iduser) {
        try {
            $related = GroupsRelated::where('id_user', $iduser)->first(); // Buscar relacionamento de Grupo e Usuário;
            $group = UsersGroups::where('id', $related->id_group_users)->first(); // Buscar permissões do usuário;
        } catch(Exception $e) {
            return -1;
        }

        // Todas as permissoes;
        if (str_contains($group->permissions, "*"))
        {
            return 0;
        }
        // Read And Updated
        elseif (str_contains($group->permissions, "read") && str_contains($group->permissions, "write") &&
            str_contains($group->permissions, "update") && str_contains($group->permissions, "create"))
        {
            return 1;
        }

        // Read and Write
        elseif (str_contains($group->permissions, "read") &&
            str_contains($group->permissions, "write"))
        {
            return 2;
        }

        else // Retorna para ser executada uma ação de logout, pois não há permissão válida.
        {
            return -1;
        }
    }
}
