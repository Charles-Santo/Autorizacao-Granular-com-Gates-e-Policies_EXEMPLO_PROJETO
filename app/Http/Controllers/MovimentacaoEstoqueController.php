<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovimentacaoEstoqueController extends Controller
{

    public function index()
    {
        // Garante que apenas quem tem permissão de movimentar veja o histórico
        Gate::authorize('fazer-movimentacao');

        // Busca as movimentações ordenadas da mais recente para a mais antiga
        $movimentacoes = MovimentacaoEstoque::with(['produto', 'user'])->latest()->get();

        return view('movimentacoes.index', compact('movimentacoes'));
    }
    public function create()
    {
        // Protege a rota usando o Gate global que definimos no AppServiceProvider
        Gate::authorize('fazer-movimentacao');

        $produtos = Produto::all();
        return view('movimentacoes.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        Gate::authorize('fazer-movimentacao');

        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'tipo' => 'required|in:entrada,saida',
            'quantidade' => 'required|integer|min:1',
            'motivo' => 'nullable|string',
        ]);

        // Usa transação para garantir consistência no estoque
        DB::transaction(function () use ($request) {
            $produto = Produto::findOrFail($request->produto_id);

            // Validação simples de estoque na saída
            if ($request->tipo === 'saida' && $produto->current_stock < $request->quantidade) {
                abort(422, 'Estoque insuficiente para esta saída.');
            }

            // Registra a movimentação vinculando o usuário logado
            MovimentacaoEstoque::create([
                'produto_id' => $produto->id,
                'user_id' => Auth::id(),
                'tipo' => $request->tipo,
                'quantidade' => $request->quantidade,
                'motivo' => $request->motivo,
            ]);

            // Atualiza o estoque atual do produto
            if ($request->tipo === 'entrada') {
                $produto->current_stock += $request->quantidade;
            } else {
                $produto->current_stock -= $request->quantidade;
            }

            $produto->save();
        });

        return redirect()->route('produtos.index')->with('success', 'Movimentação registrada com sucesso!');
    }
}