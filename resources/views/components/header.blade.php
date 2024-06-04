<header class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container justify-space-evenly">
            <a class="navbar-brand" href="/">LaraTech</a>
            <ul class="navbar-nav">
                @auth
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
