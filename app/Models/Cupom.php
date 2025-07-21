<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Cupom extends Model
{
    use HasFactory;
    protected $table = 'cupons';

    protected $fillable = [
        'codigo',
        'valor',
        'percentual',
        'valor_minimo',
        'validade'
    ];

    public function isValido($subtotal)
    {
        return Carbon::now()->lte($this->validade) && $subtotal >= $this->valor_minimo;
    }

    public function aplicarDesconto($subtotal)
    {
        if ($this->percentual) {
            return $subtotal * ($this->valor / 100);
        }
        return $this->valor;
    }
}
