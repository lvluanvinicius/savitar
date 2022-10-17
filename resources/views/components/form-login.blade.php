<div>
    <form class="form-login" action="{{ route('login.do') }}" method="POST">
        @csrf

        <div class="group-input">
            <input class="input-control" type="text" name="username" id="username" placeholder="Usuário">
        </div>

        <div class="group-input">
            <input class="input-control" type="password" name="password" id="password" placeholder="Senha">
        </div>

        <div class="group-input">
            <input class="input-button" type="submit" name="send_login" id="login_action" value="Entrar">
        </div>
    </form>
</div>