@extends('admin.master')

@section('head')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('content')
    <x-page-header title="{{ $subtitle }}" />

    <div id="content-users-groups-create">
        <form action="{{ route('admin.users-groups.store') }}" method="post">
            @csrf

            <div class="form-row-user">
                <div class="form-group">
                    <label for="name">Nome do Grupo</label>
                    <input type="text" name="name" id="name">
                </div>

                <div class="form-group btn-send">
                    <button type="submit">Salvar</button>
                </div>
            </div>

            <div class="form-group-permissions">

                <span class="title-permissions">Permissões</span>

                @foreach ($perms as $key_perm => $value_perm)
                    @if ($key_perm == 'pages')
                        <div id="permis-pages">
                            <span>Páginas</span>
                            <hr />
                            <div class="perm-box-input">
                                @foreach ($value_perm as $item_item)
                                    <div class="perm-group-input">
                                        <input type="checkbox" name="permissions[]" id="{{ $item_item->service }}"
                                            value="{{ $item_item->service }}">
                                        <label for="{{ $item_item->service }}">{{ $item_item->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div id="permis-actions">
                            <span>Ações</span>
                            <hr />
                            <div class="perm-box-input">
                                @foreach ($value_perm as $item_item)
                                    <div class="perm-group-input">
                                        <input type="checkbox" name="permissions[]" id="{{ $item_item->service }}"
                                            value={{ $item_item->service }}>
                                        <label for="{{ $item_item->service }}">{{ $item_item->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>

        </form>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @if (session('message') && session('status'))
        <script>
            let status = "{{ session('status') }}"; // Recupera o status.
            // Caso o status seja de sucesso, será exibido uma mensagem do tipo Success.
            if (status === "Success") {
                toastr.success('{{ session('message') }}')
            }
            // Retornar uma mensagem de erro caso o tipo seja Error.
            else {
                toastr.error('{{ session('message') }}')
            }
        </script>
    @endif
@endsection
