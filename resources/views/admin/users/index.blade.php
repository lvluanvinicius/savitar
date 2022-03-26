@extends('adminlte::page')
@section('title', $title)


@section('css')
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>
@stop

@section('content_header')
    <div class="row">
        <div class="col-md-12">

            <div class="row">

                <div class="col-md-9">
                    <h1>{{ $subtitle }}</h1>
                </div>

                <div class="col-md-3">
                    <div class="btn-actions-table-group">
                        <x-btn-actions-tables classIcon="fa fa-user-plus" name="Novo"  nameModal="#modal-new-user" nameId/>
                    </div>
                </div>

            </div>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div  class="card">
                    <!-- /.card-header -->
                <div class="card-body">
                    <table id="users_table" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                    <div class="actions-buttons-group">
                                        <div>
                                            <x-actions troute="admin.list.onde.user" ticonAndClass="fa fa-edit text-info" iduser="{{ $user->id }}" />
                                        </div>
                                        <div>
                                            <x-actions troute="admin.user.delete" ticonAndClass="fa fa-trash text-danger" methodText="DELETE" iduser="{{ $user->id }}" />
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                    <!-- /.card-body -->
            </div>
        <!-- /.card -->
        </div>
    </div>


    <div class="modal fade" id="modal-new-user">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Novo usuário</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="{{ route('admin.new.user') }}" method="post">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="p-2 row">

                        <div class="form-group col-md-12">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nome e sobre nome" value="{{ old('name') }}">
                        </div>

                        <div class="form-group col-md-7">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
                        </div>

                        {{-- <div class="form-group col-md-4">
                            <label for="level">Permissão de</label>
                            <select type="level" class="form-control" id="level" name="level" value="{{ old('level') }}">
                                <option value="0">Administrador</option>
                                <option value="1">Utilizador</option>
                            </select>
                        </div> --}}

                        <div class="form-group col-md-5">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{ old('password') }}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Permissões</label>
                            <div class="row pl-5">

                                <div class="col-md-2">
                                    <input type="checkbox" class="form-check-input"  id="p-create" name="permissions[]" value="create" checked>
                                    <label for="p-create">Create</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="checkbox" class="form-check-input"  id="p-update" name="permissions[]" value="update">
                                    <label for="p-update">Update</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="checkbox" class="form-check-input"  id="p-write" name="permissions[]" value="write" checked>
                                    <label for="p-write">Write</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="checkbox" class="form-check-input"  id="p-delete" name="permissions[]" value="delete">
                                    <label for="p-delete">Delete</label>
                                </div>

                                <div class="col-md-4">
                                    <input type="checkbox" class="form-check-input"  id="p-all" name="permissions[]" value="*">
                                    <label for="p-all">Todas as permissões</label>
                                </div>

                            </div>
                        </div>

                        <div class="form-check col-md-12">
                            <input type="checkbox" class="form-check-input" id="confirm_add_user" name="confirm_add_user">
                            <label class="form-check-label" for="confirm_add_user">Confirmar</label>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="save-new-user">Salvar</button>
                    </div>
                </div>
            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
@stop


@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#users_table').DataTable({
                "processing": true,
                "language": {
                    "lengthMenu":           "Mostrar _MENU_ registros por página",
                    "search":                   "Buscar",
                    "zeroRecords":          "Nenhum usuário localizado.",
                    "info":                        "Página _PAGE_ de _PAGES_",
                    "paginate": {
                        "previous":             "Anterior",
                        "next":                     "Próximo",
                        "first":                     "Primeiro",
                        "last":                      "Último"
                    }
                },
                "pageLength": 6
            });
        } );
    </script>


    {{-- Feedback ao usuário sobre a ação executada.  --}}
    @if (session('message') && session('status') )
        <script>
            let status = "{{ session('status') }}"; // Recupera o status.

            // Caso o status seja de sucesso, será exibido uma mensagem do tipo Success.
            if (status === "Success") {

                toastr.success('{{ session("message") }}')
            }
            // Retornar uma mensagem de aviso caso o tipo seja warning.
            else if (status === "Warning") {

                toastr.warning('{{ session("message") }}')
            }
            // Retornar uma mensagem de erro caso o tipo seja Error.
            else {

                toastr.error('{{ session("message") }}')
            }
        </script>
    @endif
@stop
