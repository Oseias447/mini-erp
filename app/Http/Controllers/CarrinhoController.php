<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Pedido;
use App\Models\Cupom;
use App\Mail\PedidoFinalizadoMail;
use Illuminate\Support\Facades\Mail;

class CarrinhoController extends Controller
{
    public function index() {
        $produtos = Produto::with('estoques')->get();
        return view('carrinho.index', compact('produtos'));
    }

    public function checkout()
    {
        $carrinho = session()->get('carrinho', []);

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        if ($subtotal >= 200) {
            $frete = 0;
        } elseif ($subtotal >= 52 && $subtotal <= 166.59) {
            $frete = 15;
        } else {
            $frete = 20;
        }

        $desconto = session('cupom.desconto', 0);
        $total = $subtotal + $frete - $desconto;

        return view('carrinho.checkout', compact('carrinho', 'subtotal', 'frete', 'desconto', 'total'));
    }



    public function remover($key)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$key])) {
            unset($carrinho[$key]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('carrinho.index')->with('success', 'Item removido do carrinho!');
    }


    public function add(Request $request)
    {
        $produto = Produto::findOrFail($request->produto_id);
        $estoque = Estoque::findOrFail($request->variacao_id);
    
        $carrinho = session()->get('carrinho', []);
    
        $key = $produto->id . '-' . $estoque->id;
    
        if (isset($carrinho[$key])) {
            $carrinho[$key]['quantidade'] += 1;
        } else {
            $carrinho[] = [
                'produto_id' => $produto->id,
                'produto'    => $produto->nome,
                'variacao'   => $estoque->variacao,
                'variacao_id' => $estoque->id,
                'preco'      => $produto->preco,
                'quantidade' => 1
            ];
        }
    
        session()->put('carrinho', $carrinho);
    
        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function finalizar(Request $request)
    {
        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        if ($subtotal >= 200) {
            $frete = 0;
        } elseif ($subtotal >= 52 && $subtotal <= 166.59) {
            $frete = 15;
        } else {
            $frete = 20;
        }

        $desconto = session('cupom.desconto', 0);
        $total = $subtotal + $frete - $desconto;

        $pedido = Pedido::create([
            'total' => $total,
            'subtotal' => $subtotal,
            'frete' => $frete,
            'cep' => $request->cep,
            'status' => Pedido::STATUS_PENDENTE
        ]);

        foreach ($carrinho as $item) {
            $pedido->itens()->create([
                'produto_id' => $item['produto_id'],
                'variacao' => $item['variacao'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['preco']
            ]);

            $estoque = Estoque::find($item['variacao_id']);
            if ($estoque) {
                $estoque->quantidade -= $item['quantidade'];
                $estoque->save();
            }
        }

        // Enviar e-mail
        // Mail::to($request->email)->send(new PedidoFinalizadoMail($pedido));

        session()->forget('carrinho');
        session()->forget('cupom');

        return redirect()->route('produtos.index')->with('success', 'Pedido realizado e e-mail enviado!');
    }

    public function aplicarCupom(Request $request)
    {
        $codigo = $request->input('codigo_cupom');
        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return back()->with('error', 'Seu carrinho está vazio para aplicar cupom.');
        }

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        $cupom = Cupom::where('codigo', $codigo)->first();

        if (!$cupom) {
            return back()->with('error', 'Cupom inválido.');
        }

        if (!$cupom->isValido($subtotal)) {
            return back()->with('error', 'Cupom expirado ou subtotal insuficiente.');
        }

        $desconto = $cupom->aplicarDesconto($subtotal);

        session([
            'cupom' => [
                'codigo' => $cupom->codigo,
                'desconto' => $desconto,
            ]
        ]);

        return back()->with('success', "Cupom aplicado! Desconto de R$ " . number_format($desconto, 2, ',', '.'));
    }
}