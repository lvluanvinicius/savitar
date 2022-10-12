@extends('adminlte::page')
@section('title', $title)


@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.custom.css') }}">
@endsection

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
                            <th>Valor</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($variables as $vars)
                            <tr>
                                <td>{{ $vars->name }}</td>

                                @if ($vars->type_var == "password")
                                    <td>******</td>
                                @elseif ($vars->type_var == "text")
                                    <td>{{ $vars->values }}</td>
                                @endif

                                <td>
                                {{-- <div class="actions-buttons-group">
                                    <div>
                                        <x-actions troute="admin.list.onde.user" ticonAndClass="fa fa-edit text-info" iduser="{{ $vars->id }}" />
                                    </div>
                                    <div>
                                        <x-actions troute="admin.user.delete" ticonAndClass="fa fa-trash text-danger" methodText="DELETE" iduser="{{ $vars->id }}" />
                                    </div>
                                </div> --}}
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

@endsection


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
@endsection
