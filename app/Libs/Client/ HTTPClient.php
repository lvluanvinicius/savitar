<?php

namespace App\Libs\Client;

use Exception;
use Illuminate\Support\Facades\Http;

class HTTPClient
{
    //
    protected $location;
    protected $apikey;

    /**
     * Iniciando valores globais.
     */
    public function __construct()
    {
        /**
         * Pertencente ao Zabbix Type
         */
        $this->zbxlocation = env('API_ZABBIX_JSONRPC_ROUTE');
        $this->zbxapikey = env('API_ZABBIX_KEY');
        $this->zbxversionrpc = env('API_ZABBIX_JSONRPC_VERSION');


        /**
         * Pertencente a Central King Voice
         */
        $this->ctllocation = env("CTL_ROUTE_LOCATION");
    }

    /**
     * Undocumented function
     *
     * @param String $method
     * @param Array $params
     * @return string
     */
    private function zbx_http_accept(String $method, Array $params)
    {
        try {
            $responseData = Http::accept('application/json')->post($this->zbxlocation, [
                "jsonrpc" => $this->zbxversionrpc,
                "id" => 1001,
                "method" => $method,
                "auth" => $this->zbxapikey,
                "params" => $params
            ]);

            return $responseData->json('result');
        } catch (Exception $err) {
            dd($err);
        }
    }

    /**
     * Carregamento de grupo de hosts.
     *
     * @return string
     */
    public function get_group_hosts()
    {
        return $this->zbx_http_accept("hostgroup.get", [
            "monitored_hosts" => true,
            "output" => [
                "groupid",
                "name",
            ]
        ]);

    }

    /**
     * Carregamento de templates
     *
     * @param string $groupids
     * @return string
     */
    public function get_templates($groupids)
    {
        return $this->zbx_http_accept("template.get", [
            "output" => [
                "host", "name", "templateid"
            ],
            "groupids" => $groupids
        ]);
    }

    /**
     * Carregamento de hosts
     *
     * @param string $template
     * @return string
     */
    public function get_hosts($template)
    {
        return $this->zbx_http_accept("host.get", [
            "output" => [
                "hostid", "host", "name"
            ],
            "templateids" => $template
        ]);
    }


    private function ctl_http_accept(String $route, Array $params)
    {
        try {
            return Http::withoutVerifying()
            ->withHeaders([
                "token" => "8b0cf17e4429a7ee9d47c278c2ef6ce9",
                "Content-Type" => "application/json"
            ])
            ->get($this->ctllocation . $route, $params)
            ->json();

        } catch (Exception $err) {
            dd($err);
        }
    }

    public function get_central_reports_attended($params)
    {
        return $this->ctl_http_accept("/estatistica_detalhada/relatorio", $params);
    }
}
