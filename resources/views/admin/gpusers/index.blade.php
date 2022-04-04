@extends('adminlte::page')
@section('title', $title)
@section('content_header')
    <div class="row">
        <div class="col-md-12">

            <div class="row">

                <div class="col-md-9">
                    <h1>{{ $subtitle }}</h1>
                </div>

                <div class="col-md-3">
                    <div class="btn-actions-table-group">
                        <x-btn-actions-tables classIcon="fa fa-plus" name="Novo Grupo"  nameModal="#modal-new-gpuser" nameId/>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <div class="modal fade" id="modal-new-gpuser">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Novo usuário</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="{{ route('admin.users.group.create') }}" method="post">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="p-2 row">

                        <div class="form-group col-md-12">
                            <label for="gname">Nome</label>
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

                                    <div class="col-md-3">
                                        <input type="checkbox" class="form-check-input"  id="p-ugroup" name="permissions[]" value="ugroup">
                                        <label for="p-ugroup">Grupos de Usuários</label>
                                    </div>

                                    <div class="col-md-3">
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

                        

                        <div class="form-check col-md-12">
                            <input type="checkbox" class="form-check-input" id="confirm_add_gpuser" name="confirm_add_gpuser">
                            <label class="form-check-label" for="confirm_add_gpuser">Confirmar</label>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="save-new-gpuser">Salvar</button>
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

@section('css')
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div  class="card">
                    <!-- /.card-header -->
                <div class="card-body">
                    <table id="gpusers_table" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Permissões</th>
                                <th>Data de Criação</th>
                                <th>Data de Atualização</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($gpusers as $gpuser)
                                <tr>
                                    <td>{{ $gpuser->gname }}</td>
                                    <td>{{ $gpuser->permissions }}</td>
                                    <td>{{ convetDateString($gpuser->created_at) }}</td>
                                    <td>{{ convetDateString($gpuser->updated_at) }}</td>
                                    <td>
                                        <div class="actions-buttons-group">

                                                <div class="">
                                                    <x-actions  troute="admin.users.group.store" ticonAndClass="fa fa-edit text-info" iduser="{{ $gpuser->id }}" />
                                            </div>

                                                <div class="ml-1">
                                                        <x-actions  troute="admin.users.group.delete" ticonAndClass="fa fa-trash text-danger" methodText="DELETE" iduser="{{ $gpuser->id }}" />
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
@stop



@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#gpusers_table').DataTable({
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
            // Retornar uma mensagem de erro caso o tipo seja Error.
            else {
                toastr.error('{{ session("message") }}')
            }
        </script>
    @endif
@stop
