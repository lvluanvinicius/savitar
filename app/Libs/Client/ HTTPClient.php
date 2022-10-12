<?php

namespace App\Libs\Client;

use Exception;
use Illuminate\Support\Facades\Http;

class HTTPClient
{
    /**
     * Salva valor do link da Api do Zabbix.
     *
     * @var string
     */
    protected $zbxlocation;

    /**
     * Salva o valor da chave de acesso a Api do Zabbix.
     *
     * @var string
     */
    protected $zbxapikey;

    /**
     * Salva o valor da versão da Api do Zabbix.
     *
     * @var string
     */
    protected $zbxversionrpc;

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

    }

    /**
     * Controller Api Zabbix
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
    public function get_templates(Array $params)
    {
        return $this->zbx_http_accept("template.get", $params=$params);
    }

    /**
     * Carregamento de hosts
     *
     * @param Array $params
     * @return string
     */
    public function get_hosts($params)
    {
        return $this->zbx_http_accept("host.get", $params=$params);
    }

    /**
     * Carregamento de gráficos
     *
     * @param Array $params
     * @return string
     */
    public function get_graphics(Array $params)
    {
        return $this->zbx_http_accept("graph.get", $params=$params);
    }

    /**
     * Carregamento de Items
     *
     * @param Array $params
     * @return void
     */
    public function get_items(Array $params)
    {
        return $this->zbx_http_accept("item.get", $params=$params);
    }

    /**
     * Carregamento de gráficos
     *
     * @param Array $params
     * @return string
     */
    public function get_history(Array $params)
    {
        return $this->zbx_http_accept("history.get", $params=$params);
    }

}
