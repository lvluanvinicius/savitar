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

{{-- @section('content_header')
<div>
    <h3>{{ $subtitle }}</h3>
</div>
@stop --}}

@section('content')
<div class="row pt-5">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>

            <div class="card-body">
                //
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
