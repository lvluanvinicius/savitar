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
    function checkNivel($iduser, $permission) {
        try {
            $related = GroupsRelated::where('id_user', $iduser)->first(); // Buscar relacionamento de Grupo e Usuário;
            $group = UsersGroups::where('id', $related->id_group_users)->first(); // Buscar permissões do usuário;

            if (str_contains($group->permissions, $permission)) {
                return true;
            }

            return false;

        } catch(Exception $e) {
            dd("Houve um erro ao tentar ler as permissões desse usuário.");
        }
    }
}
