@extends('adminlte::page')
@section('title', $title)

@section('content_header')
    <h1>{{ $user->name }}</h1>
@stop

@section('css')
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.custom.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-secondary">

            <div class="card-header">
                <h3 class="card-title">Configuração</h3>
            </div>

            <form action="{{ route('app.profile.edit') }}" method="post">
                @csrf
                @method("PUT")
                <div class="card-body">

                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome completo" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{ old('password') }}">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="confirm_alter_user" name="confirm_alter_user">
                        <label class="form-check-label" for="confirm_alter_user">Confirmar alterações</label>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Atualizar dados</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="col-md-5">
        <div class="card card-secondary">

            @if (!is_null($mykey))

                <div class="card-header">
                    <h3 class="card-title">Minha chave de acesso</h3>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <span><strong>Nome: </strong></span> {{ $mykey->name }}
                        </div>

                        <div class="h-divider-list-token"></div>

                        <div class="col-md-12">
                            <span><strong>Token:</strong> </span> {{ $mykey->token }}
                        </div>

                        <div class="h-divider-list-token"></div>

                        <div class="col-md-12">
                            <span><strong>Criado:</strong> </span> {{ convetDateCreated($mykey->created_at) }}
                        </div>

                        <div class="h-divider-list-token"></div>

                        <div class="col-md-12">
                            <span><strong>Ultilizado:</strong> </span> {{ convetDate($mykey->last_used_at) }}
                        </div>

                        @if (session("data"))

                            <div class="h-divider-list-token" style="cursor: pointer"></div>

                            <div class="col-md-12" id="copy-key">
                                <span><strong>Token:</strong> </span>
                                <small id="text-token">{{ session("data")["new_token"] }}</small>
                            </div>

                        @endif

                    </div>

                    <div class="h-divider-list-token"></div>

                    <form action="{{ route('app.relogin.api') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Atualizar chave</button>
                        </div>
                    </form>
                </div>

            @else

                <div class="card-body">
                    <strong class="text-info">Nenhuma chave localizada em seu nome.</strong>
                    <form action="{{ route('app.relogin.api') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-footer text-right">
                            <button type="submit" class="btn-generated-key-profile">Gerar chave de acesso.</button>
                        </div>
                    </form>
                </div>

            @endif

        </div>
    </div>
</div>
@stop


@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('assets/admin/js/admin.custom.js') }}"></script>

    {{-- Feedback ao usuário sobre a ação executada.  --}}
    @if (session('message') && session('status') )
        <script>
            let status = "{{ session('status') }}"; // Recupera o status.

            // Caso o status seja de sucesso, será exibido uma mensagem do tipo Success.
            if (status === "Success") {

                toastr.success('{{ session("message") }}')
            }

            // Retornar mensagem de informação.
            else if (status === "Info") {
                toastr.info('{{ session("message") }}')
            }

            // Retornar mensagem de Error.
            else if (status === "Error") {
                toastr.error('{{ session("message") }}')
            }

            // Retornar uma mensagem de erro caso o tipo seja Error.
            else {
                toastr.warning('{{ session("message") }}')
            }
        </script>
    @endif
@stop
