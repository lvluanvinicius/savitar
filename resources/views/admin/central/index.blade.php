@extends('adminlte::page')
@section('title', $title)

@section("css")
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>
@stop

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Filtro para relatório</h3>
            </div>

            <div class="card-body">
            <form action="{{ route('admin.central.reports.general') }}" method="get">
            @csrf

                <div class="row">

                    <!-- Date and time range -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Data de início:</label>

                                    <input type="date" class="form-control" name="start_date" id="start-date" value="{{ is_null(old('start_date')) ? date('Y-m-d') : old('start_date') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Horário de início:</label>

                                    <input type="time" step="2" class="form-control" name="start_hours" id="start-hours" value="{{ is_null(old('start_hours')) ? '00:00:00' : old('start_hours') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Data final:</label>

                                    <input type="date" class="form-control" name="stop_date" id="stop-date" value="{{ is_null(old('stop_date')) ? date('Y-m-d') : old('stop_date') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Horário final:</label>

                                    <input type="time" step="2" class="form-control" name="stop_hours" id="stop-hours" value="{{ is_null(old('stop_hours')) ? '23:59:59' : old('stop_hours') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Date and time range -->

                    <div class="col-md-9">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Informe uma fila</label>
                                    <input class="form-control" id="central-queues-filter" placeholder="Ex: 900"/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Informe um agente</label>
                                    <input class="form-control" id="central-agents-filter" placeholder="Ex: 900"/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Informe uma fila</label>
                                    <input class="form-control" id="central-queues-filter" placeholder="Ex: 900"/>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group mt-3 float-right">
                            <div class="input-group">
                                <button class="btn btn-primary" id="load-data-filter">Buscar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@stop

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Relatório</h3>
            </div>
        </div>
    </div>
</div>


@stop


@section("js")
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#central-reports-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#central-reports-range').daterangepicker({
            showDropdowns: true,
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            minYear: 2000,
            ranges: {
                'Hoje': [moment(), moment()],
                'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                'Esse mês': [moment().startOf('month'), moment().endOf('month')],
                'Último mês': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                "customRangeLabel": "Customizar data",
            }
        }, cb);

        cb(start, end);

    });
</script>
@stop
