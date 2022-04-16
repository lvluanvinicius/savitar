<?php

use App\Libs\Client\HTTPClient;


if (!function_exists("getGroupHosts")) {
    function getGroupHosts()
    {
        $httpClient = new HTTPClient;

        return $httpClient->get_group_hosts();
    }
}
