@extends('adminlte::page')
@section('title', $title)

@section('css')
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>
@stop


@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div  class="card">
                <!-- /.card-header -->
            <div class="card-body">
                <table id="dbm_average_table" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>Nome Equipamento</th>
                            <th>Pons</th>
                            <th>Data de Criação</th>
                            <th>Data de Atualização</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($olts as $olt)
                            <tr>
                                <td>{{ $olt->OLT_NAME }}</td>
                                <td>{{ $olt->PONS }}</td>
                                <td>{{ convetDateCreated($olt->updated_at) }}</td>
                                <td>{{ convetDateUpdated($olt->updated_at) }}</td>
                                <td>
                                    <div class="actions-buttons-group">
                                        <div>
                                            <x-actions troute="admin.collections.olt.config.update"
                                            ticonAndClass="fa fa-edit text-info" iduser="{{ $olt->id }}" />
                                        </div>
                                        {{--  <div>
                                            <x-actions troute="admin." ticonAndClass="fa fa-trash text-danger"
                                            methodText="DELETE" iduser="{{ $olt->id }}" />
                                        </div>  --}}
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
@endsection


@section('js')

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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

    <script>
        $(document).ready(function() {
            $('#dbm_average_table').DataTable({
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
            });
        } );
    </script>
@endsection