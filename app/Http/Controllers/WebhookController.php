<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function receber(Request $request)
    {
        $request->validate([
            'pedido_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        $pedido = Pedido::find($request->pedido_id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido não encontrado.'], 404);
        }

        if (strtolower($request->status) === Pedido::STATUS_CANCELADO) {
            $pedido->delete();
            return response()->json(['message' => 'Pedido cancelado e removido com sucesso.']);
        } else {
            if (!in_array(strtolower($request->status), Pedido::statusList())) {
                return response()->json(['message' => 'Status inválido.'], 400);
            }
            $pedido->status = strtolower($request->status);
            $pedido->save();
            return response()->json(['message' => 'Status do pedido atualizado com sucesso.']);
        }
    }
}
