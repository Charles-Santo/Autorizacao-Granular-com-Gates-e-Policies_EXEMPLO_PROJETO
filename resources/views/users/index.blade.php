@extends('layout.main_layout')

@section('titulo', 'Gerenciamento de Usuários')

@section('conteudo')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Controle de Usuários e Cargos</h2>
        <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Voltar aos Produtos</a>
    </div>

    <!-- Proteção visual extra com Gate global -->
    @can('gerenciar-usuarios')
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cargo (Role)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'gerente' ? 'warning' : 'info') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="alert alert-danger">
            Acesso negado. Apenas administradores podem visualizar esta área.
        </div>
    @endcan
</div>
@endsection