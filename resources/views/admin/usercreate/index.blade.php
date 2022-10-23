@extends('admin.master')

@section('head')
@endsection


@section('content')
<x-page-header title="{{ $subtitle }}" />

<form action="{{ route('admin.users.store') }}" method="post">
    <div id="create-user-content">
              

        <div class="form-content">
            @csrf

            <div class="row-form-users">
                <div class="group-input">
                    <label for="uname">Nome:</label>
                    <input type="text" name="uname" id="uname" value="{{ old('uname') }}" placeholder="Nome e sobrenome" required/>
                </div>
    
                <div class="group-input">
                    <label for="uusername">Usuário:</label>
                    <input type="text" name="uusername" id="uusername" value="{{ old('uusername') }}" placeholder="Usuário de login" required/>
                </div>
            </div>

            <div class="row-form-users">
                <div class="group-input">
                    <label for="upassword">Senha:</label>
                    <input type="password" name="upassword" id="upassword" placeholder="Senha" required/>
                </div>
    
                <div class="group-input">
                    <label for="upermission">Grupo:</label>
                    <select name="permission" required>
                        <option>Selecione um grupo</option>
                        @foreach ($groups as $gpusr)
                            <option value="{{ $gpusr->id }}">{{ $gpusr->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="group-input btn-send">
                <button type="submit" class="" name="saveuser" value="Save User">Salvar</button>
            </div>
            
        </div>        


        <div id="photo-area">
            <div class="card-photo">
                <img id="img_for_profile_user">
            </div>
            <div class="card-input-file">
                <label for="url_photo_profile">Escolha uma foto</label>
                <input type="file" name="url_photo_profile" id="url_photo_profile" onchange="loadFileImgProfile(event)"/>
            </div>
        </div>

        
    </div>
</form> 
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var loadFileImgProfile = function (event) {
        var output = document.getElementById('img_for_profile_user');
        
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src)
        }
    };
</script>
@endsection