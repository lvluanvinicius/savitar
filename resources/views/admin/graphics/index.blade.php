@extends('adminlte::page')
@section('title', $title)

@section('content_header')
    <h1>{{ $subtitle }}</h1>
@stop

@section('css')
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>

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
            <h3 class="card-title">Buscar por Gráficos</h3>
        </div>
                <!-- /.card-header -->
        <div class="card-body">
            <div class="row p-3" >

                <div class="col-md-6" >
                    <div class="row">

                        <div class="col-md-12">                            
                            <div class="form-group">
                                <label for="id_group_hosts_multiple" class="form-label">Selecione os Grupos</label>
                                <select class="js-states form-control selectpicker" id="id_group_hosts_multiple" multiple>
                                    @for ($index = 0; $index < count(getGroupHosts()); $index++)
                                        <option value="{{ getGroupHosts()[$index]['groupid'] }}">
                                            {{ getGroupHosts()[$index]['name'] }}
                                        </option>
                                    @endfor                                 
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-outline-secondary float-right w-100 zbx-btn-loads" id="load_templates">Carregar templates</button>
                            </div>
                        </div> --}}

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="id_hosts_multiple" class="form-label">Selecione os Hosts</label>
                                <select class="js-states form-control selectpicker" id="id_hosts_multiple" multiple>
                                </select>

                            </div>

                        </div>

                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-outline-secondary float-right w-100" id="load_graphcs">Carregar Gráficos</button>
                            </div>
                        </div> --}}

                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="id_graphics_multiple">Selecione os Gráficos</label>
                                <select class="js-states form-control selectpicker" id="id_graphics_multiple" multiple>
                                </select>
    
                            </div>    
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="datarange_for_history" class="form-label">Selecione um intervalo</label>
                                <input class="form-control" type="text" name="datetimes" id="datarange_for_history"/>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-outline-secondary float-right w-100" id="load_reports">Gerar Gráficos</button>
                            </div>
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
            <div class="row" id="reports_graphics">

                <div class="col-md-12">
                    <div id="chart_div"></div>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>


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

        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
                // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
            ['Mushrooms', 3],
            ['Onions', 1],
            ['Olives', 1],
            ['Zucchini', 1],
            ['Pepperoni', 2]
            ]);

            // Set chart options
            var options = {'title':'How Much Pizza I Ate Last Night',
                        'width':400,
                        'height':300};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        $("#id_group_hosts_multiple").select2({
            theme: "classic",
            title: "teste"
        });

        $("#id_group_hosts_multiple").change(function (event) {
            const groupids = $("#id_group_hosts_multiple").val();      

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.graphcs.load.hosts') }}",
                headers : {
                    'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr("content")
                },
                data: {
                    groupids
                },
                success: function (response) {
                    try {
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
                },
                error: function (error) {
                    alert("Por favor, selecione um Grupo.");
                }
            });
        });


        $("#id_hosts_multiple").select2({
            theme: "classic"
        });

        $("#id_hosts_multiple").change(function (event) {
            const hostids = $("#id_hosts_multiple").val(); 
            
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.graphcs.load.graphics') }}",
                headers : {
                    'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr("content")
                },
                data: {
                    hostids
                },
                success: function (response) {
                    try {
                        $("#id_graphics_multiple").empty();
                        
                        for (let ind = 0; ind < response.length; ind++ ) {
                            $("#id_graphics_multiple").append(
                                    `<option value="${response[ind].graphid}">${response[ind].name}</option>`);
                        }
                    } catch (error) {
                        console.log('====================================');
                        console.log(error);
                        console.log('====================================');
                    }
                },
                error: function (error) {
                    alert("Por favor, selecione um Host.");
                }
            });

        });

        //
        $("#datarange_for_history").daterangepicker({
            timePicker: true,            
            locale: {
                format: 'YYYY-MM-DD HH:MM:SS'
            }
        });

        //
        $("#id_graphics_multiple").select2({
            theme: "classic"
        });
        

        $("#load_reports").click(function (event) {
            const graphicsid = $("#id_graphics_multiple").val();
            const [time_from,time_till] = $("#datarange_for_history").val().split(" - "); //datarangeForHistory
            const groupids = $("#id_group_hosts_multiple").val();
            const templateids = $("#id_templates_multiple").val();
            const hostids = $("#id_hosts_multiple").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.graphcs.load.graphics.generate') }}",
                headers : {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
                },
                data: {
                    groupids, templateids, hostids, graphicsid, time_from, time_till
                },
                success: function (response) {
                    try {
                        console.log('====================================');
                        console.log(response);
                        console.log('====================================');
                        
                    } catch (error) {
                        console.log('====================================');
                        console.log(error);
                        console.log('====================================');
                    }
                },
                error: function (error) {
                    alert("Por favor, selecione um gráfico.");
                }
            });
        });
        

    </script>


@endsection
