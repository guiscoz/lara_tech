<header class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container justify-space-evenly">
            <a class="navbar-brand" href="/">LaraTech</a>
            <ul class="navbar-nav">
                @auth
                    @can('Gerenciar permissões')
                        <li class="nav-item">
                            <a href="{{route('permissions')}}" class="nav-link">Gerenciar permissões</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('roles')}}" class="nav-link">Gerenciar perfis</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('users')}}" class="nav-link">Gerenciar usuários</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a href="{{ route('logout') }}"
                                class="nav-link"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();"
                            >
                                Sair
                            </a>
                        </form>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Cadastrar</a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</header>
