<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PedidoItem extends Model
{
    use HasFactory;

    protected $table = 'pedido_itens';
    
    protected $fillable = [
        'pedido_id',
        'produto_id',
        'variacao',
        'quantidade',
        'preco_unitario'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
