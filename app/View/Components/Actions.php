<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Actions extends Component
{

    /**
     * Undocumented variable
     * Valor a receber: string
     * Ex: "admin.route.edit" => Valor de atribuição ao metodo route() do laravel.
     *
     * @var [string]
     */
    public $troute;

    /**
     * Undocumented variable
     * Valor a receber: string
     * Recebe uma classe css para o icone do component de action.
     *
     * @var [string]
     */
    public $ticonAndClass;

    /**
     * Receve um valor numérico inteiro, do id de identificação do item que está sendo acionado.
     *
     * @var [string]
     */
    public $iduser;

    /**
     * Valor a ser recebido: string
     * Recebe um text descrevendo qual metodo será atribuído a ação do component.
     *
     * @var [string]
     */
    public $methodText;

    /**
     * name de function
     *
     * @var [string]
     */
    public $fAction;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($troute, $ticonAndClass, $iduser, $methodText = null, $fAction = "")
    {
        $this->troute = $troute;
        $this->ticonAndClass = $ticonAndClass;
        $this->methodText = $methodText;
        $this->iduser = $iduser;
        $this->fAction = $fAction;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.actions');
    }
}
