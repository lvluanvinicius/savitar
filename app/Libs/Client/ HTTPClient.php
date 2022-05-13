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
     * Salva o link de acesso a Api da Central King Voice.
     *
     * @var string
     */
    protected $ctllocation;

    /**
     * Salva o link de acesso a Api do Opsgenie.
     *
     * @var string
     */
    protected $opglocation;

    /**
     * Salva o valor da chave de acesso a Opsgenie.
     *
     * @var string
     */
    protected $opgkey;

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

        /**
         * Pertencente ao Opsgenie
         */
        $this->opglocation = env("OPG_LOCATION");
        $this->opgkey = env("OPG_KEY");
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


    /**
     * Api controller Central King Voice.
     *
     * @param String $route
     * @param Array $params
     * @return string
     */
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

    /**
     * Carregamento de estatisticas detalhadas.
     *
     * @param Array $params
     * @return void
     */
    public function get_central_reports_attended(Array $params)
    {
        return $this->ctl_http_accept("/estatistica_detalhada/relatorio", $params);
    }

    /**
     * Carregamento de estatisticas da fila.
     *
     * @param Array $params
     * @return string
     */
    public function get_central_report_queue_statistics(Array $params)
    {
        return $this->ctl_http_accept("/estatistica_fila/relatorio", $params);
    }

    private function opg_http_accept(string $route, Array $params)
    {
        try {
            return Http::withoutVerifying()
            ->withHeaders([
                "Authorization" => "GenieKey $this->opgkey",
                "Content-Type" => "application/json"
            ])->get($this->opglocation . $route, $params)
            ->json();
        } catch (Exception $err) {
            dd($err);
        }
    }

    //
    public function get_reports_alerts(Array $params)
    {
        // dd($this->opg_http_accept("/alerts", $params));
        return $this->opg_http_accept("/alerts", $params);
    }
}
