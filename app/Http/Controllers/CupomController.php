<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use Illuminate\Http\Request;

class CupomController extends Controller
{
    public function index()
    {
        $cupons = Cupom::all();
        return view('cupons.index', compact('cupons'));
    }

    public function create()
    {
        return view('cupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:cupons,codigo',
            'valor' => 'required|numeric',
            'percentual' => 'required|boolean',
            'valor_minimo' => 'required|numeric',
            'validade' => 'required|date'
        ]);

        Cupom::create($request->all());

        return redirect()->route('cupons.index')->with('success', 'Cupom criado com sucesso!');
    }

    public function destroy(Cupom $cupom)
    {
        $cupom->delete();
        return redirect()->route('cupons.index')->with('success', 'Cupom excluído com sucesso!');
    }
}
