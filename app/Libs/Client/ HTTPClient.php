<?php

namespace App\Libs\Client;


use Illuminate\Support\Facades\Http;

class HTTPClient
{
    //
    protected $location;
    protected $apikey;

    public function __construct()
    {
        $this->location = env('API_ZABBIX_JSONRPC_ROUTE');
        $this->apikey = env('API_ZABBIX_KEY');
    }

    public function get_group_hosts()
    {
        $responseData = Http::accept('application/json')->post($this->location, [
            "jsonrpc" => env('API_ZABBIX_JSONRPC_VERSION'),
            "id" => 1001,
            "method" => "hostgroup.get",
            "auth" => $this->apikey,
            "params" => [
                "monitored_hosts" => true,
                "output" => [
                    "groupid",
                    "name",
                ]
            ]
        ]);

        return $responseData->json('result');
    }

    public function get_templates($groupids)
    {
        $responseData = Http::accept('application/json')->post($this->location, [
            "jsonrpc" => env('API_ZABBIX_JSONRPC_VERSION'),
            "id" => 1001,
            "method" => "template.get",
            "auth" => $this->apikey,
            "params" => [
                "output" => [
                    "host", "name", "templateid"
                ],
                "groupids" => $groupids
            ]
        ]);

        return $responseData->json('result');
    }

    public function get_hosts($template)
    {
        $responseData = Http::accept('application/json')->post($this->location, [
            "jsonrpc" => env('API_ZABBIX_JSONRPC_VERSION'),
            "id" => 1001,
            "method" => "host.get",
            "auth" => $this->apikey,
            "params" => [
                "output" => [
                    "hostid", "host", "name"
                ],
                "templateids" => $template
            ]
        ]);

        return $responseData->json('result');
    }
}
