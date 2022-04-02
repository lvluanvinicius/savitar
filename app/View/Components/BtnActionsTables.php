<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BtnActionsTables extends Component
{
    /**
     * Recebe o nome do botão a ser inserido no valor.
     *
     * @var [string]
     */
    public $name;

    /**
     * recebe uma classe css para botão.
     *
     * @var [string]
     */
    public $classIcon;


    /**
     * Recebe o nome da ação a ser executada.
     *
     * @var [string]
     */
    public $nameId;


    /**
     * Recebe um valor com nome do modal a ser executado caso haja ação de modal.
     *
     * @var [string]
     */
    public $nameModal;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $nameId="", $classIcon, $nameModal = null)
    {
        $this->nameModal = $nameModal;
        $this->name = $name;
        $this->nameId = $nameId;
        $this->classIcon = $classIcon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.btn-actions-tables');
    }
}
