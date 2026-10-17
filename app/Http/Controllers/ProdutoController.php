<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Produto::class);
        
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        $this->authorize('create', Produto::class);
        
        return view('produtos.form');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Produto::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:produtos,sku',
            'current_stock' => 'required|integer|min:0',
        ]);

        Produto::create($request->all());

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        $this->authorize('update', $produto);

        return view('produtos.form', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $this->authorize('update', $produto);

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:produtos,sku,' . $produto->id,
        ]);

        $produto->update($request->only(['name', 'sku']));

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $this->authorize('delete', $produto);

        $produto->delete();
        
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}