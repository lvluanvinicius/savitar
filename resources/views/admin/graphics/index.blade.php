@extends('adminlte::page')
@section('title', $title)

@section('content_header')
    <h1>{{ $subtitle }}</h1>
@stop

@section('css')
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Gráficos</h3>
        </div>
            <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="id_group_hosts_multiple">
                            Selecione um grupo de host
                        </label>
                        <select class="js-states form-control" id="id_group_hosts_multiple" multiple="multiple"></select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->

@endsection


@section('js')

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
        $("#id_group_hosts_multiple").select2({
            theme: "classic",
            multiple: true
        });

    </script>


@endsection
