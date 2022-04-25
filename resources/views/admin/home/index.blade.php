@extends('adminlte::page')
@section('title', $title)

@section('css')
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>
@stop

@section('content_header')

@stop

@section('content')
    @if (checkNivel(auth()->user()->id, "*") || checkNivel(auth()->user()->id, "dash"))
        <section>
            <div class="row pt-3">

                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $qnt_users }}</h3>

                        <p>Usuários cadastrados.</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{ route('admin.users') }}" class="small-box-footer">
                        Ver mais <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $qnt_keys }}</h3>

                        <p>Chaves cadastradas.</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <a href="{{ route('admin.apis.list') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Chaves cadastradas.</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <a href="{{ route('admin.apis.list') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Chaves cadastradas.</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <a href="{{ route('admin.apis.list') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    </div>
                </div>

            </div>
        </section>
    @endif
@stop


@section('js')

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
