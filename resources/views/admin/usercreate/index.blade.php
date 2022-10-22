@extends('admin.master')


@section('content')
<x-page-header title="{{ $subtitle }}" />

<form action="{{ route('admin.users.store') }}" method="post">
    <div id="create-user-content">
              

        <div class="form-content">
            @csrf

            <div class="row-form-users">
                <div class="group-input">
                    <label for="uname">Nome:</label>
                    <input type="text" name="uname" id="uname" value="" placeholder="Nome e sobrenome"/>
                </div>
    
                <div class="group-input">
                    <label for="uusername">Usuário:</label>
                    <input type="text" name="uusername" id="uusername" value="" placeholder="Usuário de login"/>
                </div>
            </div>

            <div class="row-form-users">
                <div class="group-input">
                    <label for="upassword">Senha:</label>
                    <input type="password" name="upassword" id="upassword" value="" placeholder="Senha de acesso"/>
                </div>
    
                <div class="group-input">
                    <label for="uusername">Usuário:</label>
                    <input type="text" name="uusername" id="uusername" value="" />
                </div>
            </div>

            <div class="group-input">
                <button type="submit" class="" name="saveuser" value="Save User">Salvar</button>
            </div>
            
        </div>        


        <div class="photo-area">
            <div>Teste de foto</div>
        </div>

        
    </div>
</form> 
@endsection