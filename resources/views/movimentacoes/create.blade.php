@extends('layout.main_layout')

@section('titulo', 'Movimentação de Estoque')

@section('conteudo')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Registrar Movimentação de Estoque</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('movimentacoes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="produto_id" class="form-label">Produto</label>
                            <select name="produto_id" id="produto_id" class="form-select @error('produto_id') is-invalid @enderror" required>
                                <option value="">Selecione um produto...</option>
                                @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}">{{ $produto->name }} (Estoque atual: {{ $produto->current_stock }})</option>
                                @endforeach
                            </select>
                            @error('produto_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Movimentação</label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                            @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" class="form-control @error('quantidade') is-invalid @enderror" id="quantidade" name="quantidade" min="1" required>
                            @error('quantidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo / Observação</label>
                            <textarea class="form-control @error('motivo') is-invalid @enderror" id="motivo" name="motivo" rows="3"></textarea>
                            @error('motivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Registrar Movimentação</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection