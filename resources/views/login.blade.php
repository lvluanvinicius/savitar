<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="{{ csrf_token() }}" name="csrf_token">
    <title>{{ $title }}</title>
    @vite([
        'resources/css/login.css', 
        'resources/js/login.js', 
    ])
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body>
    <div id="root-app-body">
        <div class="content-login">
            <div id="logo-login">
                <h1>{{ env('APP_NAME') }}</h1>
            </div>
            
            <x-form-login/>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
</body>
</html>
