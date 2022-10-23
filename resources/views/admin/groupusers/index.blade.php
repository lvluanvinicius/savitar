@extends('admin.master')

@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
@endsection

@section('content')
    <x-page-header title="{{ $subtitle }}" />

    <div id="content-users-groups">
        <table id="group-users-table" class="display responsive nowrap">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Permissões</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group_users as $gpuser)
                    <tr>
                        <td>{{ $gpuser->name }}</td>
                        <td>{{ $gpuser->permissions }}</td>
                        <td>{{ $gpuser->id }}</td>
                        <td>{{ $gpuser->id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#group-users-table').DataTable({
                responsive: true,
            });
        });
    </script>
@endsection
