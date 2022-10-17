<div id="root-sidebar-content">
    <div class="content-logo">
        <a href="{{ route('admin.home.page') }}">
            <img class="logo" src="{{ Vite::asset('resources/assets/Sigma.png') }}"/>
        </a>
    </div>

    <div class="menu-content">
        <ul class="">
            <div class="sidebar-separate">
                <span>Aplicação</span>
            </div>

            <a href="{{ route('admin.home.page') }}" class="menu-ancor-link">
                <li class="menu-item">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </li>
            </a>

            <div class="sidebar-separate">
                <span>Administração</span>
            </div>

            <a class="menu-ancor-link">
                <li class="menu-item" id="handle-users-dropdown">
                    <i class="fa-solid fa-users"></i>
                    Usuários
                </li>
            </a>
            <ul class="side-dropdown-container" handle="handle-users-dropdown">
                <a href="{{ route('admin.users.list') }}">
                    <li class="submenu-item">Todos os Usuários</li>
                </a>   
                
                <a href="#">
                    <li class="submenu-item">
                        <i class="fa-solid fa-plus"></i>
                        Criar
                    </li>
                </a>
            </ul>

            <a class="menu-ancor-link">
                <li class="menu-item" id="handle-groups-dropdown">
                    <i class="fa-solid fa-user-group"></i>
                    Grupos
                </li>
            </a>

            <ul class="side-dropdown-container" handle="handle-groups-dropdown">
                <a href="#">
                    <li class="submenu-item">Todos os Grupos</li>
                </a>   
                
                <a href="#">
                    <li class="submenu-item">
                        <i class="fa-solid fa-plus"></i>
                        Criar
                    </li>
                </a>
            </ul>

            <a class="menu-ancor-link">
                <li class="menu-item" id="handle-keys-dropdown">
                    <i class="fa-sharp fa-solid fa-key"></i>
                    Api
                </li>
            </a>
            <ul class="side-dropdown-container" handle="handle-keys-dropdown">
                <a href="#">
                    <li class="submenu-item">Todas as Chaves</li>
                </a>   
                
                <a href="#">
                    <li class="submenu-item">
                        <i class="fa-solid fa-plus"></i>
                        Criar
                    </li>
                </a>
            </ul>

            <div class="sidebar-separate">
                <span>Conta</span>
            </div>

            <a href="#" class="menu-ancor-link">
                <li class="menu-item">
                    <i class="fa-solid fa-user"></i>
                    Perfil
                </li>
            </a>

            <a href="{{ route('admin.logout') }}" class="menu-ancor-link">
                <li class="menu-item">
                    <i class="fa-solid fa-door-open"></i>
                    Sair
                </li>
            </a>

        </ul>
    </div>
</div>