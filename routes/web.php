<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CupomController;

Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::post('/carrinho/adicionar', [CarrinhoController::class, 'add'])->name('carrinho.add');
Route::post('/pedido/finalizar', [CarrinhoController::class, 'finalizar'])->name('pedido.finalizar');
Route::delete('/carrinho/remover/{key}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::get('/carrinho/checkout', [CarrinhoController::class, 'checkout'])->name('pedido.checkout');
Route::post('/carrinho/aplicar-cupom', [CarrinhoController::class, 'aplicarCupom'])->name('carrinho.aplicarCupom');
Route::resource('cupons', CupomController::class)->except(['show', 'edit', 'update']);
Route::resource('produtos', ProdutoController::class);
Route::get('/', function () {
    return view('welcome');
});
