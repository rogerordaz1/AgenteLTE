<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="mt-3 pb-3 mb-3 d-flex">
        {{-- Este es el Boton de desloguear el usuario...... --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <div class="dropdown">
                <div class="info">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Usuario:
                        {{ Auth::user()->name }}</a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href=""
                                onclick="event.preventDefault();this.closest('form').submit();">Cerrar Session</a>

                        </li>

                    </ul>

                </div>

        </form>
    </div>
</div>


<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->



             <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"> 
                    <i class="nav-icon fab fa-teamspeak"></i>                   
                    <p>
                        Panel de Control
                        {{-- <span class="right badge badge-danger">New</span> --}}
                    </p>
                </a>
            </li>     
        <li class="nav-item  {{ request()->is('user/profile') ? 'menu-open' : 'menu-close' }}">
            <a href="#" class="nav-link {{ 'user/profile' == request()->path() ? 'active' : '' }}">
                <i class="mr-2 fas fa-solid fa-clipboard"></i>
                <p>
                    Ajustes de Cuenta
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/user/profile"
                        class="nav-link {{ request()->is('/user/profile') ? 'active' : '' }}
                        
                        ">

                        <i class="fas fa-solid fa-address-card"></i>
                        <p>Perfil de Usuario</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="fas fa-key"></i>
                        <p>Recuperar Contrasena</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Despues Cada vez que valla haciendo Algo con los links de la apk ir ajustando los li con los active................. --}}
        @can('dashboard.users.index')
            <li class="nav-item">
                <a href="{{ route('dashboard.xmlfile') }}"
                    class="nav-link {{ request()->is('dashboard/xmlfiles') || request()->is('dashboard/xmlfiles/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-shield"></i>
                    <p>
                        Actualizar BD
                        {{-- <span class="right badge badge-danger">New</span> --}}
                    </p>
                </a>
            </li>
        @endcan
        @can('dashboard.users.index')
            <li class="nav-item">
                <a href="{{ route('dashboard.roles.index') }}"
                    class="nav-link {{ request()->is('dashboard/roles') || request()->is('dashboard/roles/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-shield"></i>
                    <p>
                        Roles
                        {{-- <span class="right badge badge-danger">New</span> --}}
                    </p>
                </a>
            </li>
        @endcan
        @can('dashboard.roles.index')
            <li class="nav-item ">
                <a href="/dashboard/users"
                    class="nav-link {{ request()->is('dashboard/users') || request()->is('dashboard/users/*') ? 'active' : '' }}">


                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Usuarios
                        {{-- <span class="right badge badge-danger">New</span> --}}
                    </p>
                </a>
            </li>
        @endcan

        <li class="nav-item">
            <a href="{{ route('dashboard.ocomerciales.index') }}"
             class="nav-link {{ request()->is('dashboard/ocomerciales') || request()->is('dashboard/ocomerciales/*') ? 'active' : '' }}">


                <i class="nav-icon fas fa-landmark"></i>
                <p>
                    Oficinas Comerciales
                    {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                {{-- <i class="nav-icon fas fa-th"></i> --}}

                <i class="nav-icon fas fa-user-tag"></i>

                <p>
                    Agentes
                    {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dashboard.clientes.index') }}" 
            class="nav-link {{ request()->is('dashboard/clientes') || request()->is('dashboard/clientes/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Clientes
                    {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>

    </ul>
</nav>
<!-- /.sidebar-menu -->
</div>
