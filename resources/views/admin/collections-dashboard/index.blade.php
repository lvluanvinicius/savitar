@extends('adminlte::page')
@section('title', $title)


@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        $idEq=$_GET["id"];

        (!isset($_GET["start_filter"])) ? $startDate = date('Y-m-d', strtotime(date('Y-m-d').' - 3 days')) : $startDate=$_GET['start_filter'];
        (!isset($_GET["end_filter"])) ? $endDate = date('Y-m-d') : $endDate=$_GET['end_filter'];

        $graphConfigs = getGraphOltsConfig($idEq);


    @endphp
    @foreach ($graphConfigs as $conf)
        @php
        $separator=str_replace("/", "", str_replace(" ", "", $conf->PORT));
        $nameGraph=$conf->NAME_GRAPH;
        echo "<canvas id='chart_" . $separator . "' width='400' height='100'></canvas>";

        $datas = getAveragesDBMOnGpon(
            $idOlt=$conf->ID_OLT_GRAPH,
            $gpon=$conf->PORT,
            $dateStart=$startDate,
            $dateEnd=$endDate
        );

        @endphp

        <script>
            //
            const ctx_{{ $separator }} = document.getElementById('chart_{{ $separator }}').getContext('2d');

            // Formatando data de Timestamp to Date String.
            newDataLabels{{ $separator }}=[];
            {{ json_encode($datas[1]) }}.forEach(times => {
                var date = new Date(times*1000);
                newDataLabels{{ $separator }}.push(date.toLocaleDateString())
            });

            const chat{{ $separator }} = new Chart(ctx_{{ $separator }}, {
                type: 'line',
                data: {
                    labels: newDataLabels{{ $separator }},
                    datasets: [{
                        label: "{{ $nameGraph }}",
                        data: {{ json_encode($datas[0]) }},
                        borderWidth: 2,
                        borderColor: ['green'],
                        backgroundColor: ['green']
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: "{{ $nameGraph }}",
                            position: "top",
                            font: {
                                weight: "bold",
                                size: 20
                            },
                        }
                    }
                }
            });
        </script>

    @endforeach

    <div class="pb-3">
        <hr>
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

@endsection
