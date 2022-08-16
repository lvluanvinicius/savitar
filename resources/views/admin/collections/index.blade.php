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
                    {{--  {{ $imports_tasks }}  --}}
                    <x-btn-actions-tables classIcon="fa fa-tasks" name="Arquivos pendentes" nameModal="#modal-list-imports-tasks" nameId/>

                </div>

                <div class="col-md-3">
                    <div class="btn-actions-table-group">
                        <x-btn-actions-tables classIcon="fa fa-upload" name="Novo exports "  nameModal="#modal-new-collection" nameId/>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="modal-list-imports-tasks">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Execuções pendentes</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

            </div>

            <div class="">
                <div  class="card">
                    <!-- /.card-header -->
                <div class="card-body">
                    <table id="" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Nome do Arquivo</th>
                                <th>Path</th>
                                <th>Criado</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($imports_tasks as $ITasks)
                                <tr>
                                    <td>{{ $ITasks->name_file }}</td>
                                    <td>{{ $ITasks->path }}</td>
                                    <td>{{ convetDateCreated($ITasks->created_at) }}</td>
                                    <td>
                                        <div class="actions-buttons-group">
                                            <div>
                                                <i class="fa fa-play-circle text-primary" style="cursor: pointer"
                                                    onclick="executeImportTasks({{ $ITasks->id }})"></i>
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
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal import tasks -->


    <div class="modal fade" id="modal-new-collection">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Carregar Export</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="{{ route('admin.collections.dbms.pons.upload.export') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="form-group">
                        <input type="file" name="data_file"/>
                    </div>

                    <div class="form-group">
                        <button type="submit">Salvar</button>
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
                            <th>GPon</th>
                            <th>Média de DBM</th>
                            <th>Data de Coleta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dbm_collections as $collec)
                            <tr>
                                <td>{{ $collec->OLT_NAME }}</td>
                                <td>{{ $collec->PON }}</td>
                                <td>{{ $collec->DBM_AVERAGE }}</td>
                                <td>{{ convetDateString($collec->created_at) }}</td>
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

@if (count($imports_tasks) >= 1)
    <div class="alert alert-primary" role="alert">
        Existe taréfas pendentes, por favor, verifique e as execute!
    </div>
@endif
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

    <script>
        totTasks = "{{ count($imports_tasks) }}";

        if (totTasks >= 1)
        {
            toastr.info(`Existem ${totTasks} pendentes!`);
        }

        function executeImportTasks(idITask)
        {
            toastr.warning(`Ação enviada para execução, por favor, aguarde e atualize a página.`);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: "{{ route('admin.collections.dbms.pons.import.execute') }}",
                data: {idITask},
                success: function (response) {
                    toastr.success(response)
                },
                error: function (response) {
                    toastr.success(response)
                }
            });
        }
    </script>
@endsection
