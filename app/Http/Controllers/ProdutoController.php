<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('estoques')->get();
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $produto = Produto::create($request->only('nome', 'preco'));
        foreach ($request->variacoes as $variacao) {
            if (!isset($variacao['quantidade'])) {
                continue;
            }
            $produto->estoques()->create([
                'variacao' => $variacao['nome'],
                'quantidade' => $variacao['quantidade'],
            ]);
        }
 
        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }


    public function edit(Produto $produto)
    {
        $produto->load('estoques');
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $produto->update($request->only('nome', 'preco'));
        $produto->estoques()->update(['quantidade' => $request->quantidade]);
        return redirect()->route('produtos.index');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index');
    }
}
