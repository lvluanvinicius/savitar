@extends('adminlte::page')
@section('title', $title)

@section("css")
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>

    <style>
        .iframe-bi-application {
            width: 100%;
            height: 90vh;
        }
    </style>
@stop


@section('content')
    <div id="content-report">
        <iframe title="Central Dashboard"
            class="iframe-bi-application"
            src="https://app.powerbi.com/reportEmbed?reportId=069625b3-8a53-4544-97b5-1f32b6c7f774&autoAuth=true&ctid=cf72e2bd-7a2b-4783-bdeb-39d57b07f76f&config=eyJjbHVzdGVyVXJsIjoiaHR0cHM6Ly93YWJpLXNvdXRoLWNlbnRyYWwtdXMtcmVkaXJlY3QuYW5hbHlzaXMud2luZG93cy5uZXQvIn0%3D"
            frameborder="0" allowFullScreen="true"
        ></iframe>
    </div>
@stop

@section("js")
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

@stop
