<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'subtotal',
        'frete',
        'cep',
        'status'
    ];

    const STATUS_PENDENTE   = 'pendente';
    const STATUS_PAGO       = 'pago';
    const STATUS_ENVIADO    = 'enviado';
    const STATUS_CANCELADO  = 'cancelado';

    public static function statusList()
    {
        return [
            self::STATUS_PENDENTE,
            self::STATUS_PAGO,
            self::STATUS_ENVIADO,
            self::STATUS_CANCELADO
        ];
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
