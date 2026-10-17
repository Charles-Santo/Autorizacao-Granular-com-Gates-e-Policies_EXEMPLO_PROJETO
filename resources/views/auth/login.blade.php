@extends('layout.main_layout')

@section('titulo', 'Login - Controle de Estoque')

@section('conteudo')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Acessar Sistema</h4>
                </div>
                <div class="card-body p-4">
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>

                    <hr class="my-4">
                    
                    <div class="text-muted small">
                        <p class="mb-1"><strong>Dica para teste:</strong> Use os emails do seeder:</p>
                        <ul class="mb-0 ps-3">
                            <li><code>operador@empresa.com</code></li>
                            <li><code>gerente@empresa.com</code></li>
                            <li><code>admin@empresa.com</code></li>
                            <li>Senha: senha123</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection