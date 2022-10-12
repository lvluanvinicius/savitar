{{--
    // Use: <x-btn-actions-tables.blade ??/>
    * name: recebe o nome a ser inserido no valor do botão.
    * classIcon: recebe o nome da classe css a ser inserida para customização de aparência.
    * nameId: recebe o nome da ação a ser executada no click do botão.
    * nameModal: recebe o nome do modal a ser executado.
    --}}

<div>
    @if (!is_null($nameModal))
        <button class="btn-actions-tables" data-toggle="modal" data-target="{{ $nameModal }}">{{ $name }} <i class="{{ $classIcon }}"></i></button>
    @else
        <button class="btn-actions-tables" id="{{ $nameId }}">{{ $name }} <i class="{{ $classIcon }}"></i></button>
    @endif
</div>
