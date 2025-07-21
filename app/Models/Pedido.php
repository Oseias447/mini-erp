<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'subtotal',
        'frete',
        'total',
        'cep'
    ];

    public function itens()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
