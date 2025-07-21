<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class Estoque extends Model
{
    protected $fillable = ['id', 'produto_id', 'variacao', 'quantidade'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}