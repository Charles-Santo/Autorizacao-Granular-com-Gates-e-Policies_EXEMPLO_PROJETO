@extends('layout.main_layout')

@section('titulo', 'Histórico de Movimentações')

@section('conteudo')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Histórico de Movimentações de Estoque</h2>
        <div>
            <a href="{{ route('movimentacoes.create') }}" class="btn btn-primary me-2">Nova Movimentação</a>
            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Voltar aos Produtos</a>
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
                        <th>Data / Hora</th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Quantidade</th>
                        <th>Usuário</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movimentacoes as $mov)
                    <tr>
                        <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $mov->produto->name ?? 'Removido' }} <code>({{ $mov->produto->sku ?? '-' }})</code></td>
                        <td>
                            <span class="badge bg-{{ $mov->tipo === 'entrada' ? 'success' : 'danger' }}">
                                {{ ucfirst($mov->tipo) }}
                            </span>
                        </td>
                        <td><strong>{{ $mov->quantidade }}</strong></td>
                        <td>{{ $mov->user->name ?? 'Desconhecido' }}</td>
                        <td>{{ $mov->motivo ?: 'Nenhum motivo informado' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhuma movimentação registrada até o momento.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection