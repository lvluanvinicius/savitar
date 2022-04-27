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

    <style>
        .custom-layout {
            overflow: hidden;
        }
    </style>
@stop


@section('content')

<div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Gráficos</h3>
        </div>
                <!-- /.card-header -->
        <div class="card-body">
            <div class="row">

                <div class="col-md-3 row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_group_hosts_multiple">
                                Selecione um grupo de host
                            </label>
                            <select class="js-states form-control" id="id_group_hosts_multiple">
                                @for ($index = 0; $index < count(getGroupHosts()); $index++)
                                    <option value="{{ getGroupHosts()[$index]['groupid'] }}">
                                        {{ getGroupHosts()[$index]['name'] }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-outline-secondary float-right w-100" id="load_templates">Carregar templates</button>
                        </div>
                    </div>

                </div>

                <div class="col-md-3 row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_templates_multiple">
                                Selecione os templates
                            </label>
                            <select class="js-states form-control" id="id_templates_multiple">
                            </select>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-outline-secondary float-right w-100" id="load_hosts">Carregar hosts</button>
                        </div>
                    </div>

                </div>


                <div class="col-md-3 row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_hosts_multiple">Selecione um host</label>

                            <select class="js-states form-control" id="id_hosts_multiple">
                            </select>

                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-outline-secondary float-right w-100" id="load_graphcs">Carregar Gráficos</button>
                        </div>
                    </div>

                </div>

                <div class="col-md-3 row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_hosts_multiple">Selecione os gráficos</label>

                            <select class="js-states form-control" id="id_hosts_multiple">
                            </select>

                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-outline-secondary float-right w-100" id="load_graphcs">Gerar Gráficos</button>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>
        <!-- /.card -->

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Relatório de gráficos</h3>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-12">
                    //
                </div>
            </div>
        </div>
    </div>
</div>

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
            multiple: true,
            width: 'resolve'
        });

        $("#load_templates").click(function (event) {
            const groupids = $("#id_group_hosts_multiple").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.graphcs.load.templates') }}",
                headers : {
                    'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr("content")
                },
                data: {
                    groupids
                },
                success: function (response) {
                    try {
                        $("#id_templates_multiple").empty();
                        for (let ind = 0; ind < response.length; ind++ ) {
                            $("#id_templates_multiple").append(
                                    `<option value="${response[ind].templateid}">${response[ind].name}</option>`);
                        }
                    } catch (error) {
                        console.log('====================================');
                        console.log(error);
                        console.log('====================================');
                    }
                }
            });
        });

        $("#id_templates_multiple").select2({
            theme: "classic",
            multiple: true,
            width: 'resolve'
        });

        // templateids

        $("#load_hosts").click(function (event) {
            const templateids = $("#id_templates_multiple").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.graphcs.load.hosts') }}",
                headers : {
                    'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr("content")
                },
                data: {
                    templateids
                },
                success: function (response) {
                    try {
                        console.log(response);
                        $("#id_hosts_multiple").empty();
                        for (let ind = 0; ind < response.length; ind++ ) {
                            $("#id_hosts_multiple").append(
                                    `<option value="${response[ind].hostid}">${response[ind].name}</option>`);
                        }
                    } catch (error) {
                        console.log('====================================');
                        console.log(error);
                        console.log('====================================');
                    }
                }
            });
        });

        $("#id_hosts_multiple").select2({
            theme: "classic",
            multiple: true,
            width: 'resolve'
        });

        $("#load_graphcs").click(function (event) {
            const hostsid = $("#id_hosts_multiple").val();
            console.log(hostsid);

        });

        //

    </script>


@endsection
