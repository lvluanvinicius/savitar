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

            <form action="" method="get">
                <div class="row">
                    <input type="hidden" name="id" value="{{ $_GET['id'] }}">

                    <div class="col-md-9 row">
                        <div class="form-group col-4">
                            <input type="date" class="form-control" name="start_filter"pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required/>
                        </div>
                        <div class="form-group col-4">
                            <input type="date" class="form-control" name="end_filter" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required/>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-secondary float-right w-100">Buscar por data</button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection

@section('content')
@php
    $startDate="";
    $endDate="";
    $charts = new App\Charts\GponsCharts;
    (!isset($_GET["start_filter"])) ? $startDate = date('Y-m-d') . " 00:00:00" : $startDate=$_GET['start_filter'] . " 00:00:00";
    (!isset($_GET["end_filter"])) ? $endDate = date('Y-m-d') . " 23:59:59" : $endDate=$_GET['end_filter'] . " 23:59:59";

    foreach (getGponsConfig($idOlt=$_GET["id"]) as $pons) {
        $datas = getAveragesDBMOnGpon($idOlt=$_GET["id"], $gpon=$pons->PORT, $dateStart=$startDate, $dateEnd=$endDate);
        $charts->labels(["Media de DBM", "Data"]);
        $charts->dataset("Teste", "Line", [$datas["DBM_AVERAGE"], $datas["DATE"]]);
    }

@endphp

{!! $charts->script() !!}

@endsection



@section('js')

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

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

@endsection
