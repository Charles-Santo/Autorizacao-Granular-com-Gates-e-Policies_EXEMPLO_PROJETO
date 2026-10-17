@extends('layout.main_layout')

@section('titulo', isset($produto) ? 'Editar Produto' : 'Novo Produto')

@section('conteudo')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">{{ isset($produto) ? 'Editar Produto' : 'Cadastrar Novo Produto' }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($produto) ? route('produtos.update', $produto->id) : route('produtos.store') }}" method="POST">
                        @csrf
                        @if(isset($produto))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $produto->name ?? '') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU (Código Único)</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $produto->sku ?? '') }}" required>
                            @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        @if(!isset($produto))
                        <div class="mb-3">
                            <label for="current_stock" class="form-label">Estoque Inicial</label>
                            <input type="number" class="form-control @error('current_stock') is-invalid @enderror" id="current_stock" name="current_stock" value="{{ old('current_stock', 0) }}" min="0" required>
                            @error('current_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection