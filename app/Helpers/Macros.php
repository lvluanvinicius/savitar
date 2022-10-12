<?php

if (!function_exists("getVariableGlobal")) {
    function getVariableGlobal($type, $name) {
        if ($type == "user"){
            return "USER";
        }

        if ($type == "global"){
            return "GLOBAL";
        }
    }
}
