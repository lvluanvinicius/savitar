{{--
    // Use: <x-acrions ?? />
    * troure: recebe o nome da rota, onde a ação deve encaminhar o usuário ao acionar.
    * methodText: recebe o método ao qual deve ser atribuído para a requisição.
    * ticonAndClass: recebe a classe que define a cor e o icone do fontawesome.
    * iduser: recebe o id do usuário que foi selecionado para ser tratado.
    --}}


@if (!is_null($methodText))
    <form action="{{ route($troute, ['id' => $iduser]) }}" method="POST">
        @csrf
        @method($methodText)
        <div>
            <button type="submit" class="{{ $ticonAndClass }} btn-action-table" ></button>
        </div>
    </form>
@else
    <a href="{{ route($troute, ['id' => intval($iduser)]) }}" class="{{ $ticonAndClass }} btn-action-table" ></a>
@endif
