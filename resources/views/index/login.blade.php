@extends('adminlte::auth.login')
{{-- @extends('adminlte::adminlte.login_message', false) --}}

@section('css')
    <link rel="icon" href="{{ asset('assets/admin/img/api.png') }}"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href={{ asset('assets/admin/css/admin.custom.css') }}>
    <style>
        .login-page {
            background: url('assets/admin/img/savitar02.png');
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .login-logo a {
            letter-spacing: 6px;
            font-size: 2.4rem;
            font-weight: 600;
            color: white;
            text-shadow: 2px 2px 6px rgb(0, 213, 255);
        }

        .login-box {
            color: white;

        }
        .login-box .card.card-outline.card-primary {
            border: 1px solid rgba(0, 213, 255, 0.155);
            box-shadow: 1px 1px 15px rgba(0, 213, 255, 0.163);
        }

        .login-box .card.card-outline.card-primary,
        .login-box .card-body.login-card-body {
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.277);

        }

        .login-box .card-body.login-card-body{
        }

        .icheck-primary {
            display: none;
        }
    </style>
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
@stop
