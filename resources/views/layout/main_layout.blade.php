<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo', 'Controle de Estoque')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/img/icon.png') }}" type="image/png" sizes="32x32">
</head>

<body>
    <!-- Barra de Navegação Superior (Exibida apenas se estiver logado) -->
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('produtos.index') }}">Controle de Estoque</a>
            
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item text-light me-3">
                        Usuário: <strong>{{ Auth::user()->name }}</strong> 
                        <span class="badge bg-secondary ms-1">{{ ucfirst(Auth::user()->role) }}</span>
                    </li>

                    <!-- Botão de usuários visível apenas para o Admin (via Gate) -->
                    @can('gerenciar-usuarios')
                    <li class="nav-item me-2">
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-light">Gerenciar Usuários</a>
                    </li>
                    @endcan

                    <!-- Botão de Logout -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Sair</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <main class="container">
        @yield('conteudo')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>