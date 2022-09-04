@extends('adminlte::page')
@section('title', $title)

@section("css")
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
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
                <div id="content-graphics">
                </div>
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

    {{-- ChatJS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>


    <script>

        const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];

        const data = {
            labels: labels,
            datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, 30, 45],
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        for (let index = 0; index < 10; index++) {
            $("#content-graphics").append(`
                <canvas id="chart-reports-${index}"></canvas>
            `);
            const myChart = new Chart(
                document.getElementById(`chart-reports-${index}`),
                config
            );
        }


    </script>
@stop
