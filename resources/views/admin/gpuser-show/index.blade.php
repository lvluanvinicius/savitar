@extends('adminlte::page')
@section('title', $title)

@section('content_header')
<h1>{{ $gpuser->gname }}</h1>
@stop

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.custom.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">

            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.users.group.update') }}" method="post">
                    @csrf
                    @method('PATCH')

                        <div class="p-2 row">
                            <input type="hidden" name="id_user_group" value="{{ $gpuser->id }}">

                            <div class="form-group col-md-12">
                                <label for="gname">Novo nome</label>
                                <input type="text" class="form-control" id="gname" name="gname" placeholder="gname" value="{{ old('gname') }}">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Ações</label>
                                <div class="row pl-5">

                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-create" name="permissions[]" value="create" >
                                        <label for="p-create">Create</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-update" name="permissions[]" value="update">
                                        <label for="p-update">Update</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-read" name="permissions[]" value="read" >
                                        <label for="p-read">Read</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-write" name="permissions[]" value="write" >
                                        <label for="p-write">Write</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-delete" name="permissions[]" value="delete">
                                        <label for="p-delete">Delete</label>
                                    </div>

                                </div>

                                <div class="h-divider-list-token"></div>
                                <label for="">Páginas</label>
                                <div class="row pl-5">
                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-dash" name="permissions[]" value="dash">
                                        <label for="p-dash">Dash</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-ulist" name="permissions[]" value="ulist">
                                        <label for="p-ulist">Usuários</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-ugroup" name="permissions[]" value="ugroup">
                                        <label for="p-ugroup">Grupos de Usuários</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" class="form-check-input"  id="p-keyaccess" name="permissions[]" value="keyaccess">
                                        <label for="p-keyaccess">Chaves de Acesso</label>
                                    </div>

                                </div>

                                <div class="h-divider-list-token"></div>
                                <div class="row pl-5">
                                    <div class="col-md-12">
                                        <input type="checkbox" class="form-check-input"  id="p-all" name="permissions[]" value="*">
                                        <label for="p-all">Todas as Permissões</label>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="confirm_alter_user_group" name="confirm_alter_user_group">
                                <label class="form-check-label" for="confirm_alter_user_group">Confirmar alterações</label>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Atualizar dados</button>
                        </div>
                </form>

            </div>
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
