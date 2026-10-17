@extends('layout.main_layout')

@section('titulo', 'Controle de Estoque - Produtos')

@section('conteudo')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista de Produtos</h2>
        <div>
            <a href="{{ route('movimentacoes.index') }}" class="btn btn-info text-white">Ver Histórico</a>
            <!-- Apenas quem tem permissão para criar produtos (Gerente/Admin) -->
            @can('create', App\Models\Produto::class)
                <a href="{{ route('produtos.create') }}" class="btn btn-success">Novo Produto</a>
            @endcan

            <!-- Gate global para movimentação (Operador, Gerente, Admin) -->
            @can('fazer-movimentacao')
                <a href="{{ route('movimentacoes.create') }}" class="btn btn-primary">Movimentar Estoque</a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nome do Produto</th>
                        <th>Estoque Atual</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produtos as $produto)
                    <tr>
                        <td><code>{{ $produto->sku }}</code></td>
                        <td>{{ $produto->name }}</td>
                        <td>
                            <span class="badge bg-{{ $produto->current_stock > 5 ? 'secondary' : 'danger' }}">
                                {{ $produto->current_stock }}
                            </span>
                        </td>
                        <td class="text-end">
                            <!-- Policy de Update -->
                            @can('update', $produto)
                                <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            @endcan

                            <!-- Policy de Delete (Admin) -->
                            @can('delete', $produto)
                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Nenhum produto cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection